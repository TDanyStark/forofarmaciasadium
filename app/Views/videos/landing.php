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
            <div id="player"></div>
        </div>

        <h1><?= esc($video['title']) ?></h1>
        <p class="info-autor">Por: <?= esc($video['author'] ?? $video['channelTitle'] ?? 'Autor desconocido') ?></p>

        <p><?= nl2br(esc($video['description'] ?? '')) ?></p>

        <?php if (!empty($video['documents'])): ?>
            <div class="video-documents" style="margin-top: 20px;">
                <h3 style="font-size: 1.2rem; margin-bottom: 10px;">Documentos adjuntos</h3>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($video['documents'] as $doc): ?>
                        <li style="margin-bottom: 8px;">
                            <a href="<?= base_url($doc['file_path']) ?>" target="_blank" class="btn-adium" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; font-size: 0.9rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                </svg>
                                <?= esc($doc['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<meta name="csrf-token-name" content="<?= esc(csrf_token()) ?>">
<meta name="csrf-token" content="<?= esc(csrf_hash()) ?>">

<script>
    // YouTube IFrame API loader
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '360',
            width: '640',
            videoId: '<?= esc($id) ?>',
            playerVars: {
                'playsinline': 1
            },
            events: {
                'onReady': onPlayerReady
            }
        });
    }

    function onPlayerReady(event) {
        // Start periodic progress saving every 30 seconds
        setInterval(function() {
            if (!player || typeof player.getCurrentTime !== 'function') return;
            var seconds = Math.floor(player.getCurrentTime());
            sendProgress(seconds);
        }, 30000);
    }

    function sendProgress(seconds) {
        var tokenName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
        var tokenValue = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var form = new FormData();
        form.append('video_id', '<?= esc($id) ?>');
        form.append('seconds', seconds);
        form.append(tokenName, tokenValue);

        fetch('<?= site_url('api/video/progress') ?>', {
            method: 'POST',
            credentials: 'same-origin',
            body: form,
            headers: {
                'X-Requested-With': 'fetch'
            }
        }).then(function(res) {
            // optional: handle response
            return res.json();
        }).then(function(json) {
            // console.log('Progress saved', json);
        }).catch(function(err) {
            // console.warn('Progress save failed', err);
        });
    }

    // Try to send a final progress update when the user leaves the page
    window.addEventListener('beforeunload', function () {
        try {
            if (!player || typeof player.getCurrentTime !== 'function') return;
            var seconds = Math.floor(player.getCurrentTime());
            var tokenName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
            var tokenValue = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var body = tokenName + '=' + encodeURIComponent(tokenValue)
                + '&video_id=' + encodeURIComponent('<?= esc($id) ?>')
                + '&seconds=' + encodeURIComponent(seconds);

            var blob = new Blob([body], { type: 'application/x-www-form-urlencoded' });
            navigator.sendBeacon('<?= site_url('api/video/progress') ?>', blob);
        } catch (e) {
            // ignore
        }
    });
</script>
<?= $this->endSection() ?>