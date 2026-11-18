<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'        => 'Cantik Itu Luka',
                'penulis'      => 'Eka Kurniawan',
                'penerbit'     => 'Gramedia Pustaka Utama',
                'tahun_terbit' => '2002',
                'stok'         => 1,
            ],
            [
                'judul'        => 'Filosofi Teras',
                'penulis'      => 'Henry Manampiring',
                'penerbit'     => 'Kompas',
                'tahun_terbit' => '2018',
                'stok'         => 2,
            ],
            [
                'judul'        => 'Negeri 5 Menara',
                'penulis'      => 'Ahmad Fuadi',
                'penerbit'     => 'Gramedia Pustaka Utama',
                'tahun_terbit' => '2009',
                'stok'         => 5,
            ],
            [
                'judul'        => 'Bumi Manusia',
                'penulis'      => 'Pramoedya Ananta Toer',
                'penerbit'     => 'Hasta Mitra',
                'tahun_terbit' => '1980',
                'stok'         => 3,
            ],
            [
                'judul'        => 'Laskar Pelangi',
                'penulis'      => 'Andrea Hirata',
                'penerbit'     => 'Bentang Pustaka',
                'tahun_terbit' => '2005',
                'stok'         => 4,
            ],
        ];

        $this->db->table('buku')->insertBatch($data);
    }
}
