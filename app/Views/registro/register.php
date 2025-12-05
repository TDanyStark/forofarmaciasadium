<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Foro Farmacias ADIUM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fa
        }

        .card-register {
            max-width: 900px;
            margin: 30px auto
        }

        .required {
            color: #d00
        }

        .small-note {
            font-size: .9rem;
            color: #6c757d
        }

        .text-adium{
            color: #fa0032;
            font-weight: bold;
        }

        .btn-adium{
            background-color: #fa0032;
            color: #fff;
            font-weight: bold;
        }

        .btn-adium:hover{
            background-color: #dd002cff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-register shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title mb-3">Formulario de registro</h2>
                <p class="small-note">Complete sus datos para registrarse en el foro. Los campos marcados con <span class="required">*</span> son obligatorios.</p>

                <?php if (! empty($errors) && is_array($errors)) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err) : ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form method="post" action="<?= site_url('registro/store') ?>">
                    <?= csrf_field() ?>

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
                            <label class="form-label">Cédula</label>
                            <input class="form-control" type="text" name="cedula" value="<?= esc(old('cedula')) ?>" maxlength="50">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha de nacimiento</label>
                            <input class="form-control" type="date" name="fecha_nacimiento" value="<?= esc(old('fecha_nacimiento')) ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Género</label>
                            <select class="form-select" name="genero">
                                <option value="">Seleccione...</option>
                                <option value="F" <?= old('genero') === 'F' ? 'selected' : '' ?>>Femenino</option>
                                <option value="M" <?= old('genero') === 'M' ? 'selected' : '' ?>>Masculino</option>
                                <option value="O" <?= old('genero') === 'O' ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" value="<?= esc(old('email')) ?>" maxlength="255">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Celular</label>
                            <input class="form-control" type="text" name="celular" value="<?= esc(old('celular')) ?>" maxlength="50">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre Farmacia</label>
                            <input class="form-control" type="text" name="nombre_farmacia" value="<?= esc(old('nombre_farmacia')) ?>" maxlength="255">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ciudad</label>
                            <input class="form-control" type="text" name="ciudad" value="<?= esc(old('ciudad')) ?>" maxlength="100">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Dirección Farmacia</label>
                            <textarea class="form-control" name="direccion_farmacia" rows="2"><?= esc(old('direccion_farmacia')) ?></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nombre Cadena / Distribuidor</label>
                            <input class="form-control" type="text" name="nombre_cadena_distribuidor" value="<?= esc(old('nombre_cadena_distribuidor')) ?>" maxlength="255">
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="acepta_politica_datos" name="acepta_politica_datos" value="1" <?= old('acepta_politica_datos') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="acepta_politica_datos">Acepto la política de tratamiento de datos <span class="required">*</span></label>
                            </div>
                            <div class="small-note mt-1">Queremos informarte acerca de nuestra Política de Datos, que detalla cómo manejamos y protegemos la información que recopilamos de ti. Conoce más de nuestra <a class="text-adium" href="https://www.adium.com.co/wp-content/uploads/sites/8/2024/02/AdiumCo_Politica-Proteccion-Datos-Personales-Para-Titulares.pdf" target="_blank">AdiumCo_Politica-Proteccion-Datos-Personales</a>.</div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="small-note">¿Ya estás registrado? <a class="text-adium" href="<?= site_url('login') ?>">Inicia sesión</a></div>
                        <button class="btn btn-adium" type="submit">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>