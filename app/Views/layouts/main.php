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
        <div class="text-center my-3">
            <a href="<?= site_url() ?>">
                <img src="<?= base_url('images/adium_black.png') ?>" alt="ADIUM" style="max-height:60px;" />
            </a>
        </div>

        <?= $this->renderSection('content') ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
