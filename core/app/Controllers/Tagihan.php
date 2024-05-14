<?php


namespace App\Controllers;

require 'core/vendor/autoload.php';

use App\Models\PelangganModel;
use App\Models\TagihanModel;
use App\Models\LogModel;
use App\Models\InvoiceModel;
use App\Models\KuitansiModel;
use App\Models\PiutangModel;
use App\Models\TagihankuitansiModel;
use PhpParser\Node\Expr\New_;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Dompdf\Dompdf;
use Dompdf\Options;



class Tagihan extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Kelola Tagihan';
        $data['menu'] = 'tagihan';
        return view('tagihan/index', $data);
    }

    public function list()
    {
        if ($this->request->getVar('id_mitra') == '0') {
            session()->setFlashdata('pesan', 'Mitra Harus dipilih');
            return redirect()->back();
        }

        if ($this->request->getVar('id_mitra')) {
            $id_mitra = $this->request->getVar('id_mitra');
        } else {
            $username = user()->username;
            $db      = \Config\Database::connect();
            $builder = $db->table('mitra');
            $mitra = $builder->select('id_mitra')->where('username', $username)->get()->getResultArray();
            $id_mitra = $mitra[0]['id_mitra'];
        }

        $db = \Config\Database::connect();
        $builder = $db->table('mitra');
        $mitra_q = $builder->select('nama_mitra')->where('id_mitra', $id_mitra)->get()->getResultArray();
        $nama_mitra = $mitra_q[0]['nama_mitra'];

        // Status Tagihan
        $db      = \Config\Database::connect();
        $builder = $db->table('tagihan');
        $statustagihan = ['3', '5', '6'];
        $data['januari'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '01')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['februari'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '02')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['maret'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '03')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['april'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '04')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['mei'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '05')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['juni'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '06')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['juli'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '07')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['agustus'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '08')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['september'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '09')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['oktober'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '10')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['november'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '11')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();
        $data['desember'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '12')->where('tahun', date("Y"))->whereIn('status', $statustagihan)->countAllResults();

        //Jumlah Invoice Terbit
        $builder_inv = $db->table('invoice');
        $statusterbit = ['1', '2', '3', '4'];
        $data['inv_januari'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '01')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_februari'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '02')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_maret'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '03')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_april'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '04')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_mei'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '05')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_juni'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '06')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_juli'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '07')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_agustus'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '08')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_september'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '09')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_oktober'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '10')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_november'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '11')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_desember'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '12')->where('tahun', date("Y"))->whereIn('status', $statusterbit)->countAllResults();

        //Total Tagihan
        $status = ['3'];
        $data['tagihan_januari'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '01')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_februari'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '02')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_maret'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '03')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_april'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '04')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_mei'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '05')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_juni'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '06')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_juli'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '07')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_agustus'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '08')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_september'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '09')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_oktober'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '10')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_november'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '11')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_desember'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '12')->whereNotIn('status', $status)->get()->getResultArray();

        //Total Tagihan Terbayar
        $status_terbayar = ['3', '4'];
        $data['terbayar_januari'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '01')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_februari'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '02')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_maret'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '03')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_april'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '04')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_mei'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '05')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_juni'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '06')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_juli'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '07')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_agustus'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '08')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_september'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '09')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_oktober'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '10')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_november'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '11')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_desember'] = $builder->selectSUM('terbayar')->where('id_mitra', $id_mitra)->where('tahun', date("Y"))->where('bulan', '12')->whereIN('status', $status_terbayar)->get()->getResultArray();

        $data['title'] = 'Status Tagihan';
        $data['menu'] = 'tagihan';
        $data['id_mitra'] = $id_mitra;
        $data['nama_mitra'] = $nama_mitra;
        return view('tagihan/list', $data);
    }

    public function daftar($id_mitra = '', $bulan = '', $tahun = '')
    {
        //Menampilkan Tagihan Berdasarkan Bulan
        $db      = \Config\Database::connect();
        $builder = $db->table('tagihan');
        $tagihan   = $builder->where('id_mitra', $id_mitra)->where('bulan', $bulan)->where('tahun', $tahun)->orderBy('id_pelanggan', 'asc')->get()->getResultArray();
        $bulancek = $bulan;
        $tahuncek = $tahun;
        if ($bulancek == '01') {
            $bulankirim = 'Januari';
        } else if ($bulancek == '02') {
            $bulankirim = 'Februari';
        } else if ($bulancek == '03') {
            $bulankirim = 'Maret';
        } else if ($bulancek == '04') {
            $bulankirim = 'April';
        } else if ($bulancek == '05') {
            $bulankirim = 'Mei';
        } else if ($bulancek == '06') {
            $bulankirim = 'Juni';
        } else if ($bulancek == '07') {
            $bulankirim = 'Juli';
        } else if ($bulancek == '08') {
            $bulankirim = 'Agustus';
        } else if ($bulancek == '09') {
            $bulankirim = 'September';
        } else if ($bulancek == '10') {
            $bulankirim = 'Oktober';
        } else if ($bulancek == '11') {
            $bulankirim = 'November';
        } else if ($bulancek == '12') {
            $bulankirim = 'Desember';
        }
        $data['title'] = 'Kelola Tagihan';
        $data['menu'] = 'tagihan';
        $data['bulan'] = $bulankirim;
        $data['bulan_angka'] = $bulancek;
        $data['tahun'] = $tahuncek;
        $data['tagihan'] = $tagihan;
        $data['id_mitra'] = $id_mitra;

        return view('tagihan/daftar', $data);
    }

    public function tampilkan(): string
    {
        if ($this->request->getVar('id_mitra')) {
            $id_mitra = $this->request->getVar('id_mitra');
        } else {
            $username = user()->username;
            $db      = \Config\Database::connect();
            $builder = $db->table('mitra');
            $mitra = $builder->select('id_mitra')->where('username', $username)->get()->getFirstRow();
            $id_mitra = $mitra->id_mitra;
        }
        $db = \Config\Database::connect();
        $builder = $db->table('mitra');
        $mitra_q = $builder->select('nama_mitra')->where('id_mitra', $id_mitra)->get()->getResultArray();
        $nama_mitra = $mitra_q[0]['nama_mitra'];

        $tahun = $this->request->getVar('tahun');
        // Status Tagihan
        $db      = \Config\Database::connect();
        $builder = $db->table('tagihan');
        $statustagihan = ['3', '5', '6'];
        $data['januari'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '01')->whereIn('status', $statustagihan)->countAllResults();
        $data['februari'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '02')->whereIn('status', $statustagihan)->countAllResults();
        $data['maret'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '03')->whereIn('status', $statustagihan)->countAllResults();
        $data['april'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '04')->whereIn('status', $statustagihan)->countAllResults();
        $data['mei'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '05')->whereIn('status', $statustagihan)->countAllResults();
        $data['juni'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '06')->whereIn('status', $statustagihan)->countAllResults();
        $data['juli'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '07')->whereIn('status', $statustagihan)->countAllResults();
        $data['agustus'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '08')->whereIn('status', $statustagihan)->countAllResults();
        $data['september'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '09')->whereIn('status', $statustagihan)->countAllResults();
        $data['oktober'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '10')->whereIn('status', $statustagihan)->countAllResults();
        $data['november'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '11')->whereIn('status', $statustagihan)->countAllResults();
        $data['desember'] = $builder->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '12')->whereIn('status', $statustagihan)->countAllResults();

        //Jumlah Invoice Terbit
        $builder_inv = $db->table('invoice');
        $statusterbit = ['1', '2', '3', '4'];
        $data['inv_januari'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '01')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_februari'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '02')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_maret'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '03')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_april'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '04')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_mei'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '05')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_juni'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '06')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_juli'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '07')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_agustus'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '08')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_september'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '09')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_oktober'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '10')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_november'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '11')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();
        $data['inv_desember'] = $builder->where('id_mitra', $id_mitra)->where('bulan', '12')->where('tahun', $tahun)->whereIn('status', $statusterbit)->countAllResults();

        //Total Tagihan
        $status = ['3'];
        $data['tagihan_januari'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '01')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_februari'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '02')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_maret'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '03')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_april'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '04')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_mei'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '05')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_juni'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '06')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_juli'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '07')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_agustus'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '08')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_september'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '09')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_oktober'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '10')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_november'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '11')->whereNotIn('status', $status)->get()->getResultArray();
        $data['tagihan_desember'] = $builder->selectSUM('total_tagihan')->where('id_mitra', $id_mitra)->where('tahun', $tahun)->where('bulan', '12')->whereNotIn('status', $status)->get()->getResultArray();

        //Total Tagihan Terbayar
        $status_terbayar = ['3', '4'];
        $data['terbayar_januari'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '01')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_februari'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '02')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_maret'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '03')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_april'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '04')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_mei'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '05')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_juni'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '06')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_juli'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '07')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_agustus'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '08')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_september'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '09')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_oktober'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '10')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_november'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '11')->whereIN('status', $status_terbayar)->get()->getResultArray();
        $data['terbayar_desember'] = $builder->selectSUM('terbayar')->where('tahun', $tahun)->where('bulan', '12')->whereIN('status', $status_terbayar)->get()->getResultArray();


        $data['title'] = 'Status Tagihan';
        $data['menu'] = 'tagihan';
        $data['tahun_pilih'] = $tahun;
        $data['id_mitra'] = $id_mitra;
        $data['nama_mitra'] = $nama_mitra;
        return view('tagihan/sebelumnya', $data);
    }

    function tagihanAjax($bulan = 0, $tahun = 0, $id_mitra = 0)
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $datatagihan = new TagihanModel();
        $data = $datatagihan->searchAndDisplay($search_value, $bulan, $tahun, $id_mitra, $start, $length);
        $total_count = $datatagihan->searchAndDisplay($search_value, $bulan, $tahun, $id_mitra);
        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($total_count),
            'data' => $data,
        );
        echo json_encode($json_data);
    }

    public function downloadinvoice($id_pelanggan = '', $id_tagihan = '', $tahun = '', $bulan = '', $stream = true)
    {
        //DB Connect dan Model Loader
        $db      = \Config\Database::connect();

        //Cek Tagihan Terakhir
        $builder = $db->table('tagihan');
        $tagihan   = $builder->where('tagihan.id_tagihan', $id_tagihan)
            ->where('tagihan.bulan', $bulan)
            ->where('tagihan.tahun', $tahun)
            ->join('invoice', 'invoice.id_invoice = tagihan.id_invoice')
            ->get()->getResultArray();
        //dd($tagihan);
        $no_invoice = $tagihan[0]['no_invoice'];
        //Cek Tagihan Belum Lunas
        $builder = $db->table('tagihan');
        $status = ['3'];
        $bulanterakhir = [$bulan];
        $tahunterakhir = [$tahun];
        $tagihan_piutang   = $builder->whereNotIn('tagihan.status', $status)
            ->whereNotIn('tagihan.bulan', $bulanterakhir)
            //->where('tagihan.tahun', $tahunterakhir)
            ->where('tagihan.id_pelanggan', $id_pelanggan)
            ->join('invoice', 'invoice.id_invoice = tagihan.id_invoice', 'inner')
            ->orderBy('tagihan.tahun', 'asc')
            ->orderBy('tagihan.bulan', 'asc')
            ->get()->getResultArray();

        //Cek Total Piutang
        $builder = $db->table('pelanggan');
        $piutang   = $builder->where('id_pelanggan', $id_pelanggan)
            ->limit(0, 1)
            ->get()->getResultArray();
        $last_piutang = $piutang[0]['piutang'];
        $alamat = $piutang[0]['alamat_pelanggan'];
        $telepon = $piutang[0]['telp_pelanggan'];
        $layanan = $piutang[0]['paket_langganan'];
        $kode_pelanggan = $piutang[0]['kode_pelanggan'];
        $nama_pelanggan = $piutang[0]['nama_pelanggan'];


        $data['last_piutang'] = $last_piutang;
        $data['tagihan_piutang'] = $tagihan_piutang;
        $data['alamat'] = $alamat;
        $data['telepon'] = $telepon;
        $data['layanan'] = $layanan;
        $data['kode_pelanggan'] = $kode_pelanggan;
        $data['nama_pelanggan'] = $nama_pelanggan;
        $data['no_invoice'] = $no_invoice;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['last_tagihan'] = $tagihan;
        $data['title'] = 'Konfirmasi Tagihan';
        $data['menu'] = 'tagihan';
        $str_no_invoice = str_replace("/", "_", $no_invoice);
        $filename2 = 'Invoice ' . $str_no_invoice . ' - ' . $nama_pelanggan;
        //Setup Option Dompdf
        $option = new Options();
        $option->set('enabled', true);
        $option->set('isHtml5ParserEnabled', true);
        $option->set('isPhpEnabled', true);
        $option->set('isFontSubsettingEnabled', false);
        $option->set('pdfBackend', 'CPDF');
        $option->set('isRemoteEnabled', true);
        $option->set('chroot', realpath(''));
        $option->setTempDir('temp');

        // instantiate and use the dompdf class
        $dompdf = new Dompdf($option);
        //$dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('tagihan/downloadinvoice', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        if ($stream) {
            $dompdf->stream($filename2, array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }

    public function downloadkuitansi($id_pelanggan = '', $id_kuitansi = '', $tahun = '', $bulan = '', $stream = true)
    {
        //DB Connect dan Model Loader
        $db      = \Config\Database::connect();
        //Cek Data Kuitansi

        $builder = $db->table('kuitansi');
        $kuitansi   = $builder->where('kuitansi.id_pelanggan', $id_pelanggan)
            ->where('kuitansi.id_kuitansi', $id_kuitansi)
            ->limit(1)
            ->join('tagihan_kuitansi', 'tagihan_kuitansi.id_kuitansi = kuitansi.id_kuitansi')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kuitansi.id_pelanggan')
            ->get()->getResultArray();
        //dd($kuitansi);
        $id_kuitansi = $kuitansi[0]['id_kuitansi'];
        $no_kuitansi = $kuitansi[0]['no_kuitansi'];
        //Cek Tagihan Terakhir
        $builder = $db->table('tagihan_kuitansi');
        $tagihankuitansi   = $builder->where('tagihan_kuitansi.id_kuitansi', $id_kuitansi)
            ->get()->getResultArray();

        //Cek Total Piutang
        $builder = $db->table('pelanggan');
        $piutang   = $builder->where('id_pelanggan', $id_pelanggan)
            ->limit(0, 1)
            ->get()->getResultArray();
        $alamat = $piutang[0]['alamat_pelanggan'];
        $telepon = $piutang[0]['telp_pelanggan'];
        $layanan = $piutang[0]['paket_langganan'];
        $kode_pelanggan = $piutang[0]['kode_pelanggan'];
        $nama_pelanggan = $piutang[0]['nama_pelanggan'];
        $piutang = $piutang[0]['piutang'];


        $data['kuitansi'] = $kuitansi;
        $data['tagihankuitansi'] = $tagihankuitansi;
        $data['no_kuitansi'] = $no_kuitansi;
        $data['alamat'] = $alamat;
        $data['telepon'] = $telepon;
        $data['layanan'] = $layanan;
        $data['kode_pelanggan'] = $kode_pelanggan;
        $data['nama_pelanggan'] = $nama_pelanggan;
        $data['piutang'] = $piutang;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = 'Konfirmasi Tagihan';
        $data['menu'] = 'tagihan';
        $str_no_kuitansi = str_replace("/", "_", $no_kuitansi);
        $filenamekuitansi = 'Kuitansi ' . $str_no_kuitansi . ' - ' . $nama_pelanggan;
        //Setup Option Dompdf
        $option = new Options();
        $option->set('enabled', true);
        $option->set('isHtml5ParserEnabled', true);
        $option->set('isPhpEnabled', true);
        $option->set('isFontSubsettingEnabled', false);
        $option->set('pdfBackend', 'CPDF');
        $option->set('isRemoteEnabled', true);
        $option->set('chroot', realpath(''));
        $option->setTempDir('temp');

        // instantiate and use the dompdf class
        $dompdf = new Dompdf($option);
        //$dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('tagihan/downloadkuitansi', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        if ($stream) {
            $dompdf->stream($filenamekuitansi, array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }

    public function bataltagihanindividu()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $id_pelanggan = $this->request->getVar('id_pelanggan');
        $id_mitra = $this->request->getVar('id_mitra');
        $db      = \Config\Database::connect();

        $builder = $db->table('tagihan');
        $tagihan   = $builder->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('id_pelanggan', $id_pelanggan)
            ->get()->getResultArray();
        $id_tagihan = $tagihan[0]['id_tagihan'];
        $id_kuitansi = $tagihan[0]['id_kuitansi'];

        $pelangganModel = new PelangganModel();
        $tagihanModel = new TagihanModel();
        $tagihankuitansiModel = new TagihankuitansiModel();
        $kuitansiModel = new KuitansiModel();
        $invoiceModel = new InvoiceModel();
        $logModel = new LogModel();
        $username = user()->username;

        //$pelanggan = $pelangganModel->findAll();
        foreach ($tagihan as $row) :
            //Get Data Pelanggan dari Data Tagihan
            $total_tagihan = $row['total_tagihan'];
            $builderpelanggan = $db->table('pelanggan');
            $pelanggan   = $builderpelanggan->where('id_pelanggan', $id_pelanggan)
                ->get()->getResultArray();
            $piutang = $pelanggan[0]['piutang'];
            $nama_pelanggan = $pelanggan[0]['nama_pelanggan'];
            //Update Piutang Tagihan
            $piutang_baru = (float)$piutang - (float)$total_tagihan;
            $datapiutang = [
                'id_pelanggan' => $row['id_pelanggan'],
                'piutang' => $piutang_baru
            ];
            $pelangganModel->save($datapiutang);

            //Hapus Data Tagihan
            $tagihanModel->where('id_tagihan', $id_tagihan)->delete();

            //Hapus Data Tagihan Kuitansi
            $tagihankuitansiModel->where('id_kuitansi', $id_kuitansi)->delete();

            //Hapus Data Kuitansi
            $kuitansiModel->where('id_kuitansi', $id_kuitansi)->delete();

            //Hapus Data Invoice
            $invoiceModel->where('id_tagihan', $id_tagihan)->delete();

            if ($bulan == '01') {
                $bulankirim = 'Januari';
            } else if ($bulan == '02') {
                $bulankirim = 'Februari';
            } else if ($bulan == '03') {
                $bulankirim = 'Maret';
            } else if ($bulan == '04') {
                $bulankirim = 'April';
            } else if ($bulan == '05') {
                $bulankirim = 'Mei';
            } else if ($bulan == '06') {
                $bulankirim = 'Juni';
            } else if ($bulan == '07') {
                $bulankirim = 'Juli';
            } else if ($bulan == '08') {
                $bulankirim = 'Agustus';
            } else if ($bulan == '09') {
                $bulankirim = 'September';
            } else if ($bulan == '10') {
                $bulankirim = 'Oktober';
            } else if ($bulan == '11') {
                $bulankirim = 'November';
            } else if ($bulan == '12') {
                $bulankirim = 'Desember';
            }

            $deskripsi = $username . " membatalkan tagihan bulan <b>" . $bulankirim . " " . $tahun . "</b> a.n <b>" . $nama_pelanggan . "</b>";

            $datalog = [
                'tgl' => date("Y-m-d H:i:s"),
                'akun' => $username,
                'deskripsi' => $deskripsi,
                'tipe_log' => 'batal-tagihan'
            ];
        endforeach;
        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Berhasil Membatalkan Tagihan bulan <b>' . $bulankirim . ' ' . $tahun . '</b> a.n <b>' . $nama_pelanggan . '</b>');
        //return redirect()->to(base_url('/tagihan/index'));
        $builder = $db->table('tagihan');
        $tagihan   = $builder->where('bulan', $bulan)->where('tahun', $tahun)->orderBy('id_pelanggan', 'asc')->get()->getResultArray();
        $data['title'] = 'Kelola Tagihan';
        $data['menu'] = 'tagihan';
        $data['bulan'] = $bulankirim;
        $data['bulan_angka'] = $bulan;
        $data['tahun'] = $tahun;
        $data['tagihan'] = $tagihan;
        //return view('tagihan/daftar', $data);  
        return redirect()->to(base_url('/tagihan/daftar/' . $id_mitra . '/' . $bulan . '/' . $tahun));
    }

    public function terbitindividu()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $id_pelanggan = $this->request->getVar('id_pelanggan');
        $id_mitra = $this->request->getVar('id_mitra');

        $db      = \Config\Database::connect();
        $buildercektagihan = $db->table('tagihan');
        $tagihan = $buildercektagihan->where('id_pelanggan', $id_pelanggan)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()->getResultArray();
        if (empty($tagihan)) {
            $builder = $db->table('pelanggan');
            $pelanggan   = $builder->where('id_pelanggan', $id_pelanggan)
                ->get()->getResultArray();

            $pelangganModel = new PelangganModel();
            $tagihanModel = new TagihanModel();
            $invoiceModel = new InvoiceModel();
            $logModel = new LogModel();
            $username = user()->username;

            //$pelanggan = $pelangganModel->findAll();
            foreach ($pelanggan as $row) :
                $harga = $row['harga'];
                $ppn = $row['ppn'];
                $total_tagihan = $harga + $ppn;
                $tgl_tagihan_new = $tahun . "-" . $bulan . "-" . 01;
                $data = [
                    'id_pelanggan' => $row['id_pelanggan'],
                    'id_mitra' => $id_mitra,
                    'kode_pelanggan' => $row['kode_pelanggan'],
                    'nama_pelanggan' => $row['nama_pelanggan'],
                    'tgl_tagihan' => $tgl_tagihan_new,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nominal' => $harga,
                    'ppn' => $ppn,
                    'total_tagihan' => $total_tagihan,
                    'terbayar' => '0',
                    'status' => '1',
                ];
                $tagihanModel->save($data);

                $buildercektagihan = $db->table('tagihan');
                $cektagihan = $buildercektagihan->where('id_pelanggan', $row['id_pelanggan'])
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->get()->getResultArray();
                $id_tagihan = $cektagihan[0]['id_tagihan'];

                if ($bulan == '01') {
                    $bulankirim = 'Januari';
                } else if ($bulan == '02') {
                    $bulankirim = 'Februari';
                } else if ($bulan == '03') {
                    $bulankirim = 'Maret';
                } else if ($bulan == '04') {
                    $bulankirim = 'April';
                } else if ($bulan == '05') {
                    $bulankirim = 'Mei';
                } else if ($bulan == '06') {
                    $bulankirim = 'Juni';
                } else if ($bulan == '07') {
                    $bulankirim = 'Juli';
                } else if ($bulan == '08') {
                    $bulankirim = 'Agustus';
                } else if ($bulan == '09') {
                    $bulankirim = 'September';
                } else if ($bulan == '10') {
                    $bulankirim = 'Oktober';
                } else if ($bulan == '11') {
                    $bulankirim = 'November';
                } else if ($bulan == '12') {
                    $bulankirim = 'Desember';
                }

                $tgl_invoice = $tahun . '-' . $bulan . '-' . 01;
                $tgl_tempo = date('Y-m-d', strtotime($tgl_invoice . ' + 7 days'));

                $db      = \Config\Database::connect();
                $builder = $db->table('pelanggan');
                $pelanggan   = $builder->where('id_pelanggan', $row['id_pelanggan'])->get()->getResultArray();

                $builderinv = $db->table('invoice');
                $invoice   = $builderinv->where('tahun', date("Y"))->orderBy('id_invoice', 'desc')->get()->getResultArray();

                if (!empty($invoice)) {
                    $last_inv = $invoice[0]['no_urut'];
                } else {
                    $last_inv = '0';
                }

                if ($bulan == '01') {
                    $bulannomer = 'I';
                } else if ($bulan == '02') {
                    $bulannomer = 'II';
                } else if ($bulan == '03') {
                    $bulannomer = 'III';
                } else if ($bulan == '04') {
                    $bulannomer = 'IV';
                } else if ($bulan == '05') {
                    $bulannomer = 'V';
                } else if ($bulan == '06') {
                    $bulannomer = 'VI';
                } else if ($bulan == '07') {
                    $bulannomer = 'VII';
                } else if ($bulan == '08') {
                    $bulannomer = 'VIII';
                } else if ($bulan == '09') {
                    $bulannomer = 'IX';
                } else if ($bulan == '10') {
                    $bulannomer = 'X';
                } else if ($bulan == '11') {
                    $bulannomer = 'XI';
                } else if ($bulan == '12') {
                    $bulannomer = 'XII';
                }

                $tahunnomer = substr(date("Y"), 2, 2);
                $no_invoice = 'INV/TTN/' . $row['kode_pelanggan'] . '/' . $bulannomer . '/' . $tahunnomer . '/' . ++$last_inv;
                $item_layanan = 'Abonemen Internet Periode Bulan ' . $bulankirim . ' ' . $tahun;


                //Simpan Data Invoice
                $data = [
                    'no_invoice' => $no_invoice,
                    'no_urut' => $last_inv++,
                    'id_pelanggan' => $row['id_pelanggan'],
                    'id_tagihan' => $id_tagihan,
                    'tgl_invoice' => $tgl_invoice,
                    'tgl_jatuhtempo' => $tgl_tempo,
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'kode_pelanggan' => $row['kode_pelanggan'],
                    'nama_pelanggan' => $row['nama_pelanggan'],
                    'item_layanan' => $item_layanan,
                    'keterangan' => '',
                    'status' => 0
                ];
                $invoiceModel->save($data);

                //Update Status Tagihan
                $invoice_idbuilder   = $builderinv->where('no_invoice', $no_invoice)
                    ->get()->getResultArray();
                $new_idinvoice = $invoice_idbuilder[0]['id_invoice'];

                $datatagihan = [
                    'id_tagihan' => $id_tagihan,
                    'no_invoice' => $no_invoice,
                    'id_invoice' => $new_idinvoice,
                    'status' => 1
                ];
                $tagihanModel->save($datatagihan);

                $deskripsi = $username . " menerbitkan tagihan individu a.n <b>" . $row['nama_pelanggan'] . "</b> bulan <b>" . $bulankirim . " " . $tahun . "</b>";

                $datalog = [
                    'tgl' => date("Y-m-d H:i:s"),
                    'akun' => $username,
                    'deskripsi' => $deskripsi,
                    'tipe_log' => 'generate-tagihan'
                ];
            endforeach;
            $logModel->save($datalog);
            session()->setFlashdata('pesan', 'Berhasil Menerbitkan Tagihan Individu');
            //return redirect()->to(base_url('/tagihan/index'));
            $builder = $db->table('tagihan');
            $tagihan   = $builder->where('bulan', $bulan)->where('tahun', $tahun)->orderBy('id_pelanggan', 'asc')->get()->getResultArray();
            $data['title'] = 'Kelola Tagihan';
            $data['menu'] = 'tagihan';
            $data['bulan'] = $bulankirim;
            $data['bulan_angka'] = $bulan;
            $data['tahun'] = $tahun;
            $data['tagihan'] = $tagihan;
            //return view('tagihan/daftar', $data);  
            return redirect()->to(base_url('/tagihan/daftar/' . $id_mitra . '/' . $bulan . '/' . $tahun));
        } else {
            session()->setFlashdata('error_tagihan', 'Tagihan Sudah Diterbitkan Sebelumnya');
            return redirect()->to(base_url('/pelanggan/detail/' . $id_pelanggan));
        }
    }

    public function generate()
    {
        dd($_POST);
    }
}
