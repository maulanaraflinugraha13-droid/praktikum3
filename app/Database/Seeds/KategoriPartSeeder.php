<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriPartSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Mesin'],
            ['nama_kategori' => 'Oli & Cairan'],
            ['nama_kategori' => 'Rem'],
            ['nama_kategori' => 'Ban & Velg'],
            ['nama_kategori' => 'Kelistrikan'],
            ['nama_kategori' => 'Aksesoris'],
        ];

        $this->db->table('kategori_part')->insertBatch($data);
    }
}
