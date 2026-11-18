<?php

namespace App\Controllers;

use App\Models\KategoriPartModel;
use App\Models\SukuCadangModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class SukuCadang extends BaseController
{
    protected $helpers = ['form'];

    private const FOLDER_FOTO = 'uploads/suku_cadang';

    /**
     * Aturan validasi. Saat edit agar kode_part milik sendiri
     * tidak dianggap duplikat.
     */
        private function aturan(?int $id = null): array
    {
        $aturan = [
            'kode_part' => [
                'label'  => 'Kode part',
                'rules'  => "required|min_length[3]|max_length[20]|is_unique[suku_cadang.kode_part,id,{$id}]",
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal {param} karakter.',
                    'max_length' => '{field} maksimal {param} karakter.',
                    'is_unique'  => '{field} sudah dipakai, gunakan kode lain.',
                ],
            ],
            'nama_part' => [
                'label'  => 'Nama part',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal {param} karakter.',
                    'max_length' => '{field} maksimal {param} karakter.',
                ],
            ],
            'kategori_id' => [
                'label'  => 'Kategori',
                'rules'  => 'required|is_not_unique[kategori_part.id]',
                'errors' => [
                    'required'      => '{field} wajib dipilih.',
                    'is_not_unique' => '{field} tidak valid.',
                ],
            ],
            'harga' => [
                'label'  => 'Harga',
                'rules'  => 'required|is_natural_no_zero|greater_than_equal_to[1000]',
                'errors' => [
                    'required'              => '{field} wajib diisi.',
                    'is_natural_no_zero'    => '{field} harus berupa angka bulat lebih dari 0.',
                    'greater_than_equal_to' => '{field} minimal Rp 1.000.',
                ],
            ],
            'stok' => [
                'label'  => 'Stok',
                'rules'  => 'required|is_natural',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'is_natural' => '{field} harus berupa angka bulat 0 atau lebih.',
                ],
            ],
        ];

        // Foto bersifat opsional: divalidasi hanya jika pengguna memilih file.
        $file = $this->request->getFile('foto');
        if ($file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            $aturan['foto'] = [
                'label'  => 'Foto',
                'rules'  => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,1024]',
                'errors' => [
                    'is_image' => '{field} harus berupa gambar.',
                    'mime_in'  => '{field} harus berformat JPG atau PNG.',
                    'max_size' => '{field} maksimal 1 MB.',
                ],
            ];
        }

        return $aturan;
    }


    /**
     * Memindahkan foto ke public/uploads. Hasil: nama file, atau null.
     */
    private function simpanFoto(): ?string
    {
        $file = $this->request->getFile('foto');
        if ($file === null || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $nama = $file->getRandomName();
        $file->move(FCPATH . self::FOLDER_FOTO, $nama);

        return $nama;
    }

    private function hapusFile(?string $nama): void
    {
        if ($nama && is_file(FCPATH . self::FOLDER_FOTO . '/' . $nama)) {
            unlink(FCPATH . self::FOLDER_FOTO . '/' . $nama);
        }
    }

    public function index()
    {
        $model      = new SukuCadangModel();
        $keyword    = $this->request->getGet('q');
        $kategoriId = (int) $this->request->getGet('kategori');

        return view('suku_cadang/index', [
            'title'      => 'Stok Suku Cadang',
            'part'       => $model->daftar($keyword, $kategoriId ?: null, 5),
            'pager'      => $model->pager,
            'keyword'    => $keyword,
            'kategoriId' => $kategoriId,
            'kategori'   => (new KategoriPartModel())->findAll(),
        ]);
    }

    public function tambah()
    {
        return view('suku_cadang/form', [
            'title'    => 'Tambah Suku Cadang',
            'aksi'     => site_url('suku-cadang/simpan'),
            'kategori' => (new KategoriPartModel())->findAll(),
        ]);
    }

            public function simpan()
    {
        // Ambil semua data POST dan bersihkan titik pada harga
        $postData          = $this->request->getPost();
        $postData['harga'] = str_replace('.', '', (string) ($postData['harga'] ?? ''));

        if (! $this->validateData($postData, $this->aturan())) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_part'   => $postData['kode_part'],
            'nama_part'   => $postData['nama_part'],
            'kategori_id' => $postData['kategori_id'],
            'harga'       => $postData['harga'],
            'stok'        => $postData['stok'],
            'foto'        => $this->simpanFoto(),
        ];

        (new SukuCadangModel())->insert($data);

        return redirect()->to('/suku-cadang')
            ->with('success', 'Suku cadang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $part = (new SukuCadangModel())->find($id);
        if (! $part) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('suku_cadang/form', [
            'title'    => 'Edit Suku Cadang',
            'aksi'     => site_url('suku-cadang/update/' . $id),
            'part'     => $part,
            'kategori' => (new KategoriPartModel())->findAll(),
        ]);
    }

            public function update($id)
    {
        $model = new SukuCadangModel();
        $part  = $model->find($id);
        if (! $part) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Ambil semua data POST dan bersihkan titik pada harga
        $postData          = $this->request->getPost();
        $postData['harga'] = str_replace('.', '', (string) ($postData['harga'] ?? ''));

        if (! $this->validateData($postData, $this->aturan((int) $id))) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_part'   => $postData['kode_part'],
            'nama_part'   => $postData['nama_part'],
            'kategori_id' => $postData['kategori_id'],
            'harga'       => $postData['harga'],
            'stok'        => $postData['stok'],
        ];

        $fotoBaru = $this->simpanFoto();
        if ($fotoBaru !== null) {
            $this->hapusFile($part['foto']);
            $data['foto'] = $fotoBaru;
        }

        $model->update($id, $data);

        return redirect()->to('/suku-cadang')
            ->with('success', 'Suku cadang berhasil diperbarui.');
    }



    public function hapus($id)
    {
        $model = new SukuCadangModel();
        $part  = $model->find($id);
        if ($part) {
            $this->hapusFile($part['foto']);
            $model->delete($id);
        }

        return redirect()->to('/suku-cadang')
            ->with('success', 'Suku cadang berhasil dihapus.');
    }
}
