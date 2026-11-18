<?php

namespace App\Controllers;

use App\Models\BukuModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Buku extends BaseController
{
    protected $helpers = ['form'];

    private function aturan(): array
    {
        $pesan = [
            'required'              => '{field} wajib diisi.',
            'min_length'            => '{field} minimal {param} karakter.',
            'max_length'            => '{field} maksimal {param} karakter.',
            'is_natural'            => '{field} harus berupa angka bulat 0 atau lebih.',
            'greater_than_equal_to' => '{field} minimal {param}.',
            'less_than_equal_to'    => '{field} maksimal {param}.',
        ];

        return [
            'judul' => [
                'label' => 'Judul', 'errors' => $pesan,
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'penulis' => [
                'label' => 'Penulis', 'errors' => $pesan,
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'tahun_terbit' => [
                'label' => 'Tahun terbit', 'errors' => $pesan,
                'rules' => 'required|is_natural|greater_than_equal_to[1900]'
                         . '|less_than_equal_to[2100]',
            ],
            'stok' => [
                'label' => 'Stok', 'errors' => $pesan,
                'rules' => 'required|is_natural',
            ],
        ];
    }

    public function index()
    {
        return view('buku/index', [
            'title' => 'Koleksi Buku',
            'buku'  => (new BukuModel())->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function tambah()
    {
        return view('buku/form', [
            'title' => 'Tambah Buku',
            'aksi'  => site_url('buku/simpan'),
        ]);
    }
        public function simpan()
    {
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['judul', 'penulis', 'tahun_terbit', 'stok']);
        (new BukuModel())->insert($data);

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $buku = (new BukuModel())->find($id);
        if (! $buku) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('buku/form', [
            'title' => 'Edit Buku',
            'aksi'  => site_url('buku/update/' . $id),
            'buku'  => $buku,
        ]);
    }
    public function update($id)
    {
        if (! $this->validate($this->aturan())) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost(['judul', 'penulis', 'tahun_terbit', 'stok']);
        (new BukuModel())->update($id, $data);

        return redirect()->to('/buku')->with('success', 'Buku berhasil diperbarui.');
    }
    public function hapus($id)
    {
        (new BukuModel())->delete($id);
        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus.');
    }
}