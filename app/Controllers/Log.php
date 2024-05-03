<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\PelangganModel;

class Log extends BaseController
{

    public function index(): string
    {
        $bulan = $this->request->getVar('bulan') != '' ? $this->request->getVar('bulan') : date('m');
        $tahun = $this->request->getVar('tahun') != '' ? $this->request->getVar('tahun') : date('Y');
        $db      = \Config\Database::connect();
        $builder = $db->table('log');
        $log = $builder->where('MONTH(tgl)', $bulan)
            ->where('YEAR(tgl)', $tahun)
            ->orderBy('tgl', 'desc')
            ->get()->getResultArray();
        $data['log'] = $log;
        $data['title'] = 'Kelola Log';
        $data['menu'] = 'log';
        $data['bulan_log'] = $bulan;
        $data['tahun_log'] = $tahun;
        return view('log/index', $data);
    }

    function logAjax2($bulan = 0, $tahun = 0)
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $datalog = new LogModel();
        $data = $datalog->searchAndDisplay($search_value, $bulan, $tahun, $start, $length);
        $total_count = $datalog->searchAndDisplay($search_value, $bulan, $tahun);
        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($total_count),
            'data' => $data,
        );
        echo json_encode($json_data);
    }

    function logAjax($bulan = 0, $tahun = 0)
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $datalog = new LogModel();
        $data = $datalog->searchAndDisplay($search_value, $bulan, $tahun, $start, $length);
        $total_count = $datalog->searchAndDisplay($search_value, $bulan, $tahun); // Total count without pagination
        $filtered_count = $datalog->searchAndDisplay($search_value, $bulan, $tahun, 0, 0); // Total count for filtered data
        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($filtered_count),
            'data' => $data,
        );
        echo json_encode($json_data);
    }
}
