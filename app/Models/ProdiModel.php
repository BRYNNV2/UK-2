<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = '2301020011_prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_jurusan', 'nama_prodi', 'jenjang', 'id_kaprodi'];
    protected $useTimestamps    = false;

    public function getProdiWithJurusan()
    {
        return $this->select('2301020011_prodi.*, 2301020008_jurusan.nama_jurusan, 2301020005_fakultas.nama_fakultas')
                    ->join('2301020008_jurusan', '2301020008_jurusan.id_jurusan = 2301020011_prodi.id_jurusan')
                    ->join('2301020005_fakultas', '2301020005_fakultas.id_fakultas = 2301020008_jurusan.id_fakultas')
                    ->findAll();
    }
}
