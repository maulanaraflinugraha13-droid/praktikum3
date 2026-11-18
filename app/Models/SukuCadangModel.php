<?php

namespace App\Models;

use CodeIgniter\Model;

class SukuCadangModel extends Model
{
    protected $table          = 'suku_cadang';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'kategori_id', 'kode_part', 'nama_part', 'harga', 'stok', 'foto',
    ];
    protected $useTimestamps  = true;

    /**
     * Daftar suku cadang + nama kategori, dengan pencarian,
     * filter kategori, dan pagination.
     */
    public function daftar(
        ?string $keyword = null,
        ?int $kategoriId = null,
        int $perHalaman = 5
    ): array {
        $query = $this->select('suku_cadang.*, kategori_part.nama_kategori')
            ->join(
                'kategori_part',
                'kategori_part.id = suku_cadang.kategori_id'
            )
            ->orderBy('suku_cadang.id', 'DESC');

        if ($keyword) {
            $query = $query->groupStart()
                ->like('suku_cadang.nama_part', $keyword)
                ->orLike('suku_cadang.kode_part', $keyword)
                ->groupEnd();
        }

        if ($kategoriId) {
            $query = $query->where('suku_cadang.kategori_id', $kategoriId);
        }

        return $query->paginate($perHalaman);
    }
}
