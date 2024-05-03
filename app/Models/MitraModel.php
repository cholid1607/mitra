<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Validation\StrictRules\Rules;

class MitraModel extends Model
{
    protected $table      = 'mitra';
    protected $primaryKey = 'id_mitra';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_mitra', 'kode_mitra', 'nama_mitra', 'penanggung_jawab', 'alamat', 'telepon', 'logo', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'kode_mitra' => [
            'rules' => 'required|is_unique[mitra.kode_mitra]',
            'errors' => [
                'required' => 'Kode Mitra Harus Diisi',
                'is_unique' => 'Kode Mitra Sudah Digunakan',
            ],
        ],
    ];
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

    function searchAndDisplay($katakunci = null, $start = 0, $length = 10)
    {
        $builder = $this->db->table('mitra');
        $builder->select('*');
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            foreach ($arr_katakunci as $kunci) {
                $builder->groupStart()->like('nama_mitra', $kunci)
                    ->orLike('kode_mitra', $kunci)
                    ->orLike('penanggung_jawab', $kunci)
                    ->groupEnd();
            }
        }
        $builder->orderBy('id_mitra', 'asc');
        $builder->limit($length, $start);

        return $builder->get()->getResult();
    }
}
