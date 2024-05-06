<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\PendaftaranModel;

class Home extends BaseController
{
    public function index(): string
    {
        // Status Tagihan

        $data['title'] = 'Dashboard';
        $data['menu'] = 'beranda';

        return view('user/index', $data);
    }
}
