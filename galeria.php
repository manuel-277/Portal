<?php
include 'configuracoes.php';
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('gallery') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('gallery_desc') ?>">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #004d40;
            --secondary: #159f5f;
            --accent: #f59e0b;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        [data-theme="dark"] body {
            background-color: #0f172a;
            color: #e2e8f0;
        }

        .navbar {
            background: var(--primary);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 0.8rem 0;
        }
        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .navbar-brand img {
            height: 42px;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.2);
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 600;
            margin: 0 8px;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            transition: all 0.25s;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(21, 159, 95, 0.3);
            color: white !important;
        }

        /* User Profile */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            border-radius: 12px;
        }
        .dropdown-item { padding: 0.5rem 1rem; }
        .dropdown-item:hover { background: var(--secondary); color: white; }

        .hero {
            background: linear-gradient(rgba(0, 30, 25, 0.85), rgba(0, 30, 25, 0.85)), url('assets/img/galeria-hero.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }
        .hero h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 2.8rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.8rem;
            margin: 3rem 0 2rem;
            text-align: center;
        }
        [data-theme="dark"] .section-title {
            color: #a7f3d0;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .gallery-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            height: 100%;
            background: white;
        }
        [data-theme="dark"] .gallery-card {
            background: #1e293b;
            color: #e2e8f0;
        }
        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            color: var(--primary);
            margin-bottom: 0.8rem;
            font-size: 1.35rem;
        }
        [data-theme="dark"] .card-title {
            color: #a7f3d0;
        }
        .badge-category {
            background: #ecfdf5;
            color: var(--secondary);
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.85rem;
            display: inline-block;
            margin: 0.2rem 0.3rem 0.2rem 0;
        }
        [data-theme="dark"] .badge-category {
            background: #0c4a35;
            color: #6ee7b7;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        footer {
            background: var(--primary);
            color: white;
            padding: 2.5rem 0 1.5rem;
            margin-top: 4rem;
        }
        footer h5 {
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 1.2rem;
            color: var(--accent);
        }
        footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
            display: block;
            margin-bottom: 0.6rem;
        }
        footer a:hover {
            color: white;
        }

        @media (max-width: 768px) {
            .hero { height: 300px; }
            .hero h1 { font-size: 2.2rem; }
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="assets/logo.png" alt="Logotipo do Portal de Turismo de Angola">
      <span>Portal de Turismo de Angola</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="index.php"><?= t('home') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="destinos.php"><?= t('destinations') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="cultura.php"><?= t('living_culture') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="galeria.php"><?= t('gallery') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="provincias.php"><?= t('provinces') ?></a></li>
        
        <?php if (isLoggedIn()): ?>
            <li class="nav-item dropdown ms-2">
                <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <div class="user-avatar"><?= strtoupper(substr($user_name, 0, 1)) ?></div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="perfil.php"><i class="fas fa-user me-2"></i> <?= t('profile') ?></a></li>
                    <li><a class="dropdown-item" href="minhas-estrelas.php"><i class="fas fa-star me-2"></i> <?= t('my_stars') ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> <?= t('logout') ?></a></li>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php" style="color: var(--accent);"><?= t('login') ?></a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<section class="hero">
  <div class="container">
    <h1><?= t('gallery') ?></h1>
    <p class="lead"><?= t('gallery_subtitle') ?></p>
  </div>
</section>

<div class="container">
  <h2 class="section-title"><?= t('photos') ?></h2>
  <div class="gallery-grid">
    <!-- Foto 1 -->
    <div class="gallery-card">
      <img src="assets/galeria/luanda-sunset.jpg" class="card-img-top" alt="<?= t('luanda_sunset') ?>">
      <div class="card-body">
        <span class="badge-category"><?= t('capital') ?></span>
        <h5 class="card-title"><?= t('luanda_sunset') ?></h5>
        <p><?= t('luanda_sunset_desc') ?></p>
      </div>
    </div>
    
    <!-- Foto 2 -->
    <div class="gallery-card">
      <img src="assets/kalandula.jpg" class="card-img-top" alt="<?= t('kalandula_falls') ?>">
      <div class="card-body">
        <span class="badge-category"><?= t('nature') ?></span>
        <h5 class="card-title"><?= t('kalandula_falls') ?></h5>
        <p><?= t('kalandula_desc') ?></p>
      </div>
    </div>
    
    <!-- Foto 3 -->
    <div class="gallery-card">
      <img src="assets/mussulo-salinas.jpg" class="card-img-top" alt="<?= t('mussulo_salinas') ?>">
      <div class="card-body">
        <span class="badge-category"><?= t('culture') ?></span>
        <h5 class="card-title"><?= t('mussulo_salinas') ?></h5>
        <p><?= t('mussulo_desc') ?></p>
      </div>
    </div>
    
    <!-- Foto 4 -->
    <div class="gallery-card">
      <img src="assets/huila-tundavala.jpg" class="card-img-top" alt="<?= t('tundavala_view') ?>">
      <div class="card-body">
        <span class="badge-category"><?= t('mountains') ?></span>
        <h5 class="card-title"><?= t('tundavala_view') ?></h5>
        <p><?= t('tundavala_desc') ?></p>
      </div>
    </div>
  </div>

  <h2 class="section-title mt-5"><?= t('videos') ?></h2>
  <div class="row g-4">
    <!-- Vídeo 1 -->
    <div class="col-md-6 col-lg-4">
      <div class="gallery-card">
        <div class="video-container">
          <iframe src="https://www.youtube.com/embed/gq2bvwrERUc?si=HgdrHjWmgnr8AQ5D" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="card-body">
          <span class="badge-category"><?= t('official') ?></span>
          <h5 class="card-title"><?= t('angola_tourism_video') ?></h5>
          <p><?= t('angola_tourism_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Vídeo 2 -->
    <div class="col-md-6 col-lg-4">
      <div class="gallery-card">
        <div class="video-container">
          <iframe src="https://www.youtube.com/embed/0dw-iDH2SS8?si=N2ytsYqTll0Pu4B4" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="card-body">
          <span class="badge-category"><?= t('gastronomy') ?></span>
          <h5 class="card-title"><?= t('funge_tradition') ?></h5>
          <p><?= t('funge_video_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Vídeo 3 -->
    <div class="col-md-6 col-lg-4">
      <div class="gallery-card">
        <div class="video-container">
          <iframe src="https://www.youtube.com/embed/iE-2LqWydM4?si=Abi-vbgrJ516p7ra" title="YouTube video player" frameborder="0" " allowfullscreen></iframe>
        </div>
        <div class="card-body">
          <span class="badge-category"><?= t('music') ?></span>
          <h5 class="card-title"><?= t('kizomba_origins') ?></h5>
          <p><?= t('kizomba_video_desc') ?></p>
        </div>
      </div>
    </div>
  </div>

  <h2 class="section-title mt-5"><?= t('featured_categories') ?></h2>
  <div class="row g-4">
    <div class="col-md-6 col-lg-3">
      <div class="gallery-card text-center py-4">
        <i class="fas fa-camera fa-3x mb-3" style="color: var(--secondary);"></i>
        <h5><?= t('nature') ?></h5>
        <p><?= t('nature_gallery_desc') ?></p>
        <a href="#" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('view_more') ?></a>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="gallery-card text-center py-4">
        <i class="fas fa-utensils fa-3x mb-3" style="color: var(--secondary);"></i>
        <h5><?= t('gastronomy') ?></h5>
        <p><?= t('gastronomy_gallery_desc') ?></p>
        <a href="gastronomia.php" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('explore') ?></a>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="gallery-card text-center py-4">
        <i class="fas fa-music fa-3x mb-3" style="color: var(--secondary);"></i>
        <h5><?= t('music_dance') ?></h5>
        <p><?= t('music_gallery_desc') ?></p>
        <a href="cultura.php#music" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('learn_more') ?></a>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="gallery-card text-center py-4">
        <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: var(--secondary);"></i>
        <h5><?= t('provinces') ?></h5>
        <p><?= t('provinces_gallery_desc') ?></p>
        <a href="provincias.php" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('discover') ?></a>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <h5>Portal de Turismo de Angola</h5>
        <p><?= t('official_guide') ?></p>
      </div>
      <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
        <h5><?= t('links') ?></h5>
        <a href="index.php"><?= t('home') ?></a>
        <a href="galeria.php"><?= t('gallery') ?></a>
        <a href="destinos.php"><?= t('destinations') ?></a>
        <a href="cultura.php"><?= t('living_culture') ?></a>
      </div>
      <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
        <h5><?= t('resources') ?></h5>
        <a href="provincias.php"><?= t('provinces') ?></a>
        <a href="gastronomia.php"><?= t('gastronomy') ?></a>
        <a href="login.php"><?= t('login') ?></a>
        <a href="cadastro.php"><?= t('register') ?></a>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5><?= t('stay_connected') ?></h5>
        <p><?= t('receive_offers') ?></p>
        <div class="input-group">
          <input type="email" class="form-control" placeholder="<?= t('your_email') ?>">
          <button class="btn" style="background: var(--secondary); color: white;"><?= t('ok') ?></button>
        </div>
      </div>
    </div>
    <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
    <div class="text-center">
      &copy; <?= date('Y') ?> Portal de Turismo de Angola. <?= t('all_rights_reserved') ?>.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Aplica tema salvo
    document.documentElement.setAttribute('data-theme', '<?= esc($user_theme) ?>');
</script>
</body>
</html>