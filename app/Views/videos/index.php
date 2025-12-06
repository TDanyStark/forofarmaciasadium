<?php $this->extend('layouts/videosLayout') ?>

<?php $this->section('content') ?>

<style>
    .videos-grid {
        display: grid;
        /* Use a smaller min width so items can wrap on small screens */
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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

    .video-orden {
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

    .video-author {
        font-size: 1.2rem;
        color: #666;
    }

    .video-title {
        font-size: 1.6rem;
        line-height: 1.9rem;
        font-weight: 600;
    }

    /* On very small screens, force single column and reduce gaps */
    @media (max-width: 480px) {
        .videos-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .video-card-info {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }

        .video-card {
            overflow: hidden;
        }

        .video-title {
            font-size: 1.2rem;
            line-height: 1.5rem;
            font-weight: 600;
        }

        .video-author {
            font-size: 1rem;
            color: #666;
        }
    }

    /* On large screens prefer columns of 450px width */
    @media (min-width: 992px) {
        .videos-grid {
            grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        }
    }
</style>
<main class="container py-5">

    <?php if (isset($videos['error'])): ?>
        <div class="error"><?= esc($videos['error']) ?></div>
    <?php endif; ?>

    <div class="videos-grid">
        <?php if (empty($videos)): ?>
            <div class="col-12">No hay videos para mostrar.</div>
        <?php else: ?>
            <?php foreach ($videos as $id => $snippet):
                // Support both database shape and YouTube-like snippet shape
                $title = $snippet['title'] ?? 'Video';
                $orden = $snippet['orden'] ?? '';
                $autor = $snippet['author'] ?? 'Autor desconocido';
                // Prefer explicit thumbnail field (from DB) but fall back to nested thumbnails
                if (!empty($snippet['thumbnail'])) {
                    $thumb = $snippet['thumbnail'];
                } elseif (!empty($snippet['thumbnails']['medium']['url'])) {
                    $thumb = $snippet['thumbnails']['medium']['url'];
                } else {
                    // Fallback to YouTube-hosted thumbnail when id looks like a youtube id
                    $thumb = 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
                }
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
        <?php endif; ?>
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