<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>

<h1><?= esc($title) ?></h1>

<div class="card">
<?= form_open($aksi, ['class' => 'form']) ?>

    <label>Judul</label>
    <input type="text" name="judul"
           value="<?= old('judul', esc($buku['judul'] ?? '')) ?>">
    <?php if (isset($errors['judul'])): ?>
        <small class="error"><?= esc($errors['judul']) ?></small>
    <?php endif ?>

    <label>Penulis</label>
    <input type="text" name="penulis"
           value="<?= old('penulis', esc($buku['penulis'] ?? '')) ?>">
    <?php if (isset($errors['penulis'])): ?>
        <small class="error"><?= esc($errors['penulis']) ?></small>
    <?php endif ?>

    <label>Tahun terbit</label>
    <input type="text" name="tahun_terbit"
           value="<?= old('tahun_terbit', esc($buku['tahun_terbit'] ?? '')) ?>">
    <?php if (isset($errors['tahun_terbit'])): ?>
        <small class="error"><?= esc($errors['tahun_terbit']) ?></small>
    <?php endif ?>

    <label>Stok</label>
    <input type="text" name="stok"
           value="<?= old('stok', esc($buku['stok'] ?? '')) ?>">
    <?php if (isset($errors['stok'])): ?>
        <small class="error"><?= esc($errors['stok']) ?></small>
    <?php endif ?>

    <p>
        <button type="submit">Simpan</button>
        <a class="btn btn-light" href="<?= site_url('buku') ?>">Batal</a>
    </p>

<?= form_close() ?>
</div>

<?= $this->endSection() ?>
