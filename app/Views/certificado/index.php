<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Certificado</title>
    <link rel="stylesheet" href="/css/adium.css">
</head>
<body>
    <main class="container">
        <h1>Certificado</h1>

        <p>Has visto <strong><?= esc($viewedCount) ?></strong> de <strong><?= esc($totalVideos) ?></strong> sesiones.</p>
        <p>Necesitas al menos <strong><?= esc($threshold) ?></strong> sesiones vistas para obtener el certificado.</p>

        <p>
            <?php if ($viewedCount >= $threshold): ?>
                El certificado ya debería generarse automáticamente. Si no empieza la descarga automáticamente, recarga esta página.
            <?php else: ?>
                Sigue viendo las sesiones para alcanzar el certificado.
            <?php endif; ?>
        </p>

        <p><a href="/">Volver a videos</a></p>
    </main>
</body>
</html>
