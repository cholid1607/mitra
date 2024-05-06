<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table      = 'invoice';
    protected $primaryKey = 'id_invoice';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'no_invoice', 'no_urut', 'id_pelanggan', 'tgl_invoice', 'tgl_jatuhtempo', 'tahun', 'bulan',
        'kode_pelanggan', 'nama_pelanggan', 'id_tagihan', 'id_pemasukan', 'item_layanan', 'keterangan',
        'nominal', 'ppn', 'piutang', 'total_tagihan', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
