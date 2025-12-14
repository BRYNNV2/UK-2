<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table            = 'jurusan';
    protected $primaryKey       = 'id_jurusan';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_fakultas', 'nama_jurusan'];
    protected $useTimestamps    = false;

    public function getJurusanWithFakultas()
    {
        return $this->select('jurusan.*, fakultas.nama_fakultas')
                    ->join('fakultas', 'fakultas.id_fakultas = jurusan.id_fakultas')
                    ->findAll();
    }
}
