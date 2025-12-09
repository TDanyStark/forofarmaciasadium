<?= $this->extend('layouts/dashboardLayout') ?>
<?= $this->section('content') ?>
<style>
    h1 {
        font-size: 1.4rem;
        line-height: 1.7rem;
        font-weight: 700;
        margin-top: 15px;
    }

    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 0 16px;
    }

    .video-player {
        position: relative;
        padding-top: 56.25%;
        border-radius: 10px;
        overflow: clip;
    }

    .video-player iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .info-autor{
        color: #666;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {
        h1 {
        font-size: 2rem;
        line-height: 2.3rem;
    }
    .info-autor{
        font-size: 1.2rem;
    }
        
    }
</style>

<div class="container">
    <p><a class="btn-adium" href="<?= site_url('/') ?>">← Volver a la lista</a></p>

    <?php if (!empty($error)): ?>
        <div class="error"><?= esc($error) ?></div>
    <?php elseif (empty($video)): ?>
        <div>No se encontró información del video.</div>
    <?php else: ?>
        <div class="video-player">
            <iframe src="https://www.youtube.com/embed/<?= esc($id) ?>" allowfullscreen allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
        </div>

        <h1><?= esc($video['title']) ?></h1>
        <p class="info-autor">Por: <?= esc($video['author'] ?? $video['channelTitle'] ?? 'Autor desconocido') ?></p>

        <p><?= nl2br(esc($video['description'] ?? '')) ?></p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>