<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\PelangganModel;
use App\Models\PendaftaranModel;
use PhpParser\Node\Expr\New_;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pelanggan extends BaseController
{
    protected $pelangganModel;
    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        $data = [
            'menu' => 'user',
            'title' => 'Detail Pelanggan',
        ];
        //dd($pelanggan);
        return view('pelanggan/index', $data);
    }

    public function daftar($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('log');
        $log   = $builder->where('id_pelanggan', $id)->limit(55)->orderBy('tgl', 'desc')->get()->getResultArray();

        $pelanggan = $this->pelangganModel->where('id_pelanggan', $id)->first();
        //$log = $logModel->where('id_pelanggan', $id)->limit(0,5)->orderBy('tgl', 'desc')->findAll();
        $data = [
            'menu' => 'user',
            'title' => 'Detail Pelanggan',
            'detail' => $pelanggan,
            'id_mitra' => $id,
            'log' => $log,
        ];
        return view('pelanggan/daftar', $data);
    }

    function pelangganAjax($id)
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $datapelanggan = new PelangganModel();
        $data = $datapelanggan->searchAndDisplay($search_value, $id, $start, $length);
        $total_count = $datapelanggan->searchAndDisplay($search_value, $id,);

        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($total_count),
            'data' => $data,
        );
        echo json_encode($json_data);
    }

    public function tambah(): string
    {
        $data['title'] = 'Tambah Pelanggan';
        $data['menu'] = 'user';
        return view('pelanggan/tambah', $data);
    }

    public function detail($id): string
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('log');
        $log   = $builder->where('id_pelanggan', $id)->limit(55)->orderBy('tgl', 'desc')->get()->getResultArray();



        $pelangganModel = new PelangganModel();
        $logModel = new LogModel();
        $pelanggan = $pelangganModel->where('id_pelanggan', $id)->first();
        //$log = $logModel->where('id_pelanggan', $id)->limit(0,5)->orderBy('tgl', 'desc')->findAll();
        $data = [
            'menu' => 'user',
            'title' => 'Detail Pelanggan',
            'detail' => $pelanggan,
            'log' => $log,
        ];
        //dd($pelanggan);
        return view('pelanggan/detail', $data);
    }

    public function simpan()
    {

        $pelangganModel = new PelangganModel();
        $pendaftaranModel = new PelangganModel();
        $logModel = new LogModel();
        $username = user()->username;

        $id_pendaftaran = !empty($this->request->getVar('id_pendaftaran')) ? $this->request->getVar('id_pendaftaran') : '';
        if ($id_pendaftaran != '') {
            $datapendaftaran = [
                'id_pendaftaran' => $id_pendaftaran,
                'status' => '4'
            ];
            $pendaftaranModel->save($datapendaftaran);
            $deskripsi = $username . " meregistrasi data pelanggan a.n <b>" . $this->request->getVar('nama_pelanggan') . "</b>";
            $datalog = [
                'tgl' => date("Y-m-d H:i:s"),
                'akun' => $username,
                'deskripsi' => $deskripsi,
                'tipe_log' => 'update-pendaftaran',
                'id_pendaftaran' => $id_pendaftaran,
            ];
            $logModel->save($datalog);
        }

        $id_pelanggan = !empty($this->request->getVar('id_pelanggan')) ? $this->request->getVar('id_pelanggan') : '';
        $kode_pelanggan = !empty($this->request->getVar('kode_pelanggan')) ? $this->request->getVar('kode_pelanggan') : '';
        $tgl_pemasangan = !empty($this->request->getVar('tgl_pemasangan')) ? $this->request->getVar('tgl_pemasangan') : '';
        $tgl_tagihan = !empty($this->request->getVar('tgl_tagihan')) ? $this->request->getVar('tgl_tagihan') : '';
        $nama_pelanggan = !empty($this->request->getVar('nama_pelanggan')) ? $this->request->getVar('nama_pelanggan') : '';
        $nik_pelanggan = !empty($this->request->getVar('nik_pelanggan')) ? $this->request->getVar('nik_pelanggan') : '';
        $alamat_pelanggan = !empty($this->request->getVar('alamat_pelanggan')) ? $this->request->getVar('alamat_pelanggan') : '';
        if (!empty($this->request->getVar('telp_pelanggan'))) {
            $telp_pelanggan_old = !empty($this->request->getVar('telp_pelanggan')) ? $this->request->getVar('telp_pelanggan') : '';
            $telp_pelanggan = '62' . $telp_pelanggan_old;
        } else {
            $telp_pelanggan = !empty($this->request->getVar('telp_pelanggan_registrasi')) ? $this->request->getVar('telp_pelanggan_registrasi') : '';
        }

        $paket_langganan = !empty($this->request->getVar('paket_langganan')) ? $this->request->getVar('paket_langganan') : '';
        $bandwidth = !empty($this->request->getVar('bandwidth')) ? $this->request->getVar('bandwidth') : '';
        $kualifikasi = !empty($this->request->getVar('kualifikasi')) ? $this->request->getVar('kualifikasi') : '';
        $periode = !empty($this->request->getVar('periode')) ? $this->request->getVar('periode') : '';
        $hargaold = !empty($this->request->getVar('harga')) ? $this->request->getVar('harga') : '';
        $harga = str_replace(',', '', $hargaold);
        $status_ppn = $this->request->getVar('status_ppn');
        if ($status_ppn == "Ya") {
            $nominal = (float)$harga * 0.11 + (float)$harga;
            $ppn = (float)$harga * 0.11;
        } else {
            $nominal = $harga;
            $ppn = 0;
        }
        $kualifikasi_prioritas = !empty($this->request->getVar('kualifikasi_prioritas')) ? $this->request->getVar('kualifikasi_prioritas') : '';
        $ket_pelanggan = !empty($this->request->getVar('ket_pelanggan')) ? $this->request->getVar('ket_pelanggan') : '';
        $alamat_pemasangan = !empty($this->request->getVar('alamat_pemasangan')) ? $this->request->getVar('alamat_pemasangan') : '';
        $bts = !empty($this->request->getVar('bts')) ? $this->request->getVar('bts') : '';
        $metode_pemasangan = !empty($this->request->getVar('metode_pemasangan')) ? $this->request->getVar('metode_pemasangan') : '';
        $ap_nama_dude = !empty($this->request->getVar('ap_nama_dude')) ? $this->request->getVar('ap_nama_dude') : '';
        $ip_akses_point = !empty($this->request->getVar('ip_akses_point')) ? $this->request->getVar('ip_akses_point') : '';
        $ap_nama_device = !empty($this->request->getVar('ap_nama_device')) ? $this->request->getVar('ap_nama_device') : '';
        $ap_ssid = !empty($this->request->getVar('ap_ssid')) ? $this->request->getVar('ap_ssid') : '';
        $ap_antena = !empty($this->request->getVar('ap_antena')) ? $this->request->getVar('ap_antena') : '';
        $ap_besi = !empty($this->request->getVar('ap_besi')) ? $this->request->getVar('ap_besi') : '';
        $ap_login = !empty($this->request->getVar('ap_login')) ? $this->request->getVar('ap_login') : '';
        $ap_password = !empty($this->request->getVar('ap_password')) ? $this->request->getVar('ap_password') : '';
        $ket_ap = !empty($this->request->getVar('ket_ap')) ? $this->request->getVar('ket_ap') : '';
        $ip_station = !empty($this->request->getVar('ip_station')) ? $this->request->getVar('ip_station') : '';
        $st_nama_device = !empty($this->request->getVar('st_nama_device')) ? $this->request->getVar('st_nama_device') : '';
        $st_ssid = !empty($this->request->getVar('st_ssid')) ? $this->request->getVar('st_ssid') : '';
        $st_antena = !empty($this->request->getVar('st_antena')) ? $this->request->getVar('st_antena') : '';
        $st_besi = !empty($this->request->getVar('st_besi')) ? $this->request->getVar('st_besi') : '';
        $st_login = !empty($this->request->getVar('st_login')) ? $this->request->getVar('st_login') : '';
        $st_password = !empty($this->request->getVar('st_password')) ? $this->request->getVar('st_password') : '';
        $ket_st = !empty($this->request->getVar('ket_st')) ? $this->request->getVar('ket_st') : '';
        $nama_hotspot = !empty($this->request->getVar('nama_hotspot')) ? $this->request->getVar('nama_hotspot') : '';
        $ip_hotspot = !empty($this->request->getVar('ip_hotspot')) ? $this->request->getVar('ip_hotspot') : '';
        $login_hotspot = !empty($this->request->getVar('login_hotspot')) ? $this->request->getVar('login_hotspot') : '';
        $password_hotspot = !empty($this->request->getVar('password_hotspot')) ? $this->request->getVar('password_hotspot') : '';
        $ket_perangkat = !empty($this->request->getVar('ket_perangkat')) ? $this->request->getVar('ket_perangkat') : '';


        $deskripsi = $username . " menambahkan pelanggan baru " . $this->request->getVar('kode_pelanggan') . " a.n " .
            $this->request->getVar('nama_pelanggan');


        $data = [
            'kode_pelanggan' => $kode_pelanggan,
            'tgl_pemasangan' => $tgl_pemasangan,
            'tgl_tagihan' => $tgl_tagihan,
            'nama_pelanggan' => $nama_pelanggan,
            'nik_pelanggan' => $nik_pelanggan,
            'alamat_pelanggan' => $alamat_pelanggan,
            'telp_pelanggan' => $telp_pelanggan,
            'paket_langganan' => $paket_langganan,
            'bandwidth' => $bandwidth,
            'kualifikasi' => $kualifikasi,
            'periode' => $periode,
            'harga' => $harga,
            'ppn' => $ppn,
            'nominal' => $nominal,
            'kualifikasi_prioritas' => $kualifikasi_prioritas,
            'ket_pelanggan' => $ket_pelanggan,
            'alamat_pemasangan' => $alamat_pemasangan,
            'bts' => $bts,
            'metode_pemasangan' => $metode_pemasangan,
            'ap_nama_dude' => $ap_nama_dude,
            'ip_akses_point' => $ip_akses_point,
            'ap_nama_device' => $ap_nama_device,
            'ap_ssid' => $ap_ssid,
            'ap_antena' => $ap_antena,
            'ap_besi' => $ap_besi,
            'ap_login' => $ap_login,
            'ap_password' => $ap_password,
            'ket_ap' => $ket_ap,
            'ip_station' => $ip_station,
            'st_nama_device' => $st_nama_device,
            'st_ssid' => $st_ssid,
            'st_antena' => $st_antena,
            'st_besi' => $st_besi,
            'st_login' => $st_login,
            'st_password' => $st_password,
            'ket_st' => $ket_st,
            'nama_hotspot' => $nama_hotspot,
            'ip_hotspot' => $ip_hotspot,
            'login_hotspot' => $login_hotspot,
            'password_hotspot' => $password_hotspot,
            'ket_perangkat' => $ket_perangkat,
            'status' => '1'
        ];

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'tambah-pelanggan',
        ];
        $pelangganModel->save($data);
        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/pelanggan/index'));
    }

    public function update()
    {

        $pelangganModel = new PelangganModel();
        $logModel = new LogModel();
        $username = user()->username;
        $pelanggan = $pelangganModel->where('id_pelanggan', $this->request->getVar('id_pelanggan'))->findAll();

        $harganew = str_replace(',', '', $this->request->getVar('harga'));
        $cekkode_pelanggan = $pelanggan[0]['kode_pelanggan'] == $this->request->getVar('kode_pelanggan') ? '' : ',<br/>Kode Pelanggan <b>' . $pelanggan[0]['kode_pelanggan'] . '</b> menjadi <b>' . $this->request->getVar('kode_pelanggan') . "</b>";
        $ceknama_pelanggan = $pelanggan[0]['nama_pelanggan'] == $this->request->getVar('nama_pelanggan') ? '' : ',<br/>Nama Pelanggan <b>' . $pelanggan[0]['nama_pelanggan'] . '</b> menjadi <b>' . $this->request->getVar('nama_pelanggan') . "</b>";
        $ceknik_pelanggan = $pelanggan[0]['nik_pelanggan'] == $this->request->getVar('nik_pelanggan') ? '' : ',<br/>NIK Pelanggan <b>' . $pelanggan[0]['nik_pelanggan'] . '</b> menjadi <b>' . $this->request->getVar('nik_pelanggan') . "</b>";
        $cekalamat_pelanggan = $pelanggan[0]['alamat_pelanggan'] == $this->request->getVar('alamat_pelanggan') ? '' : ',<br/>Alamat Pelanggan <b>' . $pelanggan[0]['alamat_pelanggan'] . '</b> menjadi <b>' . $this->request->getVar('alamat_pelanggan') . "</b>";
        $cektelp_pelanggan = $pelanggan[0]['telp_pelanggan'] == $this->request->getVar('telp_pelanggan') ? '' : ',<br/>Telp Pelanggan <b>' . $pelanggan[0]['telp_pelanggan'] . '</b> menjadi <b>' . $this->request->getVar('telp_pelanggan') . "</b>";
        $cekpaket_langganan = $pelanggan[0]['paket_langganan'] == $this->request->getVar('paket_langganan') ? '' : ',<br/>Paket Langganan <b>' . $pelanggan[0]['paket_langganan'] . '</b> menjadi <b>' . $this->request->getVar('paket_langganan') . "</b>";
        $cekbandwidth = $pelanggan[0]['bandwidth'] == $this->request->getVar('bandwidth') ? '' : ',<br/>Bandwidth <b>' . $pelanggan[0]['bandwidth'] . '</b> menjadi <b>' . $this->request->getVar('bandwidth') . "</b>";
        $cekharga = $pelanggan[0]['harga'] == $harganew ? '' : ',<br/>Harga <b>' . $pelanggan[0]['harga'] . '</b> menjadi <b>' . $harganew . "</b>";
        $cekppn_status = $pelanggan[0]['ppn'] != 0 ? 'Ya' : 'Tidak';
        $cekppn = $cekppn_status == $this->request->getVar('status_ppn') ? '' : ',<br/>Perubahan Status PPN <b>' . $cekppn_status . '</b> menjadi <b>' . $this->request->getVar('status_ppn') . "</b>";
        $cekket_pelanggan = $pelanggan[0]['ket_pelanggan'] == $this->request->getVar('ket_pelanggan') ? '' : ',<br/>Ket Pelanggan <b>' . $pelanggan[0]['ket_pelanggan'] . '</b> menjadi <b>' . $this->request->getVar('ket_pelanggan') . "</b>";


        $kode_pelanggan = !empty($this->request->getVar('kode_pelanggan')) ? $this->request->getVar('kode_pelanggan') : $pelanggan[0]['kode_pelanggan'];
        $nama_pelanggan = !empty($this->request->getVar('nama_pelanggan')) ? $this->request->getVar('nama_pelanggan') : $pelanggan[0]['nama_pelanggan'];
        $nik_pelanggan = !empty($this->request->getVar('nik_pelanggan')) ? $this->request->getVar('nik_pelanggan') : $pelanggan[0]['nik_pelanggan'];
        $alamat_pelanggan = !empty($this->request->getVar('alamat_pelanggan')) ? $this->request->getVar('alamat_pelanggan') : $pelanggan[0]['alamat_pelanggan'];
        $telp_pelanggan = !empty($this->request->getVar('telp_pelanggan')) ? $this->request->getVar('telp_pelanggan') : $pelanggan[0]['telp_pelanggan'];
        $paket_langganan = !empty($this->request->getVar('paket_langganan')) ? $this->request->getVar('paket_langganan') : $pelanggan[0]['paket_langganan'];
        $bandwidth = !empty($this->request->getVar('bandwidth')) ? $this->request->getVar('bandwidth') : $pelanggan[0]['bandwidth'];
        if (!empty($harganew)) {
            $harga = $harganew;
        } else if ($harganew == 0) {
            $harga = 0;
        } else {
            $harga = $pelanggan[0]['harga'];
        }
        $status_ppn = $this->request->getVar('status_ppn');
        if ($status_ppn == "Ya") {
            $nominal = (float)$harga * 0.11 + (float)$harga;
            $ppn = (float)$harga * 0.11;
        } else {
            $nominal = $harga;
            $ppn = 0;
        }
        $ket_pelanggan = !empty($this->request->getVar('ket_pelanggan')) ? $this->request->getVar('ket_pelanggan') : $pelanggan[0]['ket_pelanggan'];

        $data = [
            'id_pelanggan' => $this->request->getVar('id_pelanggan'),
            'kode_pelanggan' => $kode_pelanggan,
            'nama_pelanggan' => $nama_pelanggan,
            'nik_pelanggan' => $nik_pelanggan,
            'alamat_pelanggan' => $alamat_pelanggan,
            'telp_pelanggan' => $telp_pelanggan,
            'paket_langganan' => $paket_langganan,
            'bandwidth' => $bandwidth,
            'harga' => $harga,
            'ppn' => $ppn,
            'nominal' => $nominal,
            'ket_pelanggan' => $ket_pelanggan
        ];
        $deskripsi = $username . " mengupdate pelanggan " . $this->request->getVar('kode_pelanggan') . " a.n " .
            $this->request->getVar('nama_pelanggan') .
            $cekkode_pelanggan .
            $ceknama_pelanggan .
            $ceknik_pelanggan .
            $cekalamat_pelanggan .
            $cektelp_pelanggan .
            $cekpaket_langganan .
            $cekbandwidth .
            $cekharga .
            $cekppn .
            $cekket_pelanggan;

        if ($cekharga != '') {
            $deskripsiupgrade = $username . " upgrade/downgrade layanan internet pelanggan " . $this->request->getVar('kode_pelanggan') . " a.n " .
                $this->request->getVar('nama_pelanggan') .
                $cekharga;
            $datalog = [
                'tgl' => date("Y-m-d H:i:s"),
                'akun' => $username,
                'deskripsi' => $deskripsiupgrade,
                'tipe_log' => 'upgrade-pelanggan',
                'id_pelanggan' => $this->request->getVar('id_pelanggan'),
            ];
            $logModel->save($datalog);
        }

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-pelanggan',
            'id_pelanggan' => $this->request->getVar('id_pelanggan'),
        ];
        $pelangganModel->save($data);
        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/pelanggan/index'));
    }

    public function edit($id)
    {

        $pelangganModel = new PelangganModel();
        $pelanggan = $pelangganModel->where('id_pelanggan', $id)->first();
        $data = [
            'menu' => 'user',
            'title' => 'Edit Pelanggan',
            'pelanggan' => $pelanggan,
        ];
        //dd($pelanggan);
        return view('pelanggan/edit', $data);
    }


    public function activate()
    {

        $pelangganModel = new PelangganModel();
        if ($this->request->getVar('active') == 0 || '') {
            $active = '1';
        } else {
            $active = '0';
        }

        $status = $active == 1 ? 'Aktif' : 'Tidak Aktif';

        $logModel = new LogModel();
        $username = user()->username;
        $deskripsi = $username . " mengupdate status pelanggan " . $this->request->getVar('kode_pelanggan') . " a.n " . $this->request->getVar('nama_pelanggan') . " menjadi <b>" . $status . "</b>";
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-pelanggan',
            'id_pelanggan' => $this->request->getVar('id_pelanggan'),
        ];
        $logModel->save($datalog);


        $data = [
            'status' =>  $active,
        ];
        $pelangganModel->update($this->request->getVar('id_pelanggan'), $data);

        return redirect()->to(base_url('/pelanggan/index'));
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 

        //Menampilkan Data Pelanggan
        $db      = \Config\Database::connect();
        $builder = $db->table('pelanggan');
        $jml_pelanggan   = $builder->orderBy('id_pelanggan', 'asc')->countAllResults();
        $pelanggan   = $builder->orderBy('id_pelanggan', 'asc')->get()->getResultArray();

        $data['title'] = 'Kelola Pelanggan';

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PT. Tonggak Teknologi Netikom')
            ->setCellValue('A2', 'DATA PELANGGAN');
        $spreadsheet->getActiveSheet()->mergeCells('A1:AR1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:AR2');
        $spreadsheet->getActiveSheet()->mergeCells('A3:AR3');
        $spreadsheet->getActiveSheet()->getStyle('A1:AR3')->getFont()->setBold(true);

        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('V')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('W')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('X')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('Y')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('Z')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AC')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AD')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AE')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AF')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AG')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AH')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AI')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AJ')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AK')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AL')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AM')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AN')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AO')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AP')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AQ')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('AR')->setAutoSize(true);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A5', 'No')
            ->setCellValue('B5', 'Kode Pelanggan')
            ->setCellValue('C5', 'Tanggal Pemasangan')
            ->setCellValue('D5', 'Tanggal Tagihan')
            ->setCellValue('E5', 'Nama Pelanggan')
            ->setCellValue('F5', 'NIK Pelanggan')
            ->setCellValue('G5', 'Alamat Pelanggan')
            ->setCellValue('H5', 'Telp Pelanggan')
            ->setCellValue('I5', 'Paket Langganan')
            ->setCellValue('J5', 'Bandwidth')
            ->setCellValue('K5', 'Kualifikasi')
            ->setCellValue('L5', 'Periode')
            ->setCellValue('M5', 'Harga')
            ->setCellValue('N5', 'PPN')
            ->setCellValue('O5', 'Nominal')
            ->setCellValue('P5', 'Piutang')
            ->setCellValue('Q5', 'Kualifikasi Prioritas')
            ->setCellValue('R5', 'Ket Pelanggan')
            ->setCellValue('S5', 'Alamat Pemasangan')
            ->setCellValue('T5', 'BTS')
            ->setCellValue('U5', 'Metode Pemasangan')
            ->setCellValue('V5', 'AP Nama Dude')
            ->setCellValue('W5', 'IP Akses Point')
            ->setCellValue('X5', 'AP Nama Device')
            ->setCellValue('Y5', 'AP SSID')
            ->setCellValue('Z5', 'AP Antena')
            ->setCellValue('AA5', 'AP Besi')
            ->setCellValue('AB5', 'AP Login')
            ->setCellValue('AC5', 'AP Password')
            ->setCellValue('AD5', 'Ket AP')
            ->setCellValue('AE5', 'IP STation')
            ->setCellValue('AF5', 'ST Nama Device')
            ->setCellValue('AG5', 'ST SSID')
            ->setCellValue('AH5', 'ST Antena')
            ->setCellValue('AI5', 'ST Besi')
            ->setCellValue('AJ5', 'ST Login')
            ->setCellValue('AK5', 'ST Password')
            ->setCellValue('AL5', 'Ket ST')
            ->setCellValue('AM5', 'Nama Hotspot')
            ->setCellValue('AN5', 'IP Hotspot')
            ->setCellValue('AO5', 'Login Hotspot')
            ->setCellValue('AP5', 'Password Hotspot')
            ->setCellValue('AQ5', 'Ket Perangkat')
            ->setCellValue('AR5', 'Status');

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

        $jml_pelanggan = $jml_pelanggan + 5; //Jumah Baris + Header
        $jml_isipelanggan = $jml_pelanggan + 6; //Jumlah Baris tanpa Header
        $cell_range = 'A5:AR' . $jml_pelanggan;
        $cell_rangewrap1 = 'G6:G' . $jml_isipelanggan;
        $cell_rangewrap2 = 'S6:S' . $jml_isipelanggan;
        $spreadsheet->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $spreadsheet->getActiveSheet()->getStyle('A5:AR5')->applyFromArray($styleArray2);
        //Border
        $spreadsheet->getActiveSheet()->getStyle('A:AR')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //Format Header
        $spreadsheet->getActiveSheet()->getStyle($cell_range)->applyFromArray($styleArray);
        //Wrap Text
        $spreadsheet->getActiveSheet()->getStyle($cell_rangewrap1)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle($cell_rangewrap2)->getAlignment()->setWrapText(true);

        $column = 6;
        $no = 1;
        // tulis data mobil ke cell
        foreach ($pelanggan as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['kode_pelanggan'])
                ->setCellValue('C' . $column, $data['tgl_pemasangan'])
                ->setCellValue('D' . $column, $data['tgl_tagihan'])
                ->setCellValue('E' . $column, $data['nama_pelanggan'])
                ->setCellValue('F' . $column, "'" . $data['nik_pelanggan'])
                ->setCellValue('G' . $column, $data['alamat_pelanggan'])
                ->setCellValue('H' . $column, "'" . $data['telp_pelanggan'])
                ->setCellValue('I' . $column, $data['paket_langganan'])
                ->setCellValue('J' . $column, $data['bandwidth'])
                ->setCellValue('K' . $column, $data['kualifikasi'])
                ->setCellValue('L' . $column, $data['periode'])
                ->setCellValue('M' . $column, $data['harga'])
                ->setCellValue('N' . $column, $data['ppn'])
                ->setCellValue('O' . $column, $data['nominal'])
                ->setCellValue('P' . $column, $data['piutang'])
                ->setCellValue('Q' . $column, $data['kualifikasi_prioritas'])
                ->setCellValue('R' . $column, $data['ket_pelanggan'])
                ->setCellValue('S' . $column, $data['alamat_pemasangan'])
                ->setCellValue('T' . $column, $data['bts'])
                ->setCellValue('U' . $column, $data['metode_pemasangan'])
                ->setCellValue('V' . $column, $data['ap_nama_dude'])
                ->setCellValue('W' . $column, $data['ip_akses_point'])
                ->setCellValue('X' . $column, $data['ap_nama_device'])
                ->setCellValue('Y' . $column, $data['ap_ssid'])
                ->setCellValue('Z' . $column, $data['ap_antena'])
                ->setCellValue('AA' . $column, $data['ap_besi'])
                ->setCellValue('AB' . $column, $data['ap_login'])
                ->setCellValue('AC' . $column, $data['ap_password'])
                ->setCellValue('AD' . $column, $data['ket_ap'])
                ->setCellValue('AE' . $column, $data['ip_station'])
                ->setCellValue('AF' . $column, $data['st_nama_device'])
                ->setCellValue('AG' . $column, $data['st_ssid'])
                ->setCellValue('AH' . $column, $data['st_antena'])
                ->setCellValue('AI' . $column, $data['st_besi'])
                ->setCellValue('AJ' . $column, $data['st_login'])
                ->setCellValue('AK' . $column, $data['st_password'])
                ->setCellValue('AL' . $column, $data['ket_st'])
                ->setCellValue('AM' . $column, $data['nama_hotspot'])
                ->setCellValue('AN' . $column, $data['ip_hotspot'])
                ->setCellValue('AO' . $column, $data['login_hotspot'])
                ->setCellValue('AP' . $column, $data['password_hotspot'])
                ->setCellValue('AQ' . $column, $data['ket_perangkat']);
            if ($data['status'] == 1) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('AR' . $column, 'Aktif');
            } else {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('AR' . $column, 'Non Aktif');
            }
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Pelanggan T2 Net';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        setlocale(LC_ALL, 'en_US');
        ob_end_clean();
        $writer->save('php://output');
    }
}
