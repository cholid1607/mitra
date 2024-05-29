<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\PendaftaranModel;
use PHPUnit\Framework\Constraint\Count;

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

        //Mencari Data Mitra untuK Statistik Mitra
        $username = user()->username;
        $mitra = $builder_mitra->where('username', $username)->get()->getFirstRow();
        if ($mitra) {
            $id_mitra = $mitra->id_mitra;

            $data['jml_pelanggan_mitra'] = $builder_pelanggan->where('status', '1')->where('id_mitra', $id_mitra)->countAllResults();


            //Menghitung Total PPN
            $total_ppn = $builder->selectSum('ppn', 'total_ppn')
                ->where('tgl_tagihan >=', date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-10')))))
                ->where('id_mitra', $id_mitra)
                ->where('tgl_tagihan <=', date('Y-m-10'))
                ->get()->getFirstRow();
            if ($total_ppn) {
                $data['total_ppn'] = $total_ppn->total_ppn;
            } else {
                $data['total_ppn'] = 0;
            }

            // Menghitung Total BHP
            $total_bhp = $builder->selectSum('nominal', 'jml_tagihan')
                ->where('tgl_tagihan >=', date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-10')))))
                ->where('id_mitra', $id_mitra)
                ->where('tgl_tagihan <=', date('Y-m-10'))
                ->get()->getFirstRow();
            if ($total_bhp) {
                $bhp = ($total_bhp->jml_tagihan) * 0.005;
                $uso = ($total_bhp->jml_tagihan) * 0.0125;
                $admin = ($total_bhp->jml_tagihan) * 0.0125;
                $data['total_bhp']  = $bhp + $uso + $admin;
            } else {
                $data['total_bhp'] = 0;
            }

            //Menghitung Total Tagihan
            if ($total_bhp) {
                $data['total_tagihan'] = ($total_bhp->jml_tagihan);
            } else {
                $data['total_tagihan'] = 0;
            }

            //Menghitung Tagihan Terbayar
            $total_terbayar = $builder->selectSum('total_tagihan', 'jml_tagihan')
                ->where('tgl_tagihan >=', date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-10')))))
                ->where('id_mitra', $id_mitra)
                ->where('tgl_tagihan <=', date('Y-m-10'))
                ->where('status', 3)
                ->get()->getFirstRow();
            if ($total_terbayar) {
                $data['total_terbayar'] = ($total_terbayar->jml_tagihan);
            } else {
                $data['total_terbayar'] = 0;
            }
        } else {
            $data['jml_pelanggan_mitra'] = 0;
            $data['total_bhp'] = 0;
            $data['total_ppn'] = 0;
            $data['total_tagihan'] = 0;
            $data['total_terbayar'] = 0;
        }

        // Query ke database untuk mendapatkan data pelanggan
        $chart_pelanggan = $builder_pelanggan->select('periode, COUNT(*) as jumlah')
            ->groupBy('periode')
            ->orderBy('periode', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        // Format data
        $chart_data = [];
        foreach ($chart_pelanggan as $row) {
            $chart_data['values'][] = $row['jumlah'];
            $chart_data['labels'][] = $row['periode'] . ' (' . $row['jumlah'] . ')';
        }
        $data['chart_data'] = $chart_data;

        $data['title'] = 'Dashboard';
        $data['menu'] = 'beranda';

        return view('user/index', $data);
    }
}
