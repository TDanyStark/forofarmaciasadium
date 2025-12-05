<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? esc($title) : 'Foro Farmacias ADIUM' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/adium.css') ?>">
  <style>
    /* Header styles */
    .site-header {
      background: #fff;
      border-bottom: 1px solid #e5e5e5;
      padding: 15px 0;
    }

    .container-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      padding: 12px 16px;
    }

    .brand .logo {
      height: 40px;
      display: block;
    }

    .main-nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 20px;
    }

    .main-nav a {
      text-decoration: none;
      color: #333;
      font-weight: 600;
    }

    .nav-toggle {
      display: none;
      background: none;
      border: 0;
      font-size: 24px;
      cursor: pointer;
    }

    @media (max-width:768px) {
      .main-nav {
        display: none;
        position: absolute;
        right: 16px;
        top: 60px;
        background: #fff;
        border: 1px solid #e5e5e5;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
      }

      .main-nav.open {
        display: block;
      }

      .main-nav ul {
        flex-direction: column;
        gap: 8px;
      }

      .nav-toggle {
        display: block;
      }
    }
  </style>
</head>

<body>
  <header class="site-header" role="banner">
    <div class="container-header">
      <a href="<?= site_url() ?>" class="brand">
        <img src="<?= base_url('images/adium_black.png') ?>" alt="ADIUM" class="logo">
      </a>
      <button class="nav-toggle" aria-expanded="false" aria-label="Abrir menú">&#9776;</button>
      <nav class="main-nav" id="mainNav" role="navigation" aria-label="Principal">
        <ul>
          <li><a href="<?= site_url('/') ?>">ON DEMAND</a></li>
          <li><a href="<?= site_url('escarapela') ?>">escarapela</a></li>
          <li><a href="<?= site_url('juegos') ?>">juegos</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <?= $this->renderSection('content') ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>