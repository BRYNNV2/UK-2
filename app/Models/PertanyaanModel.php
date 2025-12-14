<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanModel extends Model
{
    protected $table            = 'pertanyaan';
    protected $primaryKey       = 'id_pertanyaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['pertanyaan', 'id_prodi'];
    protected $useTimestamps    = false;

    public function getPertanyaanWithProdi()
    {
        return $this->select('pertanyaan.*, prodi.nama_prodi')
                    ->join('prodi', 'prodi.id_prodi = pertanyaan.id_prodi')
                    ->findAll();
    }
}
