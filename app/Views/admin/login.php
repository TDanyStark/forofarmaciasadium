<?= $this->extend('layouts/main') ?>

<?php $title = 'Ingreso admin - Foro Farmacias ADIUM'; ?>

<?= $this->section('content') ?>
  <div class="card shadow-sm mt-5">
    <div class="card-body p-4">
      <h4 class="mb-3 text-center">Ingreso admin</h4>
      <p class="text-muted">Ingresa las credenciales de admin para continuar.</p>

      <?php if (! empty($errors) && is_array($errors)) : ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $err) : ?>
              <li><?= esc($err) ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>

      <?php
      $redirectValue = old('redirect');
      if ($redirectValue === null) {
        $redirectValue = $redirect ?? '';
      }

      $redirectValue = rawurldecode($redirectValue);

      if ($redirectValue !== ''
        && (! str_starts_with($redirectValue, '/')
          || str_starts_with($redirectValue, '//')
          || strpos($redirectValue, '://') !== false)) {
        $redirectValue = '';
      }
      ?>

      <form method="post" action="<?= site_url('admin/login') ?>">
        <?= csrf_field() ?>

        <input type="hidden" name="redirect" value="<?= esc($redirectValue) ?>">

        <div class="mb-3">
          <label class="form-label">Usuario</label>
          <input class="form-control" type="text" name="username" value="<?= esc(old('username')) ?>" required autocomplete="username">
        </div>

        <div class="mb-3">
          <label class="form-label">Contrasena</label>
          <input class="form-control" type="password" name="password" required autocomplete="current-password">
        </div>

        <div class="d-flex justify-content-end">
          <button class="btn btn-adium" type="submit">Entrar</button>
        </div>
      </form>
    </div>
  </div>
<?= $this->endSection() ?>
