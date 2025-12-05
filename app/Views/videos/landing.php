<?= $this->extend('layouts/videosLayout') ?>
<?= $this->section('content') ?>
<style>
    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 0 16px;
    }

    .video-player {
        position: relative;
        padding-top: 56.25%;
    }

    .video-player iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>

<div class="container">
    <p><a href="<?= site_url('/') ?>">← Volver a la lista</a></p>

    <?php if (!empty($error)): ?>
        <div class="error"><?= esc($error) ?></div>
    <?php elseif (empty($video)): ?>
        <div>No se encontró información del video.</div>
    <?php else: ?>
        <h1><?= esc($video['title']) ?></h1>

        <div class="video-player">
            <iframe src="https://www.youtube.com/embed/<?= esc($id) ?>" allowfullscreen allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
        </div>

        <p><?= nl2br(esc($video['description'])) ?></p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>