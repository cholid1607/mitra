<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\MitraModel;
use App\Models\PendaftaranModel;
use PhpParser\Node\Expr\New_;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Config\Auth as AuthConfig;

use Dompdf\Dompdf;
use Dompdf\Options;

class Mitra extends BaseController
{
    protected $mitraModel;
    protected $auth;
    protected $config;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->mitraModel = new MitraModel();
    }

    public function index(): string
    {
        $mitra = $this->mitraModel->findAll();

        $data['mitra'] = $mitra;
        $data['title'] = 'Kelola Mitra';
        $data['menu'] = 'user';
        return view('mitra/index', $data);
    }

    function mitraAjax()
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $datamitra = new MitraModel();
        $data = $datamitra->searchAndDisplay($search_value, $start, $length);
        $total_count = $datamitra->searchAndDisplay($search_value); // Total count without pagination
        $filtered_count = $datamitra->searchAndDisplay($search_value, 0, 0); // Total count for filtered data
        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($filtered_count),
            'data' => $data,
        );
        echo json_encode($json_data);
    }

    public function tambah(): string
    {
        session();
        $data['title'] = 'Tambah Mitra';
        $data['menu'] = 'user';
        $data['validation'] = \Config\Services::validation();
        //session()->setFlashdata('validation', $validation);
        return view('mitra/tambah', $data);
    }

    public function simpan()
    {

        $rules = [
            'kode_mitra' => [
                'rules' => 'required|is_unique[mitra.kode_mitra]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah digunakan',
                ]
            ],
            'nama_users' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'logo' => [
                'rules' => 'max_size[logo,1024]|is_image[logo]|mime_in[logo,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'File yang anda upload tidak boleh lebih dari 1 MB',
                    'is_image' => 'Anda harus mengunggah file yang berupa gambar',
                    'mime_in' => 'Anda harus mengunggah file yang berupa gambar',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $kode_mitra = $this->request->getVar('kode_mitra');
        $nama_mitra = $this->request->getVar('nama_users');
        $penanggung_jawab = $this->request->getVar('penanggung_jawab');
        $usernamemitra = $this->request->getVar('username');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');

        //ambil gambar
        $fileLogo = $this->request->getFile('logo');
        //dd($fileLogo);
        //pindahkan file gambar
        if (!empty($fileLogo)) {
            $ext = $fileLogo->getExtension();
            // generate nama file
            $namaFile = date('Y-m-d') . ' - ' . $nama_mitra . '.' . $ext;
            $fileLogo->move('img/logo', $namaFile);
        }

        $logModel = new LogModel();
        $mitraModel = new MitraModel();
        $username = user()->username;

        //Menyimpan Data Awal Kuitansi
        $datamitra = [
            'kode_mitra' => $kode_mitra,
            'nama_mitra' => $nama_mitra,
            'username' => $usernamemitra,
            'penanggung_jawab' => $penanggung_jawab,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'logo' => $namaFile,
            'status' => '1'
        ];
        $mitraModel->save($datamitra);

        // Simpan Username
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

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->to(base_url('/mitra/index'));
        }

        // Simpan Log
        $deskripsi = $username . " menambahkan mitra baru a.n <b>" . $nama_mitra . " (" . $kode_mitra . ")</b>";

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'tambah-mitra',
        ];
        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/mitra/index'));
    }

    public function activate()
    {

        $mitraModel = new MitraModel();
        if ($this->request->getVar('active') == 0 || '') {
            $active = '1';
        } else {
            $active = '0';
        }

        $status = $active == 1 ? 'Aktif' : 'Tidak Aktif';

        $logModel = new LogModel();
        $username = user()->username;
        $deskripsi = $username . " mengupdate status mitra " . $this->request->getVar('kode_mitra') . " a.n " . $this->request->getVar('nama_mitra') . " menjadi <b>" . $status . "</b>";
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-mitra',
            'id_mitra' => $this->request->getVar('id_mitra'),
        ];
        $logModel->save($datalog);

        $data = [
            'status' =>  $active,
        ];
        $mitraModel->update($this->request->getVar('id_mitra'), $data);

        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('username', $this->request->getVar('username'))
            ->limit(1)->get()->getResultArray();
        $id_user = $user[0]['id'];
        $userModel = new UserModel();
        $data = [
            'activate_hash' => null,
            'active' =>  $active,
        ];
        $userModel->update($id_user, $data);

        return redirect()->to(base_url('/mitra/index'));
    }

    public function edit($id_mitra = '')
    {
        $db      = \Config\Database::connect();

        //Cek Pemasukan Terakhir
        $builder = $db->table('mitra');
        $mitra   = $builder->where('id_mitra', $id_mitra)
            ->get()->getResultArray();
        //dd($mitra);
        $data = [
            'menu' => 'mitra',
            'title' => 'Edit Mitra',
            'mitra' => $mitra,
        ];

        return view('mitra/edit', $data);
    }

    public function detail($id_mitra = '')
    {
        $db      = \Config\Database::connect();

        //Cek Pemasukan Terakhir
        $builder = $db->table('mitra');
        $mitra   = $builder->where('id_mitra', $id_mitra)
            ->get()->getResultArray();
        //dd($mitra);

        $builder = $db->table('log');
        $log   = $builder->where('id_mitra', $id_mitra)->limit(55)->orderBy('tgl', 'desc')->get()->getResultArray();

        $data = [
            'menu' => 'mitra',
            'title' => 'Detail Mitra',
            'mitra' => $mitra,
            'log' => $log,
        ];

        return view('mitra/detail', $data);
    }
}
