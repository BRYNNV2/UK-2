<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'nim';
    protected $useAutoIncrement = false; // NIM is not auto-increment
    protected $returnType       = 'array';
    protected $allowedFields    = ['nim', 'nama_mahasiswa', 'id_prodi', 'id_user'];
    protected $useTimestamps    = false;

    public function getMahasiswaWithProdi()
    {
        return $this->select('mahasiswa.*, prodi.nama_prodi, jurusan.nama_jurusan')
                    ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
                    ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan', 'left')
                    ->findAll();
    }
}
