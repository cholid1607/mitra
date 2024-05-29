<?php

namespace App\Controllers;

require 'core/vendor/autoload.php';

use App\Models\PelangganModel;
use App\Models\LogModel;
use App\Models\PembayaranModel;

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
        $data = [
            'id_mitra' => $id_mitra,
            'menu' => 'jurnal',
            'title' => 'Kelola Kuitansi Custom',
        ];
        return view('pembayaran/index', $data);
    }

    public function tambah(): string
    {
        $data = [
            'menu' => 'jurnal',
            'title' => 'Buat Kuitansi',
        ];
        return view('kuitansi/tambah', $data);
    }
}
