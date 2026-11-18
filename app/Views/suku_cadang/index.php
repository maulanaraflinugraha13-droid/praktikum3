<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1>Stok Suku Cadang Bengkel Maju Jaya</h1>

<form method="get" action="<?= site_url('suku-cadang') ?>" class="toolbar">
    <input type="text" name="q" value="<?= esc($keyword ?? '') ?>"
           placeholder="Cari nama atau kode part...">
    <select name="kategori">
        <option value="">Semua kategori</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id'] ?>"
                <?= (int) ($kategoriId ?? 0) === (int) $k['id'] ? 'selected' : '' ?>>
                <?= esc($k['nama_kategori']) ?>
            </option>
        <?php endforeach ?>
    </select>
    <button type="submit">Cari</button>
    <a class="btn btn-light" href="<?= site_url('suku-cadang') ?>">Reset</a>
    <a class="btn" style="margin-left:auto"
       href="<?= site_url('suku-cadang/tambah') ?>">+ Tambah</a>
</form>

<?php $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Kode</th>
            <th>Nama part</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($part)): ?>
            <tr><td colspan="8">Belum ada data.</td></tr>
        <?php endif ?>

        <?php foreach ($part as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <?php if ($p['foto']): ?>
                        <img class="thumb" alt=""
                             src="<?= base_url('uploads/suku_cadang/' . $p['foto']) ?>">
                    <?php else: ?>
                        <span class="muted">-</span>
                    <?php endif ?>
                </td>
                <td><?= esc($p['kode_part']) ?></td>
                <td><?= esc($p['nama_part']) ?></td>
                <td><?= esc($p['nama_kategori']) ?></td>
                <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                <td>
                    <?= esc($p['stok']) ?>
                    <?php if ($p['stok'] < 5): ?>
                        <span class="badge-warn">Menipis</span>
                    <?php endif ?>
                </td>
                <td>
                    <a class="btn btn-light"
                       href="<?= site_url('suku-cadang/edit/' . $p['id']) ?>">Edit</a>
                    <?= form_open('suku-cadang/hapus/' . $p['id'], [
                        'style'    => 'display:inline',
                        'onsubmit' => "return confirm('Hapus suku cadang ini?')",
                    ]) ?>
                        <button type="submit" class="btn-danger">Hapus</button>
                    <?= form_close() ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>
