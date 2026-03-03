<?php
include 'configuracoes.php';
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('angolan_cuisine') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('cuisine_desc') ?>">

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
            background: url('assets/gastronomia.jpg');
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
            padding-bottom: 0.8rem;
            margin: 2.5rem 0 2rem;
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

        .dish-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            height: 100%;
            background: white;
        }
        [data-theme="dark"] .dish-card {
            background: #1e293b;
            color: #e2e8f0;
        }
        .dish-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
        }
        .card-title {
            color: var(--primary);
            margin-bottom: 0.8rem;
            font-size: 1.35rem;
        }
        [data-theme="dark"] .card-title {
            color: #a7f3d0;
        }
        .badge-custom {
            background: #ecfdf5;
            color: var(--secondary);
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.85rem;
            display: inline-block;
            margin: 0.2rem 0.3rem 0.2rem 0;
        }
        [data-theme="dark"] .badge-custom {
            background: #0c4a35;
            color: #6ee7b7;
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
        <li class="nav-item"><a class="nav-link" href="cultura.php"><?= t('living_culture') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="gastronomia.php"><?= t('gastronomy') ?></a></li>
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
    <h1><?= t('soul_on_plate') ?></h1>
    <p class="lead"><?= t('cuisine_subtitle') ?></p>
  </div>
</section>

<div class="container">
  <h2 class="section-title"><?= t('typical_dishes') ?></h2>
  
  <div class="row g-4">
    <!-- Funge com Muamba -->
    <div class="col-md-6 col-lg-4">
      <div class="dish-card">
        <img src="assets/fungi.jpg" class="card-img-top" alt="Funge com Muamba">
        <div class="card-body">
          <h5 class="card-title">Funge com Muamba</h5>
          <span class="badge-custom"><?= t('national') ?></span>
          <p><?= t('funge_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Calulu -->
    <div class="col-md-6 col-lg-4">
      <div class="dish-card">
        <img src="assets/Calulu.jpg" class="card-img-top" alt="Calulu">
        <div class="card-body">
          <h5 class="card-title">Calulu</h5>
          <span class="badge-custom"><?= t('coastal') ?></span>
          <p><?= t('calulu_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Mufete -->
    <div class="col-md-6 col-lg-4">
      <div class="dish-card">
        <img src="assets/Mufetes.jpg" class="card-img-top" alt="Mufete">
        <div class="card-body">
          <h5 class="card-title">Mufete</h5>
          <span class="badge-custom">Benguela</span>
          <p><?= t('mufete_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Moamba de Galinha -->
    <div class="col-md-6 col-lg-4">
      <div class="dish-card">
        <img src="assets/Moamba.jpg" class="card-img-top" alt="Moamba de Galinha">
        <div class="card-body">
          <h5 class="card-title">Moamba de Galinha</h5>
          <span class="badge-custom">Luanda</span>
          <p><?= t('moamba_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Quitaba -->
    <div class="col-md-6 col-lg-4">
      <div class="dish-card">
        <img src="assets/Quitaba.jpeg" class="card-img-top" alt="Quitaba">
        <div class="card-body">
          <h5 class="card-title">Quitaba</h5>
          <span class="badge-custom"><?= t('savanna') ?></span>
          <p><?= t('quitaba_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Piri-Piri -->
    <div class="col-md-6 col-lg-4">
      <div class="dish-card">
        <img src="assets/Piri-Piri.jpg" class="card-img-top" alt="Piri-Piri">
        <div class="card-body">
          <h5 class="card-title">Piri-Piri</h5>
          <span class="badge-custom"><?= t('nationwide') ?></span>
          <p><?= t('piripiri_desc') ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Vídeos de Gastronomia -->
  <h2 class="section-title"><?= t('culinary_videos') ?></h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="dish-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('how_to_make_funge') ?></h4>
          <div class="video-container">
            <iframe src="https://www.youtube.com/embed/2-H_4I0hf7s?si=c3LR1xpxi7ROOCU6" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
          </div>
          <p><?= t('funge_video_desc') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dish-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('calulu_tradition') ?></h4>
          <div class="video-container">
            <iframe src="https://www.youtube.com/embed/xZfphbd50Ho?si=mT7pFS2bt6bw_81O" title="YouTube video player" frameborder="0"  allowfullscreen></iframe>
          </div>
          <p><?= t('calulu_video_desc') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dish-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('angolan_cooking_secrets') ?></h4>
          <div class="video-container">
            <iframe src="https://www.youtube.com/embed/fTSGjIckA1w?si=2WbEIEQmIJ296mHT" title="YouTube video player" frameborder="0"  allowfullscreen></iframe> <!-- Substitua por link real -->
          </div>
          <p><?= t('cooking_secrets_desc') ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="dish-card">
        <div class="card-body">
          <h4 class="card-title"><?= t('street_food_angola') ?></h4>
          <div class="video-container">
            <iframe src="https://www.youtube.com/embed/lJvduAkVrFI?si=kLvY5QZypjnbAOP9" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
          </div>
          <p><?= t('street_food_desc') ?></p>
        </div>
      </div>
    </div>
  </div>
  
  <div class="text-center mt-5">
    <a href="destinos.php" class="btn" style="background: var(--secondary); color: white; font-weight: 600; padding: 0.6rem 2rem; border-radius: 8px;">
      <?= t('view_destinations_with_food') ?>
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
        <a href="gastronomia.php"><?= t('gastronomy') ?></a>
        <a href="destinos.php"><?= t('destinations') ?></a>
        <a href="cultura.php"><?= t('living_culture') ?></a>
      </div>
      <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
        <h5><?= t('resources') ?></h5>
        <a href="provincias.php"><?= t('provinces') ?></a>
        <a href="experiencias.php"><?= t('experiences') ?></a>
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