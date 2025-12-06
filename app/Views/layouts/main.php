<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'Foro Farmacias ADIUM' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/adium.css') ?>">
</head>

<body>
    <div class="container">
        <?= $this->include('components/logo') ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success mt-3">
                <?= esc(session()->getFlashdata('message')) ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif ?>
        <?= $this->renderSection('content') ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
