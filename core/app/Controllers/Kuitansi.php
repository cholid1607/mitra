<?php

namespace App\Controllers;

require 'core/vendor/autoload.php';

use App\Models\PelangganModel;
use App\Models\LogModel;
use App\Models\KuitansiCustomModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class Kuitansi extends BaseController
{
    public function index(): string
    {
        $kuitansicustomModel = new KuitansiCustomModel();
        $kuitansi = $kuitansicustomModel->orderBy('tgl_kuitansi', 'desc')->findAll();
        //dd($pemasukan);
        $data = [
            'kuitansi' => $kuitansi,
            'menu' => 'jurnal',
            'title' => 'Kelola Kuitansi Custom',
        ];
        return view('kuitansi/index', $data);
    }

    public function tambah(): string
    {
        $data = [
            'menu' => 'jurnal',
            'title' => 'Buat Kuitansi',
        ];
        return view('kuitansi/tambah', $data);
    }

    public function simpan()
    {
        //DB Connect dan Model Loader
        $db      = \Config\Database::connect();

        //Deklrasi Model
        $kuitansicustomModel = new KuitansiCustomModel();
        $logModel = new LogModel();
        $username = user()->username;

        //Mendapatkan Variabel Input
        $nama_pelanggan = !empty($this->request->getVar('nama_pelanggan')) ? $this->request->getVar('nama_pelanggan') : '';
        $kode_pelanggan = !empty($this->request->getVar('kode_pelanggan')) ? $this->request->getVar('kode_pelanggan') : '';
        $item_pemasukan = !empty($this->request->getVar('item_pemasukan')) ? $this->request->getVar('item_pemasukan') : '';
        $nominal = !empty($this->request->getVar('nominal')) ? $this->request->getVar('nominal') : '';
        $status_ppn = !empty($this->request->getVar('status_ppn')) ? $this->request->getVar('status_ppn') : '';

        if ($status_ppn == "Ya") {
            $total_tagihan = (float)$nominal * 0.11 + (float)$nominal;
        } else {
            $total_tagihan = $nominal;
        }

        $deskripsi = $username . " menambahkan pemasukan baru <b>" . $this->request->getVar('item_pemasukan') . "</b> a.n <b>" . $nama_pelanggan . "</b> senilai <b>Rp." .
            number_format($this->request->getVar('nominal')) . "</b>";

        //Mendapatkan ID Kuitansi
        $builderinv = $db->table('kuitansi_custom');
        $kuitansi   = $builderinv->where('tahun', date("Y"))->orderBy('id_kuitansi_custom', 'desc')->get()->getResultArray();

        if (!empty($kuitansi)) {
            $last_kuitansi = $kuitansi[0]['no_urut'];
        } else {
            $last_kuitansi = '0';
        }
        $bulan = date("m");
        if ($bulan == '01') {
            $bulannomer = 'I';
        } else if ($bulan == '02') {
            $bulannomer = 'II';
        } else if ($bulan == '03') {
            $bulannomer = 'III';
        } else if ($bulan == '04') {
            $bulannomer = 'IV';
        } else if ($bulan == '05') {
            $bulannomer = 'V';
        } else if ($bulan == '06') {
            $bulannomer = 'VI';
        } else if ($bulan == '07') {
            $bulannomer = 'VII';
        } else if ($bulan == '08') {
            $bulannomer = 'VIII';
        } else if ($bulan == '09') {
            $bulannomer = 'IX';
        } else if ($bulan == '10') {
            $bulannomer = 'X';
        } else if ($bulan == '11') {
            $bulannomer = 'XI';
        } else if ($bulan == '12') {
            $bulannomer = 'XII';
        }

        //Mendapatkan Nomer Kuitansi Terbaru
        $tahunnomer = substr(date("Y"), 2, 2);
        $no_kuitansi = 'KWT/' . $kode_pelanggan . '/' . $bulannomer . '/' . $tahunnomer . '/T-' . ++$last_kuitansi;

        //Menyimpan Data Awal Kuitansi
        $datakuitansi = [
            'no_urut' => $last_kuitansi++,
            'no_kuitansi' => $no_kuitansi,
            'id_pelanggan' => 0,
            'nama_pelanggan' => $nama_pelanggan,
            'kode_pelanggan' => $kode_pelanggan,
            'tgl_kuitansi' => date("Y-m-d"),
            'item_layanan' => $item_pemasukan,
            'bulan' => date("m"),
            'tahun' => date("Y"),
            'nominal' => $nominal,
            'ppn' => $status_ppn,
            'nominal_kuitansi' => $total_tagihan,
            'status' => 1
        ];
        $kuitansicustomModel->save($datakuitansi);


        $data['title'] = 'Tambah Kuitansi';
        $data['menu'] = 'pemasukan';
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/kuitansi/index'));
    }

    public function downloadkuitansi($id_kuitansi_custom = '', $stream = true)
    {
        //DB Connect dan Model Loader
        $db      = \Config\Database::connect();

        //Cek Data Kuitansi
        $builder = $db->table('kuitansi_custom');
        $kuitansi   = $builder->where('id_kuitansi_custom', $id_kuitansi_custom)
            ->get()->getResultArray();

        $data['kuitansi'] = $kuitansi;
        $data['nama_pelanggan'] = $kuitansi[0]['nama_pelanggan'];
        $data['no_kuitansi'] = $kuitansi[0]['no_kuitansi'];

        $data['title'] = 'Cetak Kuitansi';
        $data['menu'] = 'kuitansi';
        $str_no_kuitansi = str_replace("/", "_", $kuitansi[0]['no_kuitansi']);
        $filenamekuitansi = 'Kuitansi ' . $str_no_kuitansi . ' - ' . $kuitansi[0]['nama_pelanggan'];

        //Setup Option Dompdf
        $option = new Options();
        $option->set('enabled', true);
        $option->set('isHtml5ParserEnabled', true);
        $option->set('isPhpEnabled', true);
        $option->set('isFontSubsettingEnabled', false);
        $option->set('pdfBackend', 'CPDF');
        $option->set('isRemoteEnabled', true);
        $option->set('chroot', realpath(''));
        $option->setTempDir('temp');

        // instantiate and use the dompdf class
        $dompdf = new Dompdf($option);
        //$dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('kuitansi/downloadkuitansi', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        if ($stream) {
            $dompdf->stream($filenamekuitansi, array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }

    public function edit($id_kuitansi_custom = '')
    {
        $db      = \Config\Database::connect();

        //Cek Pemasukan Terakhir
        $builder = $db->table('kuitansi_custom');
        $kuitansi   = $builder->where('id_kuitansi_custom', $id_kuitansi_custom)
            ->get()->getResultArray();
        //dd($kuitansi);
        $data = [
            'menu' => 'user',
            'title' => 'Edit Kuitansi',
            'kuitansi' => $kuitansi,
        ];

        return view('kuitansi/edit', $data);
    }

    public function update()
    {
        $db      = \Config\Database::connect();
        $kuitansicustomModel = new KuitansiCustomModel();
        $logModel = new LogModel();
        $username = user()->username;
        $kuitansi = $kuitansicustomModel->where('id_kuitansi_custom', $this->request->getVar('id_kuitansi_custom'))->findAll();

        $item_pemasukan = !empty($this->request->getVar('item_pemasukan')) ? $this->request->getVar('item_pemasukan') : $kuitansi[0]['item_pemasukan'];
        $status_ppn = !empty($this->request->getVar('status_ppn')) ? $this->request->getVar('status_ppn') : $kuitansi[0]['ppn'];
        $tgl_kuitansi = !empty($this->request->getVar('tgl_kuitansi')) ? $this->request->getVar('tgl_kuitansi') : $kuitansi[0]['tgl_kuitansi'];

        $nominal = !empty($this->request->getVar('nominal')) ? $this->request->getVar('nominal') : $kuitansi[0]['nominal'];
        if ($status_ppn == 'Ya') {
            $nominal_kuitansi = (float)$nominal * 0.11 + (float)$nominal;
        } else {
            $nominal_kuitansi = $nominal;
        }

        //Menyimpan Data Awal Kuitansi
        $datakuitansi = [
            'id_kuitansi_custom' => $this->request->getVar('id_kuitansi_custom'),
            'tgl_kuitansi' => $tgl_kuitansi,
            'item_layanan' => $item_pemasukan,
            'nominal' => $nominal,
            'ppn' => $status_ppn,
            'nominal_kuitansi' => $nominal_kuitansi
        ];
        $kuitansicustomModel->save($datakuitansi);
        /*
        $cekitem_pemasukan = $pemasukan[0]['item_pemasukan'] == $this->request->getVar('item_pemasukan') ? '' : ',<br/>Item Pengeluaran <b>'.$pemasukan[0]['item_pemasukan'].'</b> menjadi <b>'.$this->request->getVar('item_pemasukan')."</b>";
        $cekstatus_ppn = $pemasukan[0]['status_ppn'] == $this->request->getVar('status_ppn') ? '' : ',<br/>Status PPN <b>'.$pemasukan[0]['status_ppn'].'</b> menjadi <b>'.$this->request->getVar('status_ppn')."</b>";
        $cekketerangan = $pemasukan[0]['keterangan'] == $this->request->getVar('keterangan') ? '' : ',<br/>Keterangan <b>'.$pemasukan[0]['keterangan'].'</b> menjadi <b>'.$this->request->getVar('keterangan')."</b>";
        $ceknominal = $pemasukan[0]['nominal'] == $nominalnew ? '' : ',<br/>Nominal <b>Rp.'.number_format($pemasukan[0]['nominal']).'</b> menjadi <b>Rp.'.number_format($nominalnew)."</b>";
         
        $data = [
            'id_pemasukan' => $this->request->getVar('id_pemasukan'),
            'item_pemasukan' => $item_pemasukan,
            'status_ppn' => $status_ppn,
            'keterangan' => $keterangan,
            'nominal' => $nominalnew,
            'total_tagihan' => $nominalnew
        ];
        $deskripsi = $username." mengupdate pemasukan dengan rincian".
                $cekitem_pemasukan.
                $cekstatus_ppn.
                $cekketerangan.
                $ceknominal;
        
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-pemasukan',
            'id_pemasukan' => $this->request->getVar('id_pemasukan'),
        ];
        */
        //$pemasukanModel->save($data);
        //$invoiceModel->save($datainvoice);
        //$logModel->save($datalog);
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/kuitansi/index'));
    }

    public function hapus()
    {
        $kuitansicustomModel = new KuitansiCustomModel();
        $kuitansicustomModel->delete($this->request->getVar('id_kuitansi_custom'));
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');

        return redirect()->to('/kuitansi');
    }
}
