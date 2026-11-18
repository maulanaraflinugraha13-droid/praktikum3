<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1>Koleksi Buku Perpustakaan Desa</h1>

<div class="toolbar">
    <a class="btn" href="<?= site_url('buku/tambah') ?>">+ Tambah Buku</a>
</div>

<table>
    <tr>
        <th>No</th><th>Judul</th><th>Penulis</th>
        <th>Tahun</th><th>Stok</th><th>Aksi</th>
    </tr>

    <?php if (empty($buku)): ?>
        <tr><td colspan="6">Belum ada data.</td></tr>
    <?php endif ?>

    <?php foreach ($buku as $i => $b): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= esc($b['judul']) ?></td>
            <td><?= esc($b['penulis']) ?></td>
            <td><?= esc($b['tahun_terbit']) ?></td>
            <td><?= esc($b['stok']) ?></td>
            <td>
                <a class="btn btn-light"
                   href="<?= site_url('buku/edit/' . $b['id']) ?>">Edit</a>
                <?= form_open('buku/hapus/' . $b['id'], [
                    'style'    => 'display:inline',
                    'onsubmit' => "return confirm('Hapus buku ini?')",
                ]) ?>
                    <button type="submit" class="btn-danger">Hapus</button>
                <?= form_close() ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?= $this->endSection() ?>