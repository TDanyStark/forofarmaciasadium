<?= $this->extend('layouts/adminLayout') ?>

<?= $this->section('content') ?>
  <h2 class="mb-3">Vistas por video</h2>

  <?php
  $query = array_filter($filters, static function ($value) {
    return $value !== '' && $value !== null;
  });
  $exportUrl = site_url('admin/export/video-views') . ($query ? ('?' . http_build_query($query)) : '');
  ?>

  <div class="filters">
    <form method="get" action="<?= site_url('admin/video-views') ?>" class="row g-3">
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
      <div class="col-md-3">
        <label class="form-label">Nombre o email</label>
        <input class="form-control" type="text" name="q" value="<?= esc($filters['q']) ?>" placeholder="Buscar">
      </div>
      <div class="col-md-2 d-flex align-items-end gap-2">
        <button class="btn btn-primary" type="submit">Aplicar</button>
        <a class="btn btn-outline-success" href="<?= esc($exportUrl) ?>">CSV</a>
      </div>
    </form>
  </div>

  <div class="table-wrap">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Video</th>
          <th>Usuario</th>
          <th>Email</th>
          <th>Fecha</th>
          <th>IP</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($rows)) : ?>
          <tr>
            <td colspan="5" class="muted">Sin resultados.</td>
          </tr>
        <?php else : ?>
          <?php foreach ($rows as $row) : ?>
            <tr>
              <td><?= esc($row['video_name'] ?? '') ?></td>
              <td><?= esc(trim(($row['nombres'] ?? '') . ' ' . ($row['apellidos'] ?? ''))) ?></td>
              <td><?= esc($row['email'] ?? '') ?></td>
              <td><?= esc($row['viewed_at'] ?? '') ?></td>
              <td><?= esc($row['ip'] ?? '') ?></td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </tbody>
    </table>
  </div>
<?= $this->endSection() ?>
