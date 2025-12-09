<?= $this->extend('layouts/dashboardLayout') ?>

<?= $this->section('content') ?>
<main class="container mt-4">
  <div class="row">
    <div class="col-12">
      <h1>Escarapela</h1>
      <p class="lead">Descargá o mostrá tu escarapela oficial de Foro Farmacias ADIUM.</p>
      <div class="card mb-3" style="max-width: 420px;">
        <img src="<?= base_url('images/thumbnails/default.jpg') ?>" class="card-img-top" alt="Escarapela ejemplo">
        <div class="card-body">
          <h5 class="card-title">Escarapela ADIUM</h5>
          <p class="card-text">Usá esta imagen como escarapela en eventos o reuniones. Si necesitás la versión oficial, contactá al equipo.</p>
          <a href="<?= base_url('images/thumbnails/default.jpg') ?>" class="btn btn-primary" download>Descargar escarapela</a>
        </div>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection() ?>
