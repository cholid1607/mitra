<?php

namespace App\Controllers;

use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;

class Profil extends BaseController
{
    public function index(): string
    {
        $username = user()->username;
        $db      = \Config\Database::connect();
        $builder = $db->table('mitra');
        $mitra = $builder->where('username', $username)->get()->getResultArray();
        if ($mitra) {
            $id_mitra = $mitra['id_mitra'];
            $nama_mitra = $mitra['nama_mitra'];
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
}
