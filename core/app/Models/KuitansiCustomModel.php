<?php

namespace App\Models;

use CodeIgniter\Model;

class KuitansiCustomModel extends Model
{
    protected $table      = 'kuitansi_custom';
    protected $primaryKey = 'id_kuitansi_custom';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_kuitansi_custom', 'no_urut', 'no_kuitansi', 'akun_bank', 'id_pelanggan',
        'nama_pelanggan', 'kode_pelanggan', 'tgl_kuitansi', 'item_layanan', 'bulan',
        'tahun', 'nominal', 'ppn', 'nominal_kuitansi'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
