<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanModel extends Model
{
    protected $table            = '2301020043_jawaban';
    protected $primaryKey       = 'id_jawaban';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nim', 'id_pertanyaan', 'id_pilihan_jawaban_pertanyaan', 'id_periode'];
    protected $useTimestamps    = false;
}
