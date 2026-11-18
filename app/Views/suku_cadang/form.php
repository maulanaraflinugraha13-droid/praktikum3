<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>

<h1><?= esc($title) ?></h1>

<div class="card">
<?= form_open_multipart($aksi, ['class' => 'form']) ?>

    <label>Kode part</label>
    <input type="text" name="kode_part"
           value="<?= old('kode_part', esc($part['kode_part'] ?? '')) ?>">
    <?php if (isset($errors['kode_part'])): ?>
        <small class="error"><?= esc($errors['kode_part']) ?></small>
    <?php endif ?>

    <label>Nama part</label>
    <input type="text" name="nama_part"
           value="<?= old('nama_part', esc($part['nama_part'] ?? '')) ?>">
    <?php if (isset($errors['nama_part'])): ?>
        <small class="error"><?= esc($errors['nama_part']) ?></small>
    <?php endif ?>

    <label>Kategori</label>
    <select name="kategori_id">
        <option value="">-- Pilih kategori --</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id'] ?>"
                <?= old('kategori_id', $part['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                <?= esc($k['nama_kategori']) ?>
            </option>
        <?php endforeach ?>
    </select>
    <?php if (isset($errors['kategori_id'])): ?>
        <small class="error"><?= esc($errors['kategori_id']) ?></small>
    <?php endif ?>

        <label>Harga (Rp)</label>
    <?php
        $nilaiHarga = old('harga', $part['harga'] ?? '');
        if ($nilaiHarga !== '' && is_numeric(str_replace('.', '', (string) $nilaiHarga))) {
            $nilaiHarga = number_format((int) str_replace('.', '', (string) $nilaiHarga), 0, ',', '.');
        }
    ?>
    <input type="text" name="harga" id="input-harga" inputmode="numeric"
           value="<?= esc($nilaiHarga) ?>">
    <?php if (isset($errors['harga'])): ?>
        <small class="error"><?= esc($errors['harga']) ?></small>
    <?php endif ?>


    <label>Stok</label>
    <input type="number" name="stok"
           value="<?= old('stok', esc($part['stok'] ?? '')) ?>">
    <?php if (isset($errors['stok'])): ?>
        <small class="error"><?= esc($errors['stok']) ?></small>
    <?php endif ?>

    <label>Foto (JPG/PNG, maks 1 MB, opsional)</label>
    <?php if (! empty($part['foto'])): ?>
        <div>
            <img class="thumb" alt=""
                 src="<?= base_url('uploads/suku_cadang/' . $part['foto']) ?>">
            <span class="muted">Foto saat ini. Pilih file baru jika ingin mengganti.</span>
        </div>
    <?php endif ?>

    <input type="file" name="foto">
    <?php if (isset($errors['foto'])): ?>
        <small class="error"><?= esc($errors['foto']) ?></small>
    <?php endif ?>

    <button type="submit">Simpan</button>
    <a class="btn btn-light" href="<?= site_url('suku-cadang') ?>">Batal</a>

<?= form_close() ?>
</div>
<script>
const inputHarga = document.getElementById('input-harga');
if (inputHarga) {
    inputHarga.addEventListener('input', function () {
        let angka = this.value.replace(/\D/g, '');
        this.value = angka ? parseInt(angka, 10).toLocaleString('id-ID') : '';
    });
}
</script>


<?= $this->endSection() ?>
