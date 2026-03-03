<?php
include 'configuracoes.php';
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('angolan_provinces') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('provinces_desc') ?>">

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
            background: linear-gradient(rgba(0, 30, 25, 0.85), rgba(0, 30, 25, 0.85)), url('assets/hero.jpg');
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

        .province-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            height: 100%;
            background: white;
        }
        [data-theme="dark"] .province-card {
            background: #1e293b;
            color: #e2e8f0;
        }
        .province-card:hover {
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
        <li class="nav-item"><a class="nav-link active" href="provincias.php"><?= t('provinces') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="destinos.php"><?= t('destinations') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="cultura.php"><?= t('living_culture') ?></a></li>
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
    <h1><?= t('angolan_provinces_title') ?></h1>
    <p class="lead"><?= t('provinces_subtitle') ?></p>
  </div>
</section>

<div class="container">
  <h2 class="section-title"><?= t('explore_by_province') ?></h2>
  
  <div class="row g-4">
    <!-- Luanda -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/luanda.png" class="card-img-top" alt="Luanda">
        <div class="card-body">
          <h5 class="card-title">Luanda</h5>
          <span class="badge-custom"><?= t('capital') ?></span>
          <p class="mt-2"><?= t('luanda_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Bengo -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/bengo.jpg" class="card-img-top" alt="Bengo">
        <div class="card-body">
          <h5 class="card-title">Bengo</h5>
          <span class="badge-custom"><?= t('nature_reserve') ?></span>
          <p class="mt-2"><?= t('bengo_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Benguela -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/benguela.jpg" class="card-img-top" alt="Benguela">
        <div class="card-body">
          <h5 class="card-title">Benguela</h5>
          <span class="badge-custom"><?= t('beach') ?></span>
          <p class="mt-2"><?= t('benguela_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Bié -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Bié.png" class="card-img-top" alt="Bié">
        <div class="card-body">
          <h5 class="card-title">Bié</h5>
          <span class="badge-custom"><?= t('plateau') ?></span>
          <p class="mt-2"><?= t('bie_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Cabinda -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/cabinda.jpg" class="card-img-top" alt="Cabinda">
        <div class="card-body">
          <h5 class="card-title">Cabinda</h5>
          <span class="badge-custom"><?= t('oil') ?></span>
          <p class="mt-2"><?= t('cabinda_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Cuando Cubango -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/cuando Cubango.jpg" class="card-img-top" alt="Cuando Cubango">
        <div class="card-body">
          <h5 class="card-title">Cuando Cubango</h5>
          <span class="badge-custom"><?= t('safari') ?></span>
          <p class="mt-2"><?= t('cuando_cubango_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Cuanza Norte -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/cuanza Norte.png" class="card-img-top" alt="Cuanza Norte">
        <div class="card-body">
          <h5 class="card-title">Cuanza Norte</h5>
          <span class="badge-custom"><?= t('rivers') ?></span>
          <p class="mt-2"><?= t('cuanza_norte_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Cuanza Sul -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/cuanza Sul.jpeg" class="card-img-top" alt="Cuanza Sul">
        <div class="card-body">
          <h5 class="card-title">Cuanza Sul</h5>
          <span class="badge-custom"><?= t('agriculture') ?></span>
          <p class="mt-2"><?= t('cuanza_sul_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Cunene -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/cunene.jpg" class="card-img-top" alt="Cunene">
        <div class="card-body">
          <h5 class="card-title">Cunene</h5>
          <span class="badge-custom"><?= t('border') ?></span>
          <p class="mt-2"><?= t('cunene_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Huambo -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/huambo.jpg" class="card-img-top" alt="Huambo">
        <div class="card-body">
          <h5 class="card-title">Huambo</h5>
          <span class="badge-custom"><?= t('culture') ?></span>
          <p class="mt-2"><?= t('huambo_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Huíla -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/huila.jpg" class="card-img-top" alt="Huíla">
        <div class="card-body">
          <h5 class="card-title">Huíla</h5>
          <span class="badge-custom"><?= t('mountains') ?></span>
          <p class="mt-2"><?= t('huila_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Lunda Norte -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Lunda Norte.jpg" class="card-img-top" alt="Lunda Norte">
        <div class="card-body">
          <h5 class="card-title">Lunda Norte</h5>
          <span class="badge-custom"><?= t('diamonds') ?></span>
          <p class="mt-2"><?= t('lunda_norte_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Lunda Sul -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Lunda Sul.jpg" class="card-img-top" alt="Lunda Sul">
        <div class="card-body">
          <h5 class="card-title">Lunda Sul</h5>
          <span class="badge-custom"><?= t('mining') ?></span>
          <p class="mt-2"><?= t('lunda_sul_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Malanje -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/malanje.jpg" class="card-img-top" alt="Malanje">
        <div class="card-body">
          <h5 class="card-title">Malanje</h5>
          <span class="badge-custom"><?= t('nature') ?></span>
          <p class="mt-2"><?= t('malanje_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Moxico -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Moxico.jpg" class="card-img-top" alt="Moxico">
        <div class="card-body">
          <h5 class="card-title">Moxico</h5>
          <span class="badge-custom"><?= t('savanna') ?></span>
          <p class="mt-2"><?= t('moxico_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Namibe -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Namibe.jpg" class="card-img-top" alt="Namibe">
        <div class="card-body">
          <h5 class="card-title">Namibe</h5>
          <span class="badge-custom"><?= t('desert') ?></span>
          <p class="mt-2"><?= t('namibe_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Uíge -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Uíge.jpeg" class="card-img-top" alt="Uíge">
        <div class="card-body">
          <h5 class="card-title">Uíge</h5>
          <span class="badge-custom"><?= t('forest') ?></span>
          <p class="mt-2"><?= t('uige_desc') ?></p>
        </div>
      </div>
    </div>
    
    <!-- Zaire -->
    <div class="col-md-6 col-lg-4">
      <div class="province-card">
        <img src="assets/provincias/Zaire.jpg" class="card-img-top" alt="Zaire">
        <div class="card-body">
          <h5 class="card-title">Zaire</h5>
          <span class="badge-custom"><?= t('congo_river') ?></span>
          <p class="mt-2"><?= t('zaire_desc') ?></p>
        </div>
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
        <a href="provincias.php"><?= t('provinces') ?></a>
        <a href="destinos.php"><?= t('destinations') ?></a>
        <a href="cultura.php"><?= t('living_culture') ?></a>
      </div>
      <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
        <h5><?= t('resources') ?></h5>
        <a href="gastronomia.php"><?= t('gastronomy') ?></a>
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