<?php $this->extend('layouts/dashboardLayout') ?>

<?php $this->section('content') ?>
<main class="container" style="max-width: 900px; margin:0 auto; margin-top: 20px; margin-bottom: 20px;">
    <h1>Certificado</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="progress-section" style="margin-bottom: 30px;">
        <p>Has visto <strong><?= esc($viewedCount) ?></strong> de <strong><?= esc($totalVideos) ?></strong> sesiones.</p>
        <p>Necesitas al menos <strong><?= esc($threshold) ?></strong> sesiones vistas para obtener el certificado.</p>
        
        <?php 
            $percentage = ($threshold > 0) ? min(100, round(($viewedCount / $threshold) * 100)) : 0;
            if (isset($isEligible) && $isEligible) $percentage = 100;
        ?>
        <div class="progress" style="height: 25px; background-color: #e9ecef; border-radius: 5px; margin-bottom: 20px; overflow: hidden;">
            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%; background-color: var(--adium-red); color: white; text-align: center; line-height: 25px; transition: width 0.5s ease;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $percentage ?>%
            </div>
        </div>
    </div>

    <?php if (isset($isEligible) && $isEligible): ?>
        <div class="certificate-actions">
            <p style="color: green; font-weight: bold;">¡Felicidades! Ya puedes descargar tu certificado.</p>
            
            <div class="mb-3" style="margin-bottom: 20px;">
                <a href="<?= base_url('certificado/download') ?>" class="btn-adium">Descargar Certificado</a>
            </div>

            <div class="certificate-preview" style="border: 1px solid #ddd; padding: 10px; background: white;">
                <h3>Vista Previa</h3>
                <iframe src="<?= base_url('certificado/preview') ?>" width="100%" height="600px" style="border: none;">
                    Tu navegador no soporta iframes. <a href="<?= base_url('certificado/download') ?>">Descarga el certificado aquí</a>.
                </iframe>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info" style="background-color: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px;">
            Sigue viendo las sesiones para alcanzar el certificado.
        </div>
    <?php endif; ?>

    <p class="mt-3" style="margin-top: 20px;"><a href="/" style="color: var(--adium-red);">Volver a videos</a></p>
</main>
<?php $this->endSection() ?>