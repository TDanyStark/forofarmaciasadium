<!doctype html>
<html lang="es">

<head>
  <?= $this->include('layouts/partials/head') ?>
  <style>
    .admin-header {
      background: #0f1f2b;
      color: #fff;
      padding: 12px 0;
    }

    .admin-header a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
    }

    .admin-nav {
      display: flex;
      gap: 16px;
      align-items: center;
      justify-content: space-between;
    }

    .admin-nav-links {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .admin-nav a.active {
      text-decoration: underline;
    }

    .admin-content {
      padding: 24px 0 48px;
    }

    .filters {
      background: #f5f7f8;
      border: 1px solid #e2e6ea;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 20px;
    }

    .table-wrap {
      overflow-x: auto;
    }

    .muted {
      color: #6c757d;
    }
  </style>
</head>

<body>
  <?php $current = uri_string(); ?>
  <header class="admin-header">
    <div class="container admin-nav">
      <div class="admin-nav-links">
        <a href="<?= site_url('admin/inscritos') ?>" class="<?= $current === 'admin/inscritos' ? 'active' : '' ?>">Inscritos</a>
        <a href="<?= site_url('admin/video-views') ?>" class="<?= $current === 'admin/video-views' ? 'active' : '' ?>">Vistas por video</a>
      </div>
      <div class="admin-nav-links">
        <a href="<?= site_url('admin/logout') ?>">Salir</a>
      </div>
    </div>
  </header>

  <main class="container admin-content">
    <?= $this->renderSection('content') ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
