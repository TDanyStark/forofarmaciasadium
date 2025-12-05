<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Inscritos</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}.container{max-width:800px;margin:0 auto}</style>
</head>
<body>
<div class="container">
    <h1>Registro de Inscritos</h1>

    <?php if (! empty($errors) && is_array($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err) : ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form method="post" action="<?= site_url('inscritos/store') ?>">
        <?= csrf_field() ?>

        <div>
            <label>Nombres *</label>
            <input type="text" name="nombres" value="<?= old('nombres') ?>" required maxlength="255">
        </div>

        <div>
            <label>Apellidos *</label>
            <input type="text" name="apellidos" value="<?= old('apellidos') ?>" required maxlength="255">
        </div>

        <div>
            <label>Cédula</label>
            <input type="text" name="cedula" value="<?= old('cedula') ?>" maxlength="50">
        </div>

        <div>
            <label>Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="<?= old('fecha_nacimiento') ?>">
        </div>

        <div>
            <label>Género</label>
            <input type="text" name="genero" value="<?= old('genero') ?>" maxlength="20">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= old('email') ?>" maxlength="255">
        </div>

        <div>
            <label>Celular</label>
            <input type="text" name="celular" value="<?= old('celular') ?>" maxlength="50">
        </div>

        <div>
            <label>Nombre Farmacia</label>
            <input type="text" name="nombre_farmacia" value="<?= old('nombre_farmacia') ?>" maxlength="255">
        </div>

        <div>
            <label>Ciudad</label>
            <input type="text" name="ciudad" value="<?= old('ciudad') ?>" maxlength="100">
        </div>

        <div>
            <label>Dirección Farmacia</label>
            <textarea name="direccion_farmacia"><?= old('direccion_farmacia') ?></textarea>
        </div>

        <div>
            <label>Nombre Cadena / Distribuidor</label>
            <input type="text" name="nombre_cadena_distribuidor" value="<?= old('nombre_cadena_distribuidor') ?>" maxlength="255">
        </div>

        <div>
            <label>
                <input type="checkbox" name="acepta_politica_datos" value="1" <?= old('acepta_politica_datos') ? 'checked' : '' ?>> Acepto la política de datos *
            </label>
        </div>

        <div>
            <button type="submit">Registrar</button>
        </div>
    </form>
</div>
</body>
</html>
