<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanModel extends Model
{
    protected $table      = 'tagihan';
    protected $primaryKey = 'id_tagihan';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_tagihan', 'id_mitra', 'id_pelanggan', 'kode_pelanggan', 'nama_pelanggan', 'tgl_tagihan', 'bulan',
        'tahun', 'nominal', 'ppn', 'diskon', 'total_tagihan', 'terbayar', 'id_invoice', 'no_invoice',
        'id_kuitansi', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function searchAndDisplay($katakunci = null, $bulan = 0, $tahun = 0, $id_mitra = 0, $start = 0, $length = 0)
    {
        $builder = $this->table('tagihan');
        $builder = $builder->where('bulan', $bulan)->where('tahun', $tahun);
        $builder = $builder->where('id_mitra', $id_mitra);
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
