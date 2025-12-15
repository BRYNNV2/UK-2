<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table            = '2301020008_jurusan';
    protected $primaryKey       = 'id_jurusan';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_fakultas', 'nama_jurusan'];
    protected $useTimestamps    = false;

    public function getJurusanWithFakultas()
    {
        return $this->select('2301020008_jurusan.*, 2301020005_fakultas.nama_fakultas')
                    ->join('2301020005_fakultas', '2301020005_fakultas.id_fakultas = 2301020008_jurusan.id_fakultas')
                    ->findAll();
    }
}
