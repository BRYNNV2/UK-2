<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_jurusan', 'nama_prodi', 'jenjang', 'id_kaprodi'];
    protected $useTimestamps    = false;

    public function getProdiWithJurusan()
    {
        return $this->select('prodi.*, jurusan.nama_jurusan, fakultas.nama_fakultas')
                    ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan')
                    ->join('fakultas', 'fakultas.id_fakultas = jurusan.id_fakultas')
                    ->findAll();
    }
}
