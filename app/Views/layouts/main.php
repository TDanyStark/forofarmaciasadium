<!doctype html>
<html lang="es">

<head>
    <?= $this->include('layouts/partials/head') ?>
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
