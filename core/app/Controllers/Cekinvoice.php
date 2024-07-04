<?php

namespace App\Controllers;

class Cekinvoice extends BaseController
{
    public function index($id): string
    {
        $id_tagihan = $id;
        $db      = \Config\Database::connect();
        $builder = $db->table('tagihan');
        $tagihan   = $builder->where('id_tagihan', $id_tagihan)
            ->get()->getRowArray();
        if ($tagihan != null) {
            $id_mitra = $tagihan['id_mitra'];
            $builder_mitra = $db->table('mitra');
            $mitra   = $builder_mitra->where('id_mitra', $id_mitra)
                ->get()->getRowArray();
            $data['mitra'] = $mitra;
        }
        $data['tagihan'] = $tagihan;
        $data['title'] = 'Cek Tagihan';
        $data['menu'] = 'tagihan';
        return view('tagihan/cektagihan', $data);
    }
}
