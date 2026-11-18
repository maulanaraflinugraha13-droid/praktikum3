<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriPartModel extends Model
{
    protected $table         = 'kategori_part';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nama_kategori'];
}
