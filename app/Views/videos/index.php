<?php
/**
 * Variables available:
 * - array $videos (id => snippet) or ['error' => msg]
 * - array $videoIds (ordered list of ids)
 */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Foro Farmacias ADIUM - Videos</title>
    <link rel="stylesheet" href="<?= base_url('css/adium.css') ?>">
    <style>
        .videos-grid { display:flex; flex-wrap:wrap; gap:16px; }
        .video-card { width:240px; text-align:center; }
        .video-card img{ width:100%; height:auto; display:block; }
        .video-title{ font-size:14px; margin-top:8px; }
    </style>
</head>
<body>
    <h1>Videos</h1>

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

</body>
</html>
