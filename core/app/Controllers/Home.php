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
            $total_bhp = $builder->selectSum('total_tagihan', 'jml_tagihan')
                ->where('tgl_tagihan >=', date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-10')))))
                ->where('id_mitra', $id_mitra)
                ->where('tgl_tagihan <=', date('Y-m-10'))
                ->get()->getFirstRow();
            if ($total_bhp) {
                $data['total_bhp'] = ($total_bhp->jml_tagihan) * 0.0125;
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
        }

        // Query ke database untuk mendapatkan data pelanggan
        $chart_pelanggan = $builder_pelanggan->select("DATE_FORMAT(tgl_registrasi, '%M %Y') AS periode, 
                          COUNT(*) AS jumlah");
        $chart_pelanggan = $builder_pelanggan->where("tgl_registrasi >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 5 MONTH), '%Y-%m-10')");
        $chart_pelanggan = $builder_pelanggan->where("tgl_registrasi < DATE_FORMAT(NOW(), '%Y-%m-10')");
        $chart_pelanggan = $builder_pelanggan->groupBy("periode");
        $chart_pelanggan = $builder_pelanggan->orderBy("periode", "DESC");
        $chart_pelanggan = $builder_pelanggan->limit(5);
        $chart_pelanggan = $builder_pelanggan->get()->getResultArray();


        $chart_pelanggan = $builder_pelanggan->select('periode, COUNT(*) as jumlah')
            ->groupBy('periode')
            ->orderBy('periode', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Format data
        $chart_data = [];
        foreach ($chart_pelanggan as $row) {
            $chart_data['values'][] = $row['periode'];
            $chart_data['labels'][] = $row['jumlah'];
        }
        $data['chart_data'] = $chart_data;

        $data['title'] = 'Dashboard';
        $data['menu'] = 'beranda';

        return view('user/index', $data);
    }
}
