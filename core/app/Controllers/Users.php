<?php

namespace App\Controllers;

use App\Models\LogModel;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Config\Auth as AuthConfig;

class Users extends BaseController
{
    protected $auth;
    protected $config;
    protected $requireActivation;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    public function index()
    {
        //$userModel = new UserModel();
        //$data['users'] = $userModel->findAll();

        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id, users.username, users.active, users.email, auth_groups.description, auth_groups.name as nama_grup, auth_groups_users.group_id');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $builder->orderBy('auth_groups_users.group_id', 'asc');

        $query = $builder->get()->getResultObject();

        $data['users'] = $query;

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group'] = $groupModel->getGroupsForUser($row->id);
            $dataRow['row'] = $row;
            $data['row' . $row->id] = empty($group) ? '' : $group[0]['name'];
        }

        $data['groups'] = $groupModel->findAll();
        $data['title'] = 'Kelola Akun';
        $data['menu'] = 'user';
        return view('users/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Akun';
        $data['menu'] = 'user';
        return view('users/tambah', $data);
    }

    public function save()
    {
        $users = model(UserModel::class);

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->select('users.id, users.username, users.active, users.email, auth_groups.description, auth_groups.name as nama_grup, auth_groups_users.group_id')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->orderBy('users.id', 'desc')
            ->limit(1)->get()->getResultArray();

        $username_baru = $user[0]['username'];
        $role = $user[0]['description'];

        $logModel = new LogModel();
        $username = user()->username;
        $deskripsi = $username . " menambahkan user baru <b>" . $username_baru . "</b> dengan role <b>" . $role . "</b>";
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'tambah-user',
        ];
        $logModel->save($datalog);

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->to(base_url('/users/index'));
        }

        // Success!
        return redirect()->to(base_url('/users/index'));
    }

    public function activate()
    {
        $userModel = new UserModel();
        if ($this->request->getVar('active') == 0 || '') {
            $active = '1';
        } else {
            $active = '0';
        }

        $data = [
            'activate_hash' => null,
            'active' =>  $active,
        ];
        $userModel->update($this->request->getVar('id'), $data);

        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->select('users.id, users.username, users.active, users.email, auth_groups.description, auth_groups.name as nama_grup, auth_groups_users.group_id')
            ->where('users.id', $this->request->getVar('id'))
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->orderBy('users.id', 'desc')
            ->limit(1)->get()->getResultArray();

        $username_baru = $user[0]['username'];
        $cek_status = $user[0]['active'];
        if ($cek_status == 0) {
            $status = "<b>Aktif</b> menjadi <b>Tidak Aktif</b>";
        } else {
            $status = "<b>Tidak Aktif</b> menjadi <b>Aktif</b>";
        }

        $logModel = new LogModel();
        $username = user()->username;
        $deskripsi = $username . " mengupdate user <b>" . $username_baru . "</b> dari status " . $status;
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-user',
        ];
        $logModel->save($datalog);

        return redirect()->to(base_url('/users/index'));
    }

    public function changePassword($id = null)
    {
        if ($id == null) {
            return redirect()->to(base_url('/users/index'));
        } else {
            $data['id'] = $id;
            $data['title'] = 'Update Password';
            $data['menu'] = 'user';
            return view('users/set_password', $data);
        }
    }

    public function setPassword()
    {
        $id = $this->request->getVar('id');
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
                'validation' => $this->validator,
            ];

            return view('users/changePassword/' . $id, $data);
        } else {
            $userModel = new UserModel();
            $data = [
                'password_hash' => Password::hash($this->request->getVar('password')),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $userModel->update($this->request->getVar('id'), $data);

            $db      = \Config\Database::connect();
            $builder = $db->table('users');
            $user = $builder->select('users.id, users.username, users.active, users.email, auth_groups.description, auth_groups.name as nama_grup, auth_groups_users.group_id')
                ->where('users.id', $this->request->getVar('id'))
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
                ->orderBy('users.id', 'desc')
                ->limit(1)->get()->getResultArray();

            $username_baru = $user[0]['username'];

            $logModel = new LogModel();
            $username = user()->username;
            $deskripsi = $username . " mengupdate password user <b>" . $username_baru . "</b>";
            $datalog = [
                'tgl' => date("Y-m-d H:i:s"),
                'akun' => $username,
                'deskripsi' => $deskripsi,
                'tipe_log' => 'update-password',
            ];
            $logModel->save($datalog);

            return redirect()->to(base_url('users/changePassword'));
        }
    }

    public function changeGroup()
    {
        $userId = $this->request->getVar('id_user');
        $groupId = $this->request->getVar('group');
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->select('users.id, users.username, users.active, users.email, auth_groups.description, auth_groups.name as nama_grup, auth_groups_users.group_id')
            ->where('users.id', $this->request->getVar('id_user'))
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->orderBy('users.id', 'desc')
            ->limit(1)->get()->getResultArray();
        $role_lama = $user[0]['description'];

        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($userId));

        $groupModel->addUserToGroup(intval($userId), intval($groupId));

        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->select('users.id, users.username, users.active, users.email, auth_groups.description, auth_groups.name as nama_grup, auth_groups_users.group_id')
            ->where('users.id', $this->request->getVar('id_user'))
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->orderBy('users.id', 'desc')
            ->limit(1)->get()->getResultArray();

        $username_baru = $user[0]['username'];
        $role_baru = $user[0]['description'];

        $logModel = new LogModel();
        $username = user()->username;
        $deskripsi = $username . " mengupdate role user <b>" . $username_baru . "</b> dari <b>" .
            $role_lama . "</b> menjadi <b>" . $role_baru . "</b>";
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-password',
        ];
        $logModel->save($datalog);

        return redirect()->to(base_url('users/index'));
    }
}
