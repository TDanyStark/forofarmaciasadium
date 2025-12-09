<?= $this->extend('layouts/dashboardLayout') ?>

<?= $this->section('content') ?>
<main class="container mt-4">
  <div class="row">
    <div class="col-12">
      <h1>Juegos</h1>
      <p class="lead">Divertite con mini-juegos pensados para el congreso y las pausas entre charlas.</p>

      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Contador de clics</h5>
          <p class="card-text">Probá este pequeño juego: hacé clic en el botón y sumá puntos.</p>
          <button id="clickBtn" class="btn btn-success">Clic: <span id="count">0</span></button>
        </div>
      </div>

    </div>
  </div>
</main>

<script>
  (function(){
    const btn = document.getElementById('clickBtn');
    const countEl = document.getElementById('count');
    let count = 0;
    btn && btn.addEventListener('click', function(){
      count++;
      countEl.textContent = count;
    });
  })();
</script>

<?= $this->endSection() ?>
