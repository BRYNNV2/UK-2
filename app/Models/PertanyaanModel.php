<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanModel extends Model
{
    protected $table            = '2301020088_pertanyaan';
    protected $primaryKey       = 'id_pertanyaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['pertanyaan', 'id_prodi'];
    protected $useTimestamps    = false;

    public function getPertanyaanWithProdi()
    {
        return $this->select('2301020088_pertanyaan.*, 2301020011_prodi.nama_prodi')
                    ->join('2301020011_prodi', '2301020011_prodi.id_prodi = 2301020088_pertanyaan.id_prodi')
                    ->findAll();
    }
}
