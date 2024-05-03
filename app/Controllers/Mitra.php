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

use Dompdf\Dompdf;
use Dompdf\Options;

class Mitra extends BaseController
{
    protected $mitraModel;

    public function __construct()
    {
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
            'nama_mitra' => [
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
        $nama_mitra = $this->request->getVar('nama_mitra');
        $penanggung_jawab = $this->request->getVar('penanggung_jawab');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');

        //ambil gambar
        $fileLogo = $this->request->getFile('logo');
        $ext = $fileLogo->getExtension();
        // generate nama file
        $namaFile = date('Y-m-d') . ' - ' . $nama_mitra . '.' . $ext;

        //pindahkan file gambar
        $fileLogo->move('img/logo', $namaFile);

        $logModel = new LogModel();
        $mitraModel = new MitraModel();
        $username = user()->username;

        //Menyimpan Data Awal Kuitansi
        $datamitra = [
            'kode_mitra' => $kode_mitra,
            'nama_mitra' => $nama_mitra,
            'penanggung_jawab' => $penanggung_jawab,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'logo' => $namaFile,
            'status' => '1'
        ];
        $mitraModel->save($datamitra);

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

        return redirect()->to(base_url('/mitra/index'));
    }
}
