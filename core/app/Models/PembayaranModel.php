<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table      = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pembayaran', 'id_mitra', 'nama_bank', 'rekening', 'atas_nama'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function searchAndDisplay($katakunci = null, $start = 0, $length = 0)
    {
        $builder = $this->table('pembayaran');
        $builder = $builder->join('mitra', 'mitra.id_mitra = pembayaran.id_mitra');
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($arr_katakunci); $x++) {
                $builder = $builder->like('pembayaran.nama_bank', $arr_katakunci[$x]);
            }
        }
        if ($start != 0 || $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        return $builder->orderBy('pembayaran.id_pembayaran', 'desc')->get()->getResult();
    }
}
