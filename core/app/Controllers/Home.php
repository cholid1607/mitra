<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\PendaftaranModel;

class Home extends BaseController
{
    public function index(): string
    {
        // Status Tagihan
        $db      = \Config\Database::connect();
        $builder = $db->table('tagihan');
        $builder_pelanggan = $db->table('pelanggan');
        $builder_users = $db->table('users');
        $builder_mitra = $db->table('mitra');

        $data['jml_pelanggan'] = $builder_pelanggan->where('status', '1')->countAllResults();
        $data['jml_users'] = $builder_users->where('active', '1')->countAllResults();
        $data['jml_mitra'] = $builder_mitra->countAllResults();

        $data['title'] = 'Dashboard';
        $data['menu'] = 'beranda';

        return view('user/index', $data);
    }
}
