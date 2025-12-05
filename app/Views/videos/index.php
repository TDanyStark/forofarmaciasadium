<?php $this->extend('layouts/videosLayout') ?>

<?php $this->section('content') ?>

<style>
    .videos-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .video-card {
        width: 240px;
        text-align: center;
    }

    .video-card img {
        width: 100%;
        height: auto;
        display: block;
    }

    .video-title {
        font-size: 14px;
        margin-top: 8px;
    }
</style>
<main class="container">

    <?php if (isset($videos['error'])): ?>
        <div class="error"><?= esc($videos['error']) ?></div>
    <?php endif; ?>

    <div class="videos-grid">
        <?php foreach ($videoIds as $id):
            $snippet = $videos[$id] ?? null;
            $title = $snippet['title'] ?? 'Video';
            $thumb = $snippet['thumbnails']['medium']['url'] ?? 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
        ?>
            <div class="video-card">
                <a href="<?= site_url('video/' . $id) ?>">
                    <img src="<?= esc($thumb) ?>" alt="<?= esc($title) ?>">
                </a>
                <div class="video-title"><?= esc($title) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<script>
    (function() {
        var navToggle = document.querySelector('.nav-toggle');
        var mainNav = document.getElementById('mainNav');
        if (!navToggle || !mainNav) return;
        navToggle.addEventListener('click', function() {
            var expanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', (!expanded).toString());
            mainNav.classList.toggle('open');
        });
    })();
</script>
<?php $this->endSection() ?>