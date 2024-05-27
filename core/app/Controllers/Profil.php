<?php

namespace App\Controllers;

use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;
use App\Models\LogModel;
use App\Models\MitraModel;

class Profil extends BaseController
{
    public function index(): string
    {
        $username = user()->username;
        $db      = \Config\Database::connect();
        $builder = $db->table('mitra');
        $mitra = $builder->where('username', $username)->get()->getResultArray();
        if ($mitra) {
            $id_mitra = $mitra[0]['id_mitra'];
            $nama_mitra = $mitra[0]['nama_mitra'];
        } else {
            $id_mitra = 0;
            $nama_mitra = "-";
        }

        $data = [
            'menu' => 'user',
            'id_mitra' => $id_mitra,
            'mitra' => $mitra,
            'title' => 'Edit Profil - ' . $nama_mitra,
        ];
        return view('profil/index', $data);
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

        $deskripsi = $username . " mengupdate mitra <b>" . $this->request->getVar('nama_users') . "</b>" .
            $ceknama_mitra .
            $cekpenanggung_jawab .
            $cekalamat .
            $cektelepon;

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
        return redirect()->to(base_url('/'));
    }
}
