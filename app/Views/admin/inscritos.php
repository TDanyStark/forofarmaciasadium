<?= $this->extend('layouts/adminLayout') ?>

<?= $this->section('content') ?>
  <h2 class="mb-3">Inscritos</h2>

  <?php
  $query = array_filter($filters, static function ($value) {
    return $value !== '' && $value !== null;
  });
  $exportUrl = site_url('admin/export/inscritos') . ($query ? ('?' . http_build_query($query)) : '');
  ?>

  <div class="filters">
    <form method="get" action="<?= site_url('admin/inscritos') ?>" class="row g-3">
      <div class="col-md-2">
        <label class="form-label">Desde</label>
        <input class="form-control" type="date" name="date_from" value="<?= esc($filters['date_from']) ?>">
      </div>
      <div class="col-md-2">
        <label class="form-label">Hasta</label>
        <input class="form-control" type="date" name="date_to" value="<?= esc($filters['date_to']) ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Video</label>
        <select class="form-select" name="video_id">
          <option value="">Todos</option>
          <?php foreach ($videos as $video) : ?>
            <option value="<?= esc($video['id']) ?>" <?= $filters['video_id'] === (string) $video['id'] ? 'selected' : '' ?>>
              <?= esc($video['nombre']) ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Visto</label>
        <select class="form-select" name="watched">
          <option value="">Todos</option>
          <option value="1" <?= $filters['watched'] === '1' ? 'selected' : '' ?>>Si</option>
          <option value="0" <?= $filters['watched'] === '0' ? 'selected' : '' ?>>No</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Nombre o email</label>
        <input class="form-control" type="text" name="q" value="<?= esc($filters['q']) ?>" placeholder="Buscar">
      </div>
      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Aplicar</button>
        <a class="btn btn-outline-secondary" href="<?= site_url('admin/inscritos') ?>">Limpiar</a>
        <a class="btn btn-outline-success" href="<?= esc($exportUrl) ?>">Descargar CSV</a>
      </div>
    </form>
  </div>

  <div class="table-wrap">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Ciudad</th>
          <th>Farmacia</th>
          <th>Vistas</th>
          <th>Ultima vista</th>
          <th>Detalle videos</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($inscritos)) : ?>
          <tr>
            <td colspan="8" class="muted">Sin resultados.</td>
          </tr>
        <?php else : ?>
          <?php foreach ($inscritos as $row) : ?>
            <tr>
              <td><?= esc($row['id']) ?></td>
              <td><?= esc(trim(($row['nombres'] ?? '') . ' ' . ($row['apellidos'] ?? ''))) ?></td>
              <td><?= esc($row['email'] ?? '') ?></td>
              <td><?= esc($row['ciudad'] ?? '') ?></td>
              <td><?= esc($row['nombre_farmacia'] ?? '') ?></td>
              <td><?= esc($row['viewed_videos'] ?? 0) ?></td>
              <td><?= esc($row['last_viewed_at'] ?? '') ?></td>
              <td>
                <?php $views = $viewsByUser[$row['id']] ?? []; ?>
                <?php if (empty($views)) : ?>
                  <span class="muted">Sin vistas</span>
                <?php else : ?>
                  <ul class="mb-0">
                    <?php foreach ($views as $view) : ?>
                      <li><?= esc(($view['video_name'] ?? 'N/A') . ' - ' . ($view['viewed_at'] ?? '')) ?></li>
                    <?php endforeach ?>
                  </ul>
                <?php endif ?>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </tbody>
    </table>
  </div>
<?= $this->endSection() ?>
