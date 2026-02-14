<?= $this->extend('layouts/main') ?>

<?php $title = 'Iniciar sesión - Foro Farmacias ADIUM'; ?>

<?= $this->section('content') ?>

  <div class="box">
    <div class="card shadow-sm mt-5">
      <div class="card-body p-4">
        <h4 class="mb-3 text-center">Iniciar sesión</h4>
        <p class="text-muted">Ingresa tu correo electrónico. Si no estás registrado serás redirigido al formulario de registro.</p>

        <?= view('components/form_errors', ['errors' => $errors ?? null]) ?>

        <form method="post" action="<?= site_url('login/checkEmail') ?>">
          <?= csrf_field() ?>

          <?= view('components/redirect_hidden', ['redirect' => $redirect ?? null]) ?>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input autocomplete="email" class="form-control" type="email" name="email" value="<?= esc(old('email') ?? ($email ?? '')) ?>" required>
          </div>

          <?php $registerUrl = build_redirect_url(site_url('registro'), $redirect ?? null); ?>

          <div class="d-flex justify-content-between align-items-center">
            <a href="<?= $registerUrl ?>" class="btn btn-link">Registrarse</a>
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