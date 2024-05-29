<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'log';
    protected $primaryKey = 'id_log';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'tgl', 'akun', 'deskripsi', 'tipe_log', 'id_pelanggan', 'id_pembayaran', 'id_mitra'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function searchAndDisplay($katakunci = null, $bulan = 0, $tahun = 0, $start = 0, $length = 0)
    {
        $builder = $this->table('log');
        $builder = $builder->where('MONTH(tgl)', $bulan)->where('YEAR(tgl)', $tahun);
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($arr_katakunci); $x++) {
                $builder = $builder->like('deskripsi', $arr_katakunci[$x]);
                $builder = $builder->orLike('tipe_log', $arr_katakunci[$x]);
            }
        }
        if ($start != 0 || $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        return $builder->orderBy('tgl', 'desc')->get()->getResult();
    }

    function searchAndDisplayAdmin($katakunci = null, $bulan = 0, $tahun = 0, $start = 0, $length = 0)
    {
        $builder = $this->table('log');
        $builder = $builder->where('MONTH(tgl)', $bulan)->where('YEAR(tgl)', $tahun);
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($arr_katakunci); $x++) {
                $builder = $builder->like('deskripsi', $arr_katakunci[$x]);
            }
        }
        $builder = $builder->where('tipe_log', 'generate-tagihan');
        $builder = $builder->orWhere('tipe_log', 'bayar-tagihan');
        $builder = $builder->orWhere('tipe_log', 'batal-tagihan');
        $builder = $builder->orWhere('tipe_log', 'update-tagihan');
        $builder = $builder->orWhere('tipe_log', 'tambah-pemasukan');
        $builder = $builder->orWhere('tipe_log', 'hapus-pemasukan');
        $builder = $builder->orWhere('tipe_log', 'bayar-pemasukan');
        $builder = $builder->orWhere('tipe_log', 'upgrade-pelanggan');
        if ($start != 0 || $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        return $builder->orderBy('tgl', 'desc')->get()->getResult();
    }
}
