<?php
include 'configuracoes.php';
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('angolan_culture') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('culture_desc') ?>">

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
            background-color: #f9fafc;
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
            background: linear-gradient(rgba(0, 30, 25, 0.6), rgba(0, 30, 25, 0.6)), url('assets/gastronomia.jpg');
            background-size: cover;
            background-position: center;
            height: 50vh;
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
            padding-bottom: 0.9rem;
            margin: 3rem 0 2.5rem;
            text-align: center;
            font-size: 2.3rem;
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
            width: 80px;
            height: 5px;
            background: var(--accent);
            border-radius: 3px;
        }

        .culture-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        [data-theme="dark"] .culture-card {
            background: #1e293b;
            color: #e2e8f0;
        }
        .culture-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .card-body {
            padding: 1.8rem;
        }
        .card-title {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.4rem;
            font-family: 'Montserrat', sans-serif;
        }
        [data-theme="dark"] .card-title {
            color: #a7f3d0;
        }
        .icon-large {
            font-size: 2.4rem;
            color: var(--secondary);
            margin-bottom: 1.2rem;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            margin: 1.5rem 0;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
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
            .hero { height: 40vh; }
            .hero h1 { font-size: 2.2rem; }
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
        <li class="nav-item"><a class="nav-link active" href="cultura.php"><?= t('living_culture') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="contato.php"><?= t('contact') ?></a></li>
        
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
    <h1><?= t('angolan_culture_title') ?></h1>
    <p class="lead text-white"><?= t('angolan_culture_subtitle') ?></p>
  </div>
</section>

<div class="container">
  <h2 class="section-title"><?= t('pillars_of_identity') ?></h2>
  
  <div class="row g-4">
    <!-- Música e Dança -->
    <div class="col-md-6 col-lg-4">
      <div class="culture-card">
        <img src="assets/Circuito Cultural de Luanda.jpg" class="card-img-top" alt="<?= t('music_dance') ?>">
        <div class="card-body text-center">
          <div class="icon-large"><i class="fas fa-drum"></i></div>
          <h3 class="card-title"><?= t('music_dance') ?></h3>
          <p><?= t('music_dance_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Gastronomia -->
    <div class="col-md-6 col-lg-4">
      <div class="culture-card">
        <img src="assets/Mufete.jpg" class="card-img-top" alt="<?= t('gastronomy') ?>">
        <div class="card-body text-center">
          <div class="icon-large"><i class="fas fa-utensils"></i></div>
          <h3 class="card-title"><?= t('gastronomy') ?></h3>
          <p><?= t('gastronomy_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Artesanato -->
    <div class="col-md-6 col-lg-4">
      <div class="culture-card">
        <img src="assets/Artesanato.jpg" class="card-img-top" alt="<?= t('craftsmanship') ?>">
        <div class="card-body text-center">
          <div class="icon-large"><i class="fas fa-spa"></i></div>
          <h3 class="card-title"><?= t('craftsmanship') ?></h3>
          <p><?= t('craftsmanship_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Festivais -->
    <div class="col-md-6 col-lg-4">
      <div class="culture-card">
        <img src="assets/Festivais e Celebrações.jpg" class="card-img-top" alt="<?= t('festivals') ?>">
        <div class="card-body text-center">
          <div class="icon-large"><i class="fas fa-theater-masks"></i></div>
          <h3 class="card-title"><?= t('festivals') ?></h3>
          <p><?= t('festivals_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Línguas e Etnias -->
    <div class="col-md-6 col-lg-4">
      <div class="culture-card">
        <img src="assets/Etnias e Línguas.jpg" class="card-img-top" alt="<?= t('ethnic_groups') ?>">
        <div class="card-body text-center">
          <div class="icon-large"><i class="fas fa-users"></i></div>
          <h3 class="card-title"><?= t('ethnic_groups') ?></h3>
          <p><?= t('ethnic_groups_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Patrimônio Histórico -->
    <div class="col-md-6 col-lg-4">
      <div class="culture-card">
        <img src="assets/Patrimônio Histórico.jpg" class="card-img-top" alt="<?= t('historical_heritage') ?>">
        <div class="card-body text-center">
          <div class="icon-large"><i class="fas fa-monument"></i></div>
          <h3 class="card-title"><?= t('historical_heritage') ?></h3>
          <p><?= t('historical_heritage_desc') ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Vídeos Culturais -->
  <h2 class="section-title"><?= t('cultural_videos') ?></h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="culture-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('kizomba_origins') ?></h4>
          <div class="video-container">
            <iframe src="video/eu.mp4" allowfullscreen></iframe>
          </div>
          <p><?= t('kizomba_video_desc') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="culture-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('semba_tradition') ?></h4>
          <div class="video-container">
            <iframe src="video/angola.mp4" allowfullscreen></iframe>
          </div>
          <p><?= t('semba_video_desc') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="culture-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('ovimbundu_culture') ?></h4>
          <div class="video-container">
            <iframe src="video/angola.mp4" allowfullscreen></iframe> <!-- Substitua por link real -->
          </div>
          <p><?= t('ovimbundu_video_desc') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="culture-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('angolan_carnival') ?></h4>
          <div class="video-container">
            <iframe src="video/angola.mp4" allowfullscreen></iframe>
          </div>
          <p><?= t('carnival_video_desc') ?></p>
        </div>
      </div>
    </div>
  </div>
  
  <div class="text-center mt-5 mb-5">
    <a href="index.php" class="btn" style="background: var(--secondary); color: white; font-weight: 600; padding: 0.6rem 2rem; border-radius: 8px;">
      <?= t('back_to_home') ?>
    </a>
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
        <a href="destinos.php"><?= t('destinations') ?></a>
        <a href="cultura.php"><?= t('living_culture') ?></a>
        <a href="contato.php"><?= t('contact') ?></a>
      </div>
      <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
        <h5><?= t('resources') ?></h5>
        <a href="provincias.php"><?= t('provinces') ?></a>
        <a href="gastronomia.php"><?= t('gastronomy') ?></a>
        <a href="login.php"><?= t('login') ?></a>
        <a href="cadastro.php"><?= t('register') ?></a>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5><?= t('contact') ?></h5>
        <p><i class="fas fa-map-marker-alt me-2"></i> Luanda, Angola</p>
        <p><i class="fas fa-phone me-2"></i> +244 900 000 000</p>
        <p><i class="fas fa-envelope me-2"></i> info@turismoangola.ao</p>
      </div>
    </div>
    <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
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