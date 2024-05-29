<?php

namespace App\Controllers;

require 'core/vendor/autoload.php';

use App\Models\PelangganModel;
use App\Models\LogModel;
use App\Models\PembayaranModel;
use App\Models\MitraModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pembayaran extends BaseController
{
    public function index(): string
    {
        $username = user()->username;
        //DB Connect dan Model Loader
        $db      = \Config\Database::connect();
        $builder = $db->table('mitra');
        $mitra = $builder->where('username', $username)->get()->getFirstRow();
        $id_mitra = $mitra->id_mitra;

        $builder_pembayaran = $db->table('pembayaran');
        $pembayaran = $builder_pembayaran->where('id_mitra', $id_mitra)->get()->getResultArray();
        $data = [
            'pembayaran' => $pembayaran,
            'id_mitra' => $id_mitra,
            'menu' => 'jurnal',
            'title' => 'Kelola Metode Pembayaran',
        ];
        return view('pembayaran/index', $data);
    }

    public function tambah(): string
    {
        $username = user()->username;
        $db      = \Config\Database::connect();
        $builder = $db->table('mitra');
        $mitra = $builder->where('username', $username)->get()->getFirstRow();
        $id_mitra = $mitra->id_mitra;

        $data = [
            'id_mitra' => $id_mitra,
            'menu' => 'jurnal',
            'title' => 'Tambah Metode Pembayaran',
        ];
        return view('pembayaran/tambah', $data);
    }

    public function simpan()
    {
        $id_mitra = $this->request->getVar('id_mitra');
        $nama_bank = $this->request->getVar('nama_bank');
        $rekening = (($this->request->getVar('rekening') != '') ? $this->request->getVar('rekening') : '-');
        $atas_nama = (($this->request->getVar('atas_nama') != '') ? $this->request->getVar('atas_nama') : '-');

        $logModel = new LogModel();
        $pembayaranModel = new PembayaranModel();
        $username = user()->username;

        //Menyimpan Data Pembayaran
        $datapembayaran = [
            'id_mitra' => $id_mitra,
            'nama_bank' => $nama_bank,
            'rekening' => $rekening,
            'atas_nama' => $atas_nama
        ];

        //Simpan Mitra
        $pembayaranModel->save($datapembayaran);

        // Simpan Log
        $deskripsi = $username . " menambahkan metode pembayaran baru <b>" . $nama_bank . " (" . $rekening . ") a.n " . $atas_nama . ")</b>";

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'id_mitra' => $id_mitra,
            'tipe_log' => 'tambah-metode',
        ];
        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/pembayaran/index'));
    }

    public function edit($id_pembayaran = '')
    {
        $db      = \Config\Database::connect();

        //Cek Pemasukan Terakhir
        $builder = $db->table('pembayaran');
        $pembayaran   = $builder->where('id_pembayaran', $id_pembayaran)
            ->get()->getFirstRow();
        $data = [
            'menu' => 'pembayaran',
            'title' => 'Edit Pembayaran',
            'pembayaran' => $pembayaran,
        ];

        return view('pembayaran/edit', $data);
    }

    public function update()
    {
        $pembayaranModel = new PembayaranModel();
        $logModel = new LogModel();
        $username = user()->username;

        $id_mitra = $this->request->getVar('id_mitra');
        $id_pembayaran = $this->request->getVar('id_pembayaran');
        $pembayaran = $pembayaranModel->where('id_mitra', $id_mitra)->findAll();

        $ceknama_bank = $pembayaran[0]['nama_bank'] == $this->request->getVar('nama_bank') ? '' : ',<br/>Nama Bank <b>' . $pembayaran[0]['nama_bank'] . '</b> menjadi <b>' . $this->request->getVar('nama_bank') . "</b>";
        $cekrekening = $pembayaran[0]['rekening'] == $this->request->getVar('rekening') ? '' : ',<br/>Rekening <b>' . $pembayaran[0]['rekening'] . '</b> menjadi <b>' . $this->request->getVar('rekening') . "</b>";
        $cekatas_nama = $pembayaran[0]['atas_nama'] == $this->request->getVar('atas_nama') ? '' : ',<br/>Atas Nama <b>' . $pembayaran[0]['atas_nama'] . '</b> menjadi <b>' . $this->request->getVar('atas_nama') . "</b>";

        $nama_bank = !empty($this->request->getVar('nama_bank')) ? $this->request->getVar('nama_bank') : $pembayaran[0]['nama_bank'];
        $rekening = !empty($this->request->getVar('rekening')) ? $this->request->getVar('rekening') : $pembayaran[0]['rekening'];
        $atas_nama = !empty($this->request->getVar('atas_nama')) ? $this->request->getVar('atas_nama') : $pembayaran[0]['atas_nama'];

        $deskripsi = $username . " mengupdate pembayaran <b>" . $this->request->getVar('nama_bank') . "</b>" .
            $ceknama_bank .
            $cekrekening .
            $cekatas_nama;

        $data = [
            'id_pembayaran' => $id_pembayaran,
            'id_mitra' => $id_mitra,
            'nama_bank' => $nama_bank,
            'rekening' => $rekening,
            'atas_nama' => $atas_nama
        ];

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'update-pembayaran',
            'id_pembayaran' => $id_pembayaran
        ];

        $pembayaranModel->save($data);
        if (
            $ceknama_bank != '' || $cekrekening != '' || $cekatas_nama != ''
        ) {
            $logModel->save($datalog);
        }
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/pembayaran'));
    }

    public function hapus()
    {
        $pembayaranModel = new PembayaranModel();
        $logModel = new LogModel();
        $username = user()->username;
        $id_pembayaran = $this->request->getVar('id_pembayaran');
        $db      = \Config\Database::connect();

        //Cek Pemasukan Terakhir
        $builder = $db->table('pembayaran');
        $pembayaran   = $builder->where('id_pembayaran', $id_pembayaran)
            ->get()->getResultArray();
        $nama_bank = $pembayaran[0]['nama_bank'];
        $atas_nama = $pembayaran[0]['atas_nama'];

        $deskripsi = $username . " menghapus metode pembayaran <b>" . $nama_bank . " (" . $atas_nama . ")</b>";
        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsi,
            'tipe_log' => 'hapus-pembayaran',
        ];
        $logModel->save($datalog);

        $log = $logModel->where('id_pembayaran', $id_pembayaran)->first();
        if (!empty($log)) {
            $logModel->where('id_pembayaran', $id_pembayaran)->delete();
        }

        $pembayaranModel->delete($id_pembayaran);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('/pembayaran');
    }
}
