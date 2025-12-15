<?php

namespace App\Models;

use CodeIgniter\Model;

class PilihanJawabanModel extends Model
{
    protected $table            = '2301020093_pilihan_jawaban_pertanyaan';
    protected $primaryKey       = 'id_pilihan_jawaban';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['deskripsi_pilihan', 'id_pertanyaan'];
    protected $useTimestamps    = false;
}
