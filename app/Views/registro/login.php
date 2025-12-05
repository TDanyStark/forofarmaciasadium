<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión - Foro Farmacias ADIUM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/adium.css') ?>">
</head>

<body>
<?= $this->extend('layouts/main') ?>

<?php $title = 'Iniciar sesión - Foro Farmacias ADIUM'; ?>

<?= $this->section('content') ?>

  <div class="box">
    <div class="card shadow-sm mt-5">
      <div class="card-body p-4">
        <h4 class="mb-3 text-center">Iniciar sesión</h4>
        <p class="text-muted">Ingresa tu correo electrónico. Si no estás registrado serás redirigido al formulario de registro.</p>

        <?php if (! empty($errors) && is_array($errors)) : ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $err) : ?>
                <li><?= esc($err) ?></li>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif ?>

        <form method="post" action="<?= site_url('login/checkEmail') ?>">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="<?= esc(old('email') ?? ($email ?? '')) ?>" required>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <a href="<?= site_url('registro') ?>" class="btn btn-link">Registrarse</a>
            <button class="btn btn-adium" type="submit">Continuar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>