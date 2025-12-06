<?php $this->extend('layouts/videosLayout') ?>

<?php $this->section('content') ?>

<style>
    .videos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        gap: 30px;
    }

    .video-card {
        width: 100%;
    }

    .video-card img {
        width: 100%;
        height: auto;
        display: block;
    }

    .video-card-info {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        gap: 8px;
    }

    .video-orden{
        font-size: 1.2rem;
        font-weight: 700;
        background-color: var(--adium-red);
        padding: 2px 6px;
        color: white;
        border-radius: 100%;
        min-width: 30px;
        height: 30px;
        text-align: center;
        display: inline-block;
    }

    .video-author{
        font-size: 1.2rem;
        color: #666;
    }

    .video-title {
        font-size: 1.6rem;
        line-height: 1.9rem;
        font-weight: 600;
    }
</style>
<main class="container py-5">

    <?php if (isset($videos['error'])): ?>
        <div class="error"><?= esc($videos['error']) ?></div>
    <?php endif; ?>

    <div class="videos-grid">
        <?php foreach ($videoIds as $id):
            $snippet = $videos[$id] ?? null;
            $title = $snippet['title'] ?? 'Video';
            $orden = $snippet['orden'] ?? '';
            $autor = $snippet['author'] ?? $snippet['channelTitle'] ?? 'Autor desconocido';
            $thumb = $snippet['thumbnails']['medium']['url'] ?? 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
        ?>
            <div class="video-card">
                <a href="<?= site_url('video/' . $id) ?>">
                    <img class="rounded" src="<?= esc($thumb) ?>" alt="<?= esc($title) ?>">
                </a>
                <div class="video-card-info p-4 pt-2">
                    <span class="video-orden"><?= esc($orden) ?></span>
                    <div>
                        <div class="video-title"><?= esc($title) ?></div>
                        <div class="video-author"><?= esc($autor) ?></div>
                    </div>
                </div>
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