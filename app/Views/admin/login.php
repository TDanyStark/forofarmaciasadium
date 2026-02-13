<?= $this->extend('layouts/main') ?>

<?php $title = 'Ingreso admin - Foro Farmacias ADIUM'; ?>

<?= $this->section('content') ?>
  <div class="card shadow-sm mt-5">
    <div class="card-body p-4">
      <h4 class="mb-3 text-center">Ingreso admin</h4>
      <p class="text-muted">Ingresa las credenciales de admin para continuar.</p>

      <?= view('components/form_errors', ['errors' => $errors ?? null]) ?>

      <form method="post" action="<?= site_url('admin/login') ?>">
        <?= csrf_field() ?>

        <?= view('components/redirect_hidden', ['redirect' => $redirect ?? null]) ?>

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
