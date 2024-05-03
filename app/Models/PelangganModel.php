<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PelangganModel extends Model
{
    protected $table      = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pelanggan', 'kode_pelanggan', 'tgl_pemasangan', 'tgl_tagihan', 'nama_pelanggan', 'nik_pelanggan',
        'alamat_pelanggan', 'telp_pelanggan', 'paket_langganan', 'bandwidth', 'kualifikasi',
        'periode', 'harga', 'ppn', 'nominal', 'piutang', 'kualifikasi_prioritas', 'ket_pelanggan', 'alamat_pemasangan',
        'bts', 'metode_pemasangan', 'ap_nama_dude', 'ip_akses_point', 'ap_nama_device', 'ip_radio_st',
        'ap_ssid', 'ap_antena', 'ap_besi', 'ap_login', 'ap_password', 'ket_ap', 'ip_station', 'st_nama_device',
        'st_ssid', 'st_antena', 'st_besi', 'st_login', 'st_password', 'ket_st', 'nama_hotspot', 'ip_hotspot',
        'login_hotspot', 'password_hotspot', 'ket_perangkat', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    function searchAndDisplay($katakunci = null, $start = 0, $length = 0)
    {
        $builder = $this->table('pelanggan');
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($arr_katakunci); $x++) {
                $builder = $builder->like('nama_pelanggan', $arr_katakunci[$x]);
                $builder = $builder->orLike('kode_pelanggan', $arr_katakunci[$x]);
            }
        }
        if ($start != 0 || $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        return $builder->orderBy('id_pelanggan')->get()->getResult();
    }
}
