<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihankuitansiModel extends Model
{
    protected $table      = 'tagihan_kuitansi';
    protected $primaryKey = 'id_tagihan_kuitansi';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_tagihan_kuitansi', 'id_kuitansi', 'id_tagihan', 'id_pemasukan', 'item_layanan', 'kurang_bayar', 'total_bayar'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
