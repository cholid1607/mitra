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
use SimpleSoftwareIO\QrCode\Generator;

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

        $builder_pelanggan = $db->table('pelanggan');
        $pelanggan   = $builder_pelanggan->where('id_mitra', $id_mitra)->get()->getRowArray();

        $data['pelanggan'] = $pelanggan;
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
            ->get()->getRowArray();
        $last_piutang = $piutang['piutang'];
        $alamat = $piutang['alamat_pelanggan'];
        $telepon = $piutang['telp_pelanggan'];
        $layanan = $piutang['paket_langganan'];
        $kode_pelanggan = $piutang['kode_pelanggan'];
        $nama_pelanggan = $piutang['nama_pelanggan'];
        $id_mitra = $piutang['id_mitra'];

        //Ambil Data Billing
        $builder_billing = $db->table('billing');
        $billing   = $builder_billing->where('id_mitra', $id_mitra)->get()->getRowObject();
        $data['billing'] = $billing;

        //Ambil Data Mitra
        $builder_mitra = $db->table('mitra');
        $mitra   = $builder_mitra->where('id_mitra', $id_mitra)->get()->getRowArray();
        $data['nama_mitra'] = $mitra['nama_mitra'];
        $data['alamat_mitra'] = $mitra['alamat'];
        $data['telepon_mitra'] = $mitra['telepon'];
        $data['email_mitra'] = $mitra['email'];
        $data['logo_mitra'] = $mitra['logo'];

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
        $qrcode = new Generator;
        $qrCodes = [];
        $qrCodes = $qrcode->size(120)->generate('http://16.2.79.66/cekinvoice/view/' . $id_tagihan);
        $html = '<img width="50px" src="data:image/svg+xml;base64,' . base64_encode($qrCodes) . '" ...>';
        $data['qrcode'] = $html;
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
        // dd($data);

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

    public function qrcode()
    {
        $qrcode = new Generator;
        $qrCodes = [];
        $qrCodes['simple'] = $qrcode->size(120)->generate('https://www.binaryboxtuts.com/');
        $qrCodes['changeColor'] = $qrcode->size(120)->color(255, 0, 0)->generate('https://www.binaryboxtuts.com/');
        $qrCodes['changeBgColor'] = $qrcode->size(120)->color(0, 0, 0)->backgroundColor(255, 0, 0)->generate('https://www.binaryboxtuts.com/');

        $qrCodes['styleDot'] = $qrcode->size(120)->color(0, 0, 0)->backgroundColor(255, 255, 255)->style('dot')->generate('https://www.binaryboxtuts.com/');
        $qrCodes['styleSquare'] = $qrcode->size(120)->color(0, 0, 0)->backgroundColor(255, 255, 255)->style('square')->generate('https://www.binaryboxtuts.com/');
        $qrCodes['styleRound'] = $qrcode->size(120)->color(0, 0, 0)->backgroundColor(255, 255, 255)->style('round')->generate('https://www.binaryboxtuts.com/');

        //$qrCodes['withImage'] = $qrcode->size(200)->format('png')->merge('img/logo.png', .4)->generate('https://www.binaryboxtuts.com/');
        return view('tagihan/qr-codes', $qrCodes);
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
            ->get()->getRowArray();
        $id_mitra = $piutang['id_mitra'];
        $alamat = $piutang['alamat_pelanggan'];
        $telepon = $piutang['telp_pelanggan'];
        $layanan = $piutang['paket_langganan'];
        $kode_pelanggan = $piutang['kode_pelanggan'];
        $nama_pelanggan = $piutang['nama_pelanggan'];
        $piutang = $piutang['piutang'];

        //Ambil Data Billing
        $builder_billing = $db->table('billing');
        $billing   = $builder_billing->where('id_mitra', $id_mitra)->get()->getRowObject();
        $data['billing'] = $billing;

        //Ambil Data Mitra
        $builder_mitra = $db->table('mitra');
        $mitra   = $builder_mitra->where('id_mitra', $id_mitra)->get()->getRowArray();
        $data['nama_mitra'] = $mitra['nama_mitra'];

        $qrcode = new Generator;
        $qrCodes = [];
        $qrCodes = $qrcode->size(120)->generate('http://103.154.77.102:14045/admin/cekkuitansi/view/' . $id_kuitansi);
        $html = '<img width="50px" src="data:image/svg+xml;base64,' . base64_encode($qrCodes) . '" ...>';
        $data['qrcode'] = $html;

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
        $builder_mitra = $db->table('mitra');
        $mitra = $builder_mitra->where('id_mitra', $id_mitra)->get()->getFirstRow();
        $kode_mitra = $mitra->kode_mitra;

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
                $tgl_tagihan_init = $row['tgl_tagihan'];
                $tgl_tagihan_new = $tahun . "-" . $bulan . "-" . $tgl_tagihan_init;
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

                $tgl_invoice = $tahun . '-' . $bulan . '-' . $tgl_tagihan_init;
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
                $no_invoice = 'INV/' . $kode_mitra . '/' . $row['kode_pelanggan'] . '/' . $tahunnomer . '-' . $bulannomer . '/' . ++$last_inv;
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

    public function buatkuitansi()
    {
        //dd($_POST);
        $id_pelanggan = $this->request->getVar('id_pelanggan');
        $id_tagihan = $this->request->getVar('id_tagihan');
        $tahun = $this->request->getVar('tahun');
        $bulan = $this->request->getVar('bulan');
        $id_pembayaran = $this->request->getVar('id_pembayaran');

        //dd($bulan);
        //DB Connect dan Model Loader
        $db      = \Config\Database::connect();
        $kuitansiModel = new KuitansiModel();
        $tagihanModel = new TagihanModel();
        $tagihankuitansiModel = new TagihankuitansiModel();
        $logModel = new LogModel();

        //Menampilkan Data Pelanggan Berdasarkan ID Pelanggan
        $builder = $db->table('pelanggan');
        $pelanggan   = $builder->where('id_pelanggan', $id_pelanggan)->get()->getResultArray();
        $nama_pelanggan = $pelanggan[0]['nama_pelanggan'];
        $kode_pelanggan = $pelanggan[0]['kode_pelanggan'];
        $id_mitra = $pelanggan[0]['id_mitra'];

        $builder_mitra = $db->table('mitra');
        $mitra = $builder_mitra->where('id_mitra', $id_mitra)->get()->getFirstRow();
        $kode_mitra = $mitra->kode_mitra;

        $builder_tagihanakhir2 = $db->table('tagihan');
        $tagihan_akhir_builder2   = $builder_tagihanakhir2->where('id_tagihan', $id_tagihan)
            ->get()->getResultArray();
        //dd($id_tagihan_last);
        $nominal_kuitansi = $tagihan_akhir_builder2[0]['nominal'] + $tagihan_akhir_builder2[0]['ppn'];

        //Mendapatkan ID Kuitansi Terkahir
        $builderinv = $db->table('kuitansi');
        $kuitansi   = $builderinv->where('tahun', date("Y"))->orderBy('id_kuitansi', 'desc')->get()->getResultArray();

        if (!empty($kuitansi)) {
            $last_kuitansi = $kuitansi[0]['no_urut'];
        } else {
            $last_kuitansi = '0';
        }
        $bulan_skrng = date("m");
        if ($bulan_skrng == '01') {
            $bulannomer = 'I';
        } else if ($bulan_skrng == '02') {
            $bulannomer = 'II';
        } else if ($bulan_skrng == '03') {
            $bulannomer = 'III';
        } else if ($bulan_skrng == '04') {
            $bulannomer = 'IV';
        } else if ($bulan_skrng == '05') {
            $bulannomer = 'V';
        } else if ($bulan_skrng == '06') {
            $bulannomer = 'VI';
        } else if ($bulan_skrng == '07') {
            $bulannomer = 'VII';
        } else if ($bulan_skrng == '08') {
            $bulannomer = 'VIII';
        } else if ($bulan_skrng == '09') {
            $bulannomer = 'IX';
        } else if ($bulan_skrng == '10') {
            $bulannomer = 'X';
        } else if ($bulan_skrng == '11') {
            $bulannomer = 'XI';
        } else if ($bulan_skrng == '12') {
            $bulannomer = 'XII';
        }

        if ($bulan == '01') {
            $bulanhuruf = 'Januari';
        } else if ($bulan == '02') {
            $bulanhuruf = 'Februari';
        } else if ($bulan == '03') {
            $bulanhuruf = 'Maret';
        } else if ($bulan == '04') {
            $bulanhuruf = 'April';
        } else if ($bulan == '05') {
            $bulanhuruf = 'Mei';
        } else if ($bulan == '06') {
            $bulanhuruf = 'Juni';
        } else if ($bulan == '07') {
            $bulanhuruf = 'Juli';
        } else if ($bulan == '08') {
            $bulanhuruf = 'Agustus';
        } else if ($bulan == '09') {
            $bulanhuruf = 'September';
        } else if ($bulan == '10') {
            $bulanhuruf = 'Oktober';
        } else if ($bulan == '11') {
            $bulanhuruf = 'November';
        } else if ($bulan == '12') {
            $bulanhuruf = 'Desember';
        }

        //Mendapatkan Nomer Kuitansi Terbaru
        foreach ($pelanggan as $row) :
            $tahunnomer = substr(date("Y"), 2, 2);
            $no_kuitansi = 'PYI/' . $kode_mitra . '/' . $row['kode_pelanggan'] . '/' . $tahunnomer . '-' . $bulannomer . '/' . ++$last_kuitansi;
        endforeach;

        //Menyimpan Data Awal Kuitansi
        $datakuitansi = [
            'no_urut' => $last_kuitansi++,
            'no_kuitansi' => $no_kuitansi,
            'id_pembayaran' => $id_pembayaran,
            'id_pelanggan' => $id_pelanggan,
            'tgl_kuitansi' => date("Y-m-d"),
            'akun_bank' => '-',
            'bulan' => date("m"),
            'tahun' => date("Y"),
            'status' => 1
        ];
        $kuitansiModel->save($datakuitansi);

        //Get Data Terakhir Kuitansi
        $builder = $db->table('kuitansi');
        $kuitansiid   = $builder->where('id_pelanggan', $id_pelanggan)
            ->limit(0, 1)->orderBy('id_kuitansi', 'desc')
            ->get()->getResultArray();
        $last_idkuitansi = $kuitansiid[0]['id_kuitansi'];

        //Update Tagihan Terkahir yang Dipilih
        $datatagihanlast = [
            'id_tagihan' => $id_tagihan,
            'id_kuitansi' => $last_idkuitansi,
            'terbayar' => $nominal_kuitansi,
            'status' => '3'
        ];
        $tagihanModel->save($datatagihanlast);

        //Memasukkan Data Tagihan dan Kuitansi
        $item_layanan = 'Abonemen Internet bulan ' . $bulanhuruf . ' ' . $tahun;
        $datakuitansitagihan = [
            'id_tagihan' => $id_tagihan,
            'id_pelanggan' => $id_pelanggan,
            'item_layanan' => $item_layanan,
            'total_bayar' => $nominal_kuitansi,
            'kurang_bayar' => '0',
            'id_kuitansi' => $last_idkuitansi,
        ];
        $tagihankuitansiModel->save($datakuitansitagihan);

        $informasi_kuitansi = 'Pembayaran tagihan internet bulan ' . $bulanhuruf;
        $datakuitansi2 = [
            'id_kuitansi' => $last_idkuitansi,
            'nominal_kuitansi' => $nominal_kuitansi,
            'informasi_kuitansi' => $informasi_kuitansi,
            'piutang' => 0,
        ];
        $kuitansiModel->save($datakuitansi2);
        $username = user()->username;
        $deskripsilog_old = $username . " mengupdate pembayaran tagihan internet bulan <b>" . $bulanhuruf . " " . $tahun . "</b> 
        a.n <b>" . $nama_pelanggan . " (" . $kode_pelanggan . ")</b> senilai <b>Rp." . number_format($nominal_kuitansi) . "</b> 
        dengan nomor kuitansi <b>" . $no_kuitansi . "</b>";
        $cek1 = str_replace('<p>', '', $deskripsilog_old);
        $cek2 = str_replace('</p>', '', $cek1);
        $cek3 = str_replace('<ol>', '<ul>', $cek2);
        $deskripsilog = str_replace('<li>', '; ', $cek3);

        $datalog = [
            'tgl' => date("Y-m-d H:i:s"),
            'akun' => $username,
            'deskripsi' => $deskripsilog,
            'id_tagihan' => $id_tagihan,
            'tipe_log' => 'bayar-tagihan',
        ];

        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/tagihan/daftar/' . $id_mitra . '/' . $bulan . '/' . $tahun));
    }

    public function generate()
    {
        $id_mitra = $this->request->getVar('id_mitra');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        $db      = \Config\Database::connect();
        $builder = $db->table('pelanggan');
        $pelanggan   = $builder->where('status', '1')->where('id_mitra', $id_mitra)->get()->getResultArray();

        $builder_mitra = $db->table('mitra');
        $mitra = $builder_mitra->where('id_mitra', $id_mitra)->get()->getFirstRow();
        $kode_mitra = $mitra->kode_mitra;
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
            $tgl_tagihan_init = $row['tgl_tagihan'];
            $tgl_tagihan_new = $tahun . "-" . $bulan . "-" . $tgl_tagihan_init;
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

            $tgl_invoice = $tahun . '-' . $bulan . '-' . $tgl_tagihan_init;
            $tgl_tempo = date('Y-m-d', strtotime($tgl_invoice . ' + 7 days'));

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
            $no_invoice = 'INV/' . $kode_mitra . '/' . $row['kode_pelanggan'] . '/' . $tahunnomer . '-' . $bulannomer . '/' . ++$last_inv;
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

            $deskripsi = $username . " menerbitkan tagihan bulan <b>" . $bulankirim . "</b>";

            $datalog = [
                'tgl' => date("Y-m-d H:i:s"),
                'akun' => $username,
                'deskripsi' => $deskripsi,
                'tipe_log' => 'generate-tagihan'
            ];
        endforeach;
        $logModel->save($datalog);
        session()->setFlashdata('pesan', 'Berhasil Menerbitkan Periode Tagihan');
        //return view('tagihan/daftar', $data);  
        return redirect()->to(base_url('/tagihan/daftar/' . $id_mitra . '/' . $bulan . '/' . $tahun));
    }
}
