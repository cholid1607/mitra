<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\MitraModel;
use App\Models\PembayaranModel;
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
    protected $requireActivation;

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

    public function ajaxSearch()
    {
        $request = service('request');
        $postData = $request->getPost();

        if (!isset($postData['searchTerm'])) {
            // Fetch record
            $mitra = new MitraModel();
            $mitralist = $mitra->select('id_mitra, nama_mitra, kode_mitra')
                ->orderBy('id_mitra')
                ->findAll(5);
        } else {
            $searchTerm = $postData['searchTerm'];

            // Fetch record
            $mitra = new MitraModel();
            $mitralist = $mitra->select('id_mitra, nama_mitra, kode_mitra')
                ->like('nama_mitra', $searchTerm)
                ->orderBy('id_mitra')
                ->findAll(5);
        }
        $data = array();
        foreach ($mitralist as $row) {
            $text = $row['nama_mitra'];
            $kode_mitra = $row['kode_mitra'];

            $data[] = array(
                "id" => $row['id_mitra'],
                "text" => $text . ' (' . $kode_mitra . ')',
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
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

    function mitraAjaxTagihan()
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $datamitra = new MitraModel();
        $data = $datamitra->searchAndDisplayTagihan($search_value, $start, $length);
        $total_count = $datamitra->searchAndDisplayTagihan($search_value); // Total count without pagination
        $filtered_count = $datamitra->searchAndDisplayTagihan($search_value, 0, 0); // Total count for filtered data
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
        $kode_mitra_pelanggan = $this->request->getVar('kode_mitra_pelanggan');
        $nama_mitra = $this->request->getVar('nama_users');
        $penanggung_jawab = $this->request->getVar('penanggung_jawab');
        $usernamemitra = $this->request->getVar('username');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');
        $email = $this->request->getVar('email');

        //ambil gambar
        $fileLogo = $this->request->getFile('logo');
        //dd($fileLogo);
        //pindahkan file gambar
        if (!empty($fileLogo->getTempName())) {
            $ext = $fileLogo->getExtension();
            // generate nama file
            $namaasli = $fileLogo->getRandomName();
            // generate nama file
            $namaFile = date('Y-m-d') . ' - ' . $nama_mitra . ' - ' . $namaasli;
            $fileLogo->move('img/logo', $namaFile);
        } else {
            $namaFile = '';
        }

        $logModel = new LogModel();
        $mitraModel = new MitraModel();
        $username = user()->username;

        //Menyimpan Data Mitra
        $datamitra = [
            'kode_mitra' => $kode_mitra,
            'kode_mitra_pelanggan' => $kode_mitra_pelanggan,
            'nama_mitra' => $nama_mitra,
            'username' => $usernamemitra,
            'penanggung_jawab' => $penanggung_jawab,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'email' => $email,
            'logo' => $namaFile,
            'status' => '1'
        ];


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

        //Simpan Mitra
        $mitraModel->save($datamitra);

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
            return redirect()->to(base_url('/mitra'));
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

        $db      = \Config\Database::connect();
        //Cek Pemasukan Terakhir
        $builder = $db->table('mitra');
        $mitra   = $builder->where('kode_mitra', $kode_mitra)
            ->get()->getFirstRow();

        //Menyimpan Data Pembayaran
        $datapembayaran = [
            'id_mitra' => $mitra->id_mitra,
            'nama_bank' => 'Tunai',
            'rekening' => '',
            'atas_nama' => ''
        ];

        //Simpan Mitra
        $pembayaranModel = new PembayaranModel();
        $pembayaranModel->save($datapembayaran);

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

    public function update()
    {
        $mitraModel = new MitraModel();
        $logModel = new LogModel();
        $username = user()->username;

        $id_mitra = $this->request->getVar('id_mitra');
        $mitra = $mitraModel->where('id_mitra', $id_mitra)->findAll();

        $ceknama_mitra = $mitra[0]['nama_mitra'] == $this->request->getVar('nama_users') ? '' : ',<br/>Nama Mitra <b>' . $mitra[0]['nama_mitra'] . '</b> menjadi <b>' . $this->request->getVar('nama_users') . "</b>";
        $cekpenanggung_jawab = $mitra[0]['penanggung_jawab'] == $this->request->getVar('penanggung_jawab') ? '' : ',<br/>Penanggungjawab <b>' . $mitra[0]['penanggung_jawab'] . '</b> menjadi <b>' . $this->request->getVar('penanggung_jawab') . "</b>";
        $cekalamat = $mitra[0]['alamat'] == $this->request->getVar('alamat') ? '' : ',<br/>Alamat <b>' . $mitra[0]['alamat'] . '</b> menjadi <b>' . $this->request->getVar('alamat') . "</b>";
        $cektelepon = $mitra[0]['telepon'] == $this->request->getVar('telepon') ? '' : ',<br/>Telepon <b>' . $mitra[0]['telepon'] . '</b> menjadi <b>' . $this->request->getVar('telepon') . "</b>";
        $cekemail = $mitra[0]['email'] == $this->request->getVar('email') ? '' : ',<br/>Email <b>' . $mitra[0]['email'] . '</b> menjadi <b>' . $this->request->getVar('email') . "</b>";

        $nama_mitra = !empty($this->request->getVar('nama_users')) ? $this->request->getVar('nama_users') : $mitra[0]['nama_mitra'];
        $penanggung_jawab = !empty($this->request->getVar('penanggung_jawab')) ? $this->request->getVar('penanggung_jawab') : $mitra[0]['penanggung_jawab'];
        $alamat = !empty($this->request->getVar('alamat')) ? $this->request->getVar('alamat') : $mitra[0]['alamat'];
        $telepon = !empty($this->request->getVar('telepon')) ? $this->request->getVar('telepon') : $mitra[0]['telepon'];
        $email = !empty($this->request->getVar('email')) ? $this->request->getVar('email') : $mitra[0]['email'];

        $deskripsi = $username . " mengupdate mitra <b>" . $this->request->getVar('nama_users') . "</b>" .
            $ceknama_mitra .
            $cekpenanggung_jawab .
            $cekalamat .
            $cektelepon .
            $cekemail;

        //ambil gambar
        $fileLogo = $this->request->getFile('logo');
        //dd($fileLogo);
        //pindahkan file gambar
        if (!empty($fileLogo->getTempName())) {
            // Menghapus Gambar Lama

            $file_path = base_url() . '/img/logo/' . $mitra[0]['logo'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $ext = $fileLogo->getExtension();
            $namaasli = $fileLogo->getRandomName();
            // generate nama file
            $namaFile = date('Y-m-d') . ' - ' . $nama_mitra . ' - ' . $namaasli;
            $fileLogo->move('img/logo', $namaFile);
        } else {
            $namaFile = $mitra[0]['logo'];
        }

        $data = [
            'id_mitra' => $id_mitra,
            'nama_mitra' => $nama_mitra,
            'penanggung_jawab' => $penanggung_jawab,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'logo' => $namaFile
        ];

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-mitra',
            'id_mitra' => $this->request->getVar('id_mitra'),
        ];
        $mitraModel->save($data);
        if (
            $ceknama_mitra != '' || $cekpenanggung_jawab != '' || $cekalamat != '' ||
            $cektelepon != ''
        ) {
            $logModel->save($datalog);
        }
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/mitra'));
    }

    public function hapus()
    {
        $mitraModel = new MitraModel();
        $logModel = new LogModel();
        $userModel = model(UserModel::class);
        $username = user()->username;
        $id_mitra = $this->request->getVar('id_mitra');
        $db      = \Config\Database::connect();

        //Cek Pemasukan Terakhir
        $builder = $db->table('mitra');
        $mitra   = $builder->where('id_mitra', $id_mitra)
            ->get()->getResultArray();
        $nama_mitra = $mitra[0]['nama_mitra'];
        $logo = $mitra[0]['logo'];
        $username_mitra = $mitra[0]['username'];
        // Menghapus Gambar Lama

        $file_path = FCPATH . 'img/logo/' . $logo;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $deskripsi = $username . " menghapus mitra <b>" . $nama_mitra;
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'hapus-aset',
        ];
        $logModel->save($datalog);

        $log = $logModel->where('id_mitra', $id_mitra)->first();
        if (!empty($log)) {
            $logModel->where('id_mitra', $id_mitra)->delete();
        }

        $builder_user = $db->table('users');
        $builder_user->where('username', $username_mitra);
        $builder_user->delete();

        $mitraModel->delete($id_mitra);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');

        return redirect()->to('/mitra');
    }

    public function downloadbhp()
    {
        $id_mitra = $this->request->getVar('id_mitra');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $tgl = $tahun . '-' . $bulan . '-10';
        $db = \Config\Database::connect();
        $builder_tagihan = $db->table('pelanggan');
        $tagihan = $builder_tagihan->where('id_mitra', $id_mitra)
            ->where('tgl_registrasi <=', $tgl)
            ->where('status', 1)->get()->getResultArray();
        if ($tagihan == null) {
            session()->setFlashdata('error', 'Pelanggan Tidak Ditemukan');
            return redirect()->to('/mitra');
        }
        $jml_tagihan = $builder_tagihan->where('id_mitra', $id_mitra)
            ->where('tgl_registrasi <=', $tgl)
            ->where('status', 1)->countAllResults();
        $total_tagihan = $builder_tagihan->selectSum('nominal', 'total_tagihan')
            ->where('tgl_registrasi <=', $tgl)
            ->where('id_mitra', $id_mitra)
            ->where('status', 1)->get()->getFirstRow();
        $total_tagihan = $total_tagihan->total_tagihan;
        $total_ppn = $builder_tagihan->selectSum('ppn', 'total_ppn')
            ->where('tgl_registrasi <=', $tgl)
            ->where('id_mitra', $id_mitra)
            ->where('status', 1)->get()->getFirstRow();
        $total_ppn = $total_ppn->total_ppn;
        $total_nominal = $builder_tagihan->selectSum('harga', 'total_nominal')
            ->where('tgl_registrasi <=', $tgl)
            ->where('id_mitra', $id_mitra)
            ->where('status', 1)->get()->getFirstRow();
        $total_nominal = $total_nominal->total_nominal;


        // Menghitung Total BHP
        $total_bhp = $builder_tagihan->selectSum('harga', 'jml_tagihan')
            //->where('tgl_registrasi >=', date('Y-m-10', strtotime('-1 month', strtotime(date('Y-m-10')))))
            ->where('id_mitra', $id_mitra)
            ->where('status', 1)
            ->where('tgl_registrasi <=', $tgl)
            ->get()->getFirstRow();
        if ($total_bhp) {
            $bhp = ($total_bhp->jml_tagihan) * 0.005;
            $uso = ($total_bhp->jml_tagihan) * 0.0125;
            $admin = ($total_bhp->jml_tagihan) * 0.0125;
            $data_total_bhp  = $bhp + $uso + $admin + $total_ppn;
        } else {
            $data_total_bhp = 0;
        }

        $builder_mitra = $db->table('mitra');
        $mitra = $builder_mitra->where('id_mitra', $id_mitra)->get()->getFirstRow();
        $nama_mitra = $mitra->nama_mitra;
        //dd($tagihan);

        //Cek Bulan
        if ($bulan == '01') {
            $bulanhuruf = 'Januari';
        } else if ($bulan == '02') {
            $bulanhuruf = 'Februari';
        } else if ($bulan == '03') {
            $bulanhuruf = 'Maret';
        } else if ($bulan == '04') {
            $bulanhuruf = 'April';
        } else if ($bulan == '05') {
            $bulanhuruf = 'Mei';
        } else if ($bulan == '06') {
            $bulanhuruf = 'Juni';
        } else if ($bulan == '07') {
            $bulanhuruf = 'Juli';
        } else if ($bulan == '08') {
            $bulanhuruf = 'Agustus';
        } else if ($bulan == '09') {
            $bulanhuruf = 'September';
        } else if ($bulan == '10') {
            $bulanhuruf = 'Oktober';
        } else if ($bulan == '11') {
            $bulanhuruf = 'November';
        } else if ($bulan == '12') {
            $bulanhuruf = 'Desember';
        }

        $spreadsheet = new Spreadsheet();

        $data['title'] = 'Daftar Pelanggan';

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PT. Tonggak Teknologi Netikom')
            ->setCellValue('A2', 'Laporan Bulan ' . $bulanhuruf . ' ' . $tahun)
            ->setCellValue('A3', 'Nama Mitra : ' . $nama_mitra);
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
        $spreadsheet->getActiveSheet()->mergeCells('A3:I3');
        $spreadsheet->getActiveSheet()->getStyle('A1:I3')->getFont()->setBold(true);

        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A5', 'No')
            ->setCellValue('B5', 'Tanggal Registrasi')
            ->setCellValue('C5', 'Kode Pelanggan')
            ->setCellValue('D5', 'Nama Pelanggan')
            ->setCellValue('E5', 'NPWP/NIK')
            ->setCellValue('F5', 'Alamat')
            ->setCellValue('G5', 'Berlangganan')
            ->setCellValue('H5', 'Pajak 11%')
            ->setCellValue('I5', 'Total');

        //Array Border
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        //Array Header
        $styleArray2 = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
            ],
        ];

        $jml_tagihan = $jml_tagihan + 5; //Jumah Baris + Header
        $jml_isitagihan = $jml_tagihan + 6; //Jumlah Baris tanpa Header
        $cell_range = 'A5:I' . $jml_tagihan;
        $cell_rangewrap1 = 'F6:F' . $jml_isitagihan;
        $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('Rp#,##0.00'); // Kolom G
        $spreadsheet->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('Rp#,##0.00'); // Kolom H
        $spreadsheet->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('Rp#,##0.00'); // Kolom I



        $spreadsheet->getActiveSheet()->getStyle('A5:I5')->applyFromArray($styleArray2);
        //Border
        $spreadsheet->getActiveSheet()->getStyle('A:I')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //Format Header
        $spreadsheet->getActiveSheet()->getStyle($cell_range)->applyFromArray($styleArray);
        //Wrap Text
        $spreadsheet->getActiveSheet()->getStyle($cell_rangewrap1)->getAlignment()->setWrapText(true);

        $column = 6;
        $no = 1;
        // tulis data mobil ke cell
        foreach ($tagihan as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['tgl_registrasi'])
                ->setCellValue('C' . $column, $data['kode_pelanggan'])
                ->setCellValue('D' . $column, $data['nama_pelanggan'])
                ->setCellValue('E' . $column, "'" . $data['nik_pelanggan'])
                ->setCellValue('F' . $column, $data['alamat_pelanggan'])
                ->setCellValue('G' . $column, $data['harga'])
                ->setCellValue('H' . $column, $data['ppn'])
                ->setCellValue('I' . $column, $data['nominal']);
            $column++;
        }
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':I' . $column)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':F' . $column);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, 'TOTAL')
            ->setCellValue('G' . $column, $total_nominal)
            ->setCellValue('H' . $column, $total_ppn)
            ->setCellValue('I' . $column++, $total_tagihan);
        $column++;
        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':D' . $column);
        $spreadsheet->getActiveSheet()->getStyle('E' . $column)->getNumberFormat()->setFormatCode('Rp#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $column)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':E' . $column)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, "Total yang dibayarkan Pelanggan Union Network")
            ->setCellValue('E' . $column++, $total_tagihan);

        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':D' . $column);
        $spreadsheet->getActiveSheet()->getStyle('E' . $column)->getNumberFormat()->setFormatCode('Rp#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $column)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':E' . $column)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, "Total PPN 11% yang dibayarkan Ke PT. TONGGAK TEKNOLOGI NETIKOM")
            ->setCellValue('E' . $column++, $total_ppn);

        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':D' . $column);
        $spreadsheet->getActiveSheet()->getStyle('E' . $column)->getNumberFormat()->setFormatCode('Rp#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $column)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':E' . $column)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, "Total BHP 0,5% dibayarkan ke PT. TONGGAK TEKNOLOGI NETIKOM")
            ->setCellValue('E' . $column++, $bhp);

        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':D' . $column);
        $spreadsheet->getActiveSheet()->getStyle('E' . $column)->getNumberFormat()->setFormatCode('Rp#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $column)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':E' . $column)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, "Total USO 1,25% dibayarkan ke PT. TONGGAK TEKNOLOGI NETIKOM")
            ->setCellValue('E' . $column++, $uso);

        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':D' . $column);
        $spreadsheet->getActiveSheet()->getStyle('E' . $column)->getNumberFormat()->setFormatCode('Rp#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $column)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':E' . $column)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, "Total Administrasi 1,25% ke PT. TONGGAK TEKNOLOGI NETIKOM")
            ->setCellValue('E' . $column++, $admin);

        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':E' . $column);
        $column++;

        $spreadsheet->getActiveSheet()->mergeCells('A' . $column . ':D' . $column);
        $spreadsheet->getActiveSheet()->getStyle('E' . $column)->getNumberFormat()->setFormatCode('Rp#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $column)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A' . $column . ':E' . $column)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, "Jadi Total kewajiban Pajak PPN dan BHP &USO yang disetorkan ke PT. T2Net")
            ->setCellValue('E' . $column++, $data_total_bhp);


        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Rekap Pelanggan Mitra ' . $nama_mitra . ' Bulan ' . $bulanhuruf . ' ' . $tahun;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        setlocale(LC_ALL, 'en_US');
        ob_end_clean();
        $writer->save('php://output');
    }
}
