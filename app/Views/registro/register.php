<?= $this->extend('layouts/main') ?>

<?php $title = 'Registro - Foro Farmacias ADIUM'; ?>

<?= $this->section('content') ?>

    <div class="card card-register shadow-sm">
        <div class="card-body p-4">
            <h2 class="card-title mb-3 text-center">Formulario de registro</h2>
            <p class="small-note">Complete sus datos para registrarse en el foro. Los campos marcados con <span class="required">*</span> son obligatorios.</p>

            <?= view('components/form_errors', ['errors' => $errors ?? null]) ?>

            <form method="post" action="<?= site_url('registro/store') ?>">
                <?= csrf_field() ?>

                <?= view('components/redirect_hidden', ['redirect' => $redirect ?? null]) ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombres <span class="required">*</span></label>
                        <input class="form-control" type="text" name="nombres" value="<?= esc(old('nombres')) ?>" required maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellidos <span class="required">*</span></label>
                        <input class="form-control" type="text" name="apellidos" value="<?= esc(old('apellidos')) ?>" required maxlength="255">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Cédula <span class="required">*</span></label>
                        <input class="form-control" type="text" name="cedula" value="<?= esc(old('cedula')) ?>" required maxlength="50">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fecha de nacimiento <span class="required">*</span></label>
                        <input class="form-control" type="date" name="fecha_nacimiento" value="<?= esc(old('fecha_nacimiento')) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Género <span class="required">*</span></label>
                        <select class="form-select" name="genero" required>
                            <option value="">Seleccione...</option>
                            <option value="F" <?= old('genero') === 'F' ? 'selected' : '' ?>>Femenino</option>
                            <option value="M" <?= old('genero') === 'M' ? 'selected' : '' ?>>Masculino</option>
                            <option value="O" <?= old('genero') === 'O' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input class="form-control" type="email" name="email" value="<?= esc(old('email') ?? ($email ?? '')) ?>" required maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Celular <span class="required">*</span></label>
                        <input class="form-control" type="text" name="celular" value="<?= esc(old('celular')) ?>" required maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nombre Farmacia <span class="required">*</span></label>
                        <input class="form-control" type="text" name="nombre_farmacia" value="<?= esc(old('nombre_farmacia')) ?>" required maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ciudad <span class="required">*</span></label>
                        <input class="form-control" type="text" name="ciudad" value="<?= esc(old('ciudad')) ?>" required maxlength="100">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Dirección Farmacia <span class="required">*</span></label>
                        <input class="form-control" name="direccion_farmacia" rows="2" required><?= esc(old('direccion_farmacia')) ?></input>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Nombre Cadena / Distribuidor <span class="required">*</span></label>
                        <input class="form-control" type="text" name="nombre_cadena_distribuidor" value="<?= esc(old('nombre_cadena_distribuidor')) ?>" required maxlength="255">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="acepta_politica_datos" name="acepta_politica_datos" value="1" <?= old('acepta_politica_datos') ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="acepta_politica_datos">Acepto la política de tratamiento de datos <span class="required">*</span></label>
                        </div>
                        <div class="small-note mt-1">Queremos informarte acerca de nuestra Política de Datos, que detalla cómo manejamos y protegemos la información que recopilamos de ti. Conoce más de nuestra <a class="text-adium" href="https://www.adium.com.co/wp-content/uploads/sites/8/2024/02/AdiumCo_Politica-Proteccion-Datos-Personales-Para-Titulares.pdf" target="_blank">AdiumCo_Politica-Proteccion-Datos-Personales</a>.</div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <?php $loginUrl = site_url('login');
                    $redirectValue = old('redirect');
                    if ($redirectValue === null) {
                        $redirectValue = $redirect ?? '';
                    }

                    $redirectValue = sanitize_redirect($redirectValue) ?? '';
                    if ($redirectValue !== '' && $redirectValue !== '/') {
                        $loginUrl .= '?redirect=' . urlencode($redirectValue);
                    } ?>
                    <div class="small-note">¿Ya estás registrado? <a class="text-adium" href="<?= $loginUrl ?>">Inicia sesión</a></div>
                    <button class="btn btn-adium" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>

<?= $this->endSection() ?>