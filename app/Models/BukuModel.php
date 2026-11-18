<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            ='buku';
    protected $primaryType      ='id';
    protected $returnType       ='array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    =['judul', 'penulis', 'tahun_terbit', 'stok'];
    protected $useTimestamps    = true;
}