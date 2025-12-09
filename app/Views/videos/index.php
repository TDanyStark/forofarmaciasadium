<?php $this->extend('layouts/dashboardLayout') ?>

<?php $this->section('content') ?>

<style>
    /* Mobile-first base styles */
    .videos-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        padding: 0 0.5rem;
    }

    .video-card {
        width: 100%;
    }

    .video-card img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 6px;
    }

    /* Stack content vertically on mobile for easy tap targets */
    .video-card-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 1rem;
        align-items: flex-start;
    }

    .video-orden {
        font-size: 1rem;
        font-weight: 700;
        background-color: var(--adium-red);
        padding: 4px 8px;
        color: #fff;
        border-radius: 999px;
        min-width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }

    .video-author {
        font-size: 0.95rem;
        color: #666;
    }

    .video-title {
        font-size: 1.1rem;
        line-height: 1.3rem;
        font-weight: 600;
    }

    .article-video {
        display: inline-block;
        border-radius: 6px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease-in-out;
    }

    .article-video:hover {
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    /* Badge for seen videos */
    .video-seen-badge {
        display: inline-block;
        background: #28a745;
        color: #fff;
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 999px;
        margin-left: 8px;
    }
    .article-video.visto {
        opacity: 0.95;
        box-shadow: 0 2px 8px rgba(40,167,69,0.08);
    }

    /* Small screens and up: allow multiple columns */
    @media (min-width: 576px) {
        .videos-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .video-card-info {
            padding: 0.75rem;
        }

        .video-title {
            font-size: 1.25rem;
            line-height: 1.6rem;
        }

        .video-author {
            font-size: 1rem;
        }
    }

    /* Large screens: side-by-side layout for card info */
    @media (min-width: 992px) {
        .videos-grid {
            grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
            gap: 30px;
        }

        .video-card-info {
            flex-direction: row;
            gap: 12px;
            align-items: flex-start;
            padding: 1rem 1rem 1.2rem 1rem;
        }

        .video-title {
            font-size: 1.5rem;
            line-height: 1.8rem;
        }

        .video-author {
            font-size: 1.2rem;
            margin-top: 4px;
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
                    <?php $isSeen = (! empty($viewedVideos) && in_array($id, $viewedVideos, true)); ?>
                    <a class="article-video <?= $isSeen ? 'visto' : '' ?>" href="<?= site_url('video/' . $id) ?>">
                        <img class="rounded" src="<?= esc($thumb) ?>" alt="<?= esc($title) ?>">
                        <div class="video-card-info">
                            <span class="video-orden"><?= esc($orden) ?></span>
                            <div>
                                <?php if ($isSeen): ?>
                                    <div><span class="video-seen-badge">VISTO</span></div>
                                <?php endif; ?>
                                <div class="video-title"><?= esc($title) ?></div>
                                <div class="video-author"><?= esc($autor) ?></div>
                            </div>
                        </div>
                    </a>
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

<script>
    // Intenta obtener el email del usuario activo desde el backend y prefill
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Primero, intenta consultar el endpoint en el servidor.
            // Construimos la URL de forma robusta: si PHP genera una URL absoluta la usamos,
            // si genera una ruta relativa la preparamos con el origen para que siempre se haga desde '/'.
            var apiPath = '<?= site_url('api/user/email') ?>';
            var apiUrl = apiPath.match(/^https?:\/\//) ? apiPath : (window.location.origin + (apiPath.charAt(0) === '/' ? apiPath : ('/' + apiPath)));

            fetch(apiUrl, {
                    credentials: 'same-origin'
                })
                .then(function(res) {
                    if (!res.ok) return null;
                    return res.json();
                })
                .then(function(data) {
                    if (!data) return;
                    if (data.email) {
                        try {
                            localStorage.setItem('login_user_email', String(data.email).trim().toLowerCase());
                        } catch (e) {
                            console.warn('No se pudo guardar el email en localStorage:', e);
                        }
                    }
                })
                .catch(function(err) {
                    console.warn('No se pudo obtener email desde API:', err);
                });

        });
    })();
</script>
<?php $this->endSection() ?>