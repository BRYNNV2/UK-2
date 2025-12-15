<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = '2301020111_mahasiswa';
    protected $primaryKey       = 'nim';
    protected $useAutoIncrement = false; // NIM is not auto-increment
    protected $returnType       = 'array';
    protected $allowedFields    = ['nim', 'nama_mahasiswa', 'id_prodi', 'id_user'];
    protected $useTimestamps    = false;

    public function getMahasiswaWithProdi()
    {
        return $this->select('2301020111_mahasiswa.*, 2301020011_prodi.nama_prodi, 2301020008_jurusan.nama_jurusan')
                    ->join('2301020011_prodi', '2301020011_prodi.id_prodi = 2301020111_mahasiswa.id_prodi', 'left')
                    ->join('2301020008_jurusan', '2301020008_jurusan.id_jurusan = 2301020011_prodi.id_jurusan', 'left')
                    ->findAll();
    }
}
