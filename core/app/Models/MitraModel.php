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
        'id_mitra', 'kode_mitra', 'kode_mitra_pelanggan', 'nama_mitra', 'username',
        'penanggung_jawab', 'alamat', 'telepon', 'email', 'logo', 'status'
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
        $builder->select('mitra.*,  COUNT(CASE WHEN pelanggan.status = 1 THEN pelanggan.id_pelanggan END) AS jumlah_pelanggan'); // Menambahkan perhitungan jumlah pelanggan
        $builder->join('pelanggan', 'pelanggan.id_mitra = mitra.id_mitra', 'left'); // Bergabung dengan tabel pelanggan
        $builder->groupBy('mitra.id_mitra'); // Mengelompokkan hasil berdasarkan ID mitra
        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            foreach ($arr_katakunci as $kunci) {
                $builder->groupStart()->like('nama_mitra', $kunci)
                    ->orLike('kode_mitra', $kunci)
                    ->orLike('penanggung_jawab', $kunci)
                    ->groupEnd();
            }
        }
        $builder->orderBy('mitra.id_mitra', 'asc');
        $builder->limit($length, $start);
        return $builder->get()->getResult();
    }

    function searchAndDisplayTagihan($katakunci = null, $start = 0, $length = 10)
    {
        $builder = $this->db->table('mitra');
        $builder->select('mitra.*, COUNT(CASE WHEN pelanggan.status = 1 THEN pelanggan.id_pelanggan END) AS jumlah_pelanggan'); // Menambahkan perhitungan jumlah pelanggan
        $builder->select('COUNT(CASE WHEN tagihan.status = 3 THEN tagihan.id_tagihan END) AS terbayar'); // Menambahkan perhitungan jumlah tagihan dengan status 3
        $builder->select('SUM(CASE WHEN tagihan.status = 3 THEN tagihan.total_tagihan ELSE 0 END) AS total_tagihan'); // Menambahkan perhitungan jumlah total tagihan yang terbayar
        $builder->select('COUNT(CASE WHEN tagihan.status = 1 THEN tagihan.id_tagihan END) AS terbit'); // Menambahkan perhitungan jumlah tagihan dengan status 1
        $builder->join('pelanggan', 'pelanggan.id_mitra = mitra.id_mitra', 'left'); // Bergabung dengan tabel pelanggan
        $builder->join('tagihan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Bergabung dengan tabel tagihan
        $builder->groupBy('mitra.id_mitra'); // Mengelompokkan hasil berdasarkan ID mitra

        // Menambahkan WHERE clause untuk filter berdasarkan bulan dan tahun saat ini
        $currentMonth = date('m');
        $currentYear = date('Y');
        $builder->where('tagihan.bulan', $currentMonth);
        $builder->where('tagihan.tahun', $currentYear);

        if ($katakunci) {
            $arr_katakunci = explode(" ", $katakunci);
            foreach ($arr_katakunci as $kunci) {
                $builder->groupStart()->like('nama_mitra', $kunci)
                    ->orLike('kode_mitra', $kunci)
                    ->orLike('penanggung_jawab', $kunci)
                    ->groupEnd();
            }
        }
        $builder->orderBy('mitra.id_mitra', 'asc');
        $builder->limit($length, $start);
        return $builder->get()->getResult();
    }
}
