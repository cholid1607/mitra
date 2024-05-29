<?php

namespace App\Models;

use CodeIgniter\Model;

class KuitansiModel extends Model
{
    protected $table      = 'kuitansi';
    protected $primaryKey = 'id_kuitansi';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_kuitansi', 'no_urut', 'no_kuitansi', 'id_pembayaran', 'nominal_kuitansi', 'piutang',
        'informasi_kuitansi', 'id_pelanggan', 'tgl_kuitansi', 'id_pemasukan', 'status', 'bulan', 'tahun', 'diskon'
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
        $builder = $this->table('kuitansi');
        $builder = $builder->join('pelanggan', 'pelanggan.id_pelanggan = kuitansi.id_pelanggan');
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($arr_katakunci); $x++) {
                $builder = $builder->like('kuitansi.no_kuitansi', $arr_katakunci[$x]);
                $builder = $builder->orLike('kuitansi.tgl_kuitansi', $arr_katakunci[$x]);
                $builder = $builder->orLike('pelanggan.nama_pelanggan', $arr_katakunci[$x]);
            }
        }
        if ($start != 0 || $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        return $builder->orderBy('kuitansi.id_kuitansi', 'desc')->get()->getResult();
    }
}
