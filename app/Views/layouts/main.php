<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Praktikum 3') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <nav class="nav">
        <strong>Web II</strong>
        <a href="<?= site_url('buku') ?>">Buku (contoh)</a>
        <a href="<?= site_url('suku-cadang') ?>">Suku Cadang (latihan)</a>
    </nav>

    <main class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif ?>

        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
