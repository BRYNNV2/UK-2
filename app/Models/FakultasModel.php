<?php

namespace App\Models;

use CodeIgniter\Model;

class FakultasModel extends Model
{
    protected $table            = '2301020005_fakultas';
    protected $primaryKey       = 'id_fakultas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_fakultas'];
    protected $useTimestamps    = false;
}
