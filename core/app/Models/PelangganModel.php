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
        'id_pelanggan',
        'tgl_registrasi',
        'tgl_tagihan',
        'periode',
        'id_mitra',
        'kode_pelanggan',
        'urut',
        'nama_pelanggan',
        'nik_pelanggan',
        'alamat_pelanggan',
        'alamat_pemasangan',
        'telp_pelanggan',
        'paket_langganan',
        'bandwidth',
        'harga',
        'ppn',
        'nominal',
        'piutang',
        'ket_pelanggan',
        'status'
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

    function searchAndDisplay($katakunci = null, $id = 0, $start = 0, $length = 0)
    {
        $builder = $this->table('pelanggan');
        if ($builder != '0') {
            $builder = $builder->where('id_mitra', $id);
        }
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

    function searchAndDisplayAll($katakunci = null, $start = 0, $length = 0)
    {
        $builder = $this->table('pelanggan');
        $builder->select('pelanggan.*, mitra.nama_mitra'); // Menambahkan kolom nama_mitra
        $builder->join('mitra', 'mitra.id_mitra = pelanggan.id_mitra', 'left'); // Melakukan LEFT JOIN dengan tabel mitra
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($arr_katakunci); $x++) {
                $builder = $builder->like('pelanggan.nama_pelanggan', $arr_katakunci[$x]);
                $builder = $builder->orLike('pelanggan.kode_pelanggan', $arr_katakunci[$x]);
            }
        }
        if ($start != 0 || $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        $builder = $builder->orderBy('pelanggan.id_mitra', 'desc');
        return $builder->orderBy('pelanggan.id_pelanggan')->get()->getResult();
    }
}
