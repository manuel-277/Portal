<?php
include 'configuracoes.php';

// Redireciona se NÃO estiver logado
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('my_dashboard') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('dashboard_desc') ?>">

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
            background: linear-gradient(135deg, #fff8e1 0%, #f1f5f9 100%);
        }
        [data-theme="dark"] body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
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

        .hero-dashboard {
            background: linear-gradient(rgba(0, 30, 25, 0.7), rgba(0, 30, 25, 0.7)), 
                        url('assets/img/salinas-mussulo.jpg'); /* Use sua imagem aqui */
            background-size: cover;
            background-position: center;
            height: 40vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 2.5rem;
            border-radius: 0 0 20px 20px;
        }
        .hero-dashboard h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 2.4rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .card-exclusive {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            background: white;
        }
        [data-theme="dark"] .card-exclusive {
            background: #1e293b;
            color: #e2e8f0;
        }
        .card-exclusive:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .card-body {
            padding: 1.8rem;
        }
        .badge-exclusive {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
        }

        .btn-exclusive {
            background: var(--secondary);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            transition: all 0.25s;
        }
        .btn-exclusive:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        footer {
            background: var(--primary);
            color: white;
            padding: 2rem 0 1rem;
            margin-top: 3rem;
        }
        footer a { color: #cbd5e1; text-decoration: none; }
        footer a:hover { color: white; }

        @media (max-width: 768px) {
            .hero-dashboard { height: 30vh; }
            .hero-dashboard h1 { font-size: 1.8rem; }
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
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3"><?= t('welcome') ?>, <?= esc($user_name) ?>!</span>
            <a href="logout.php" class="btn btn-sm" style="background: var(--accent); color: var(--primary); font-weight: 600;">
                <i class="fas fa-sign-out-alt me-1"></i> <?= t('logout') ?>
            </a>
        </div>
    </div>
</nav>

<section class="hero-dashboard">
    <div class="container">
        <h1><?= t('welcome_dashboard') ?></h1>
        <p class="lead"><?= t('dashboard_welcome_msg') ?></p>
    </div>
</section>

<div class="container">
    <div class="row g-4">
        <!-- Benefício 1: Pacotes Exclusivos -->
        <div class="col-md-6 col-lg-4">
            <div class="card-exclusive">
                <div class="card-body">
                    <span class="badge-exclusive"><?= t('exclusive') ?></span>
                    <h5 class="mt-3 mb-3"><?= t('exclusive_packages') ?></h5>
                    <p><?= t('packages_benefit') ?></p>
                    <a href="pacotes-exclusivos.php" class="btn-exclusive"><?= t('view_packages') ?></a>
                </div>
            </div>
        </div>

        <!-- Benefício 2: Reservas Prioritárias -->
        <div class="col-md-6 col-lg-4">
            <div class="card-exclusive">
                <div class="card-body">
                    <span class="badge-exclusive"><?= t('priority') ?></span>
                    <h5 class="mt-3 mb-3"><?= t('priority_booking') ?></h5>
                    <p><?= t('booking_benefit') ?></p>
                    <a href="reservas.php" class="btn-exclusive"><?= t('make_reservation') ?></a>
                </div>
            </div>
        </div>

        <!-- Benefício 3: Minhas Estrelas -->
        <div class="col-md-6 col-lg-4">
            <div class="card-exclusive">
                <div class="card-body">
                    <span class="badge-exclusive"><?= t('personalized') ?></span>
                    <h5 class="mt-3 mb-3"><?= t('my_stars') ?></h5>
                    <p><?= t('stars_benefit') ?></p>
                    <a href="minhas-estrelas.php" class="btn-exclusive"><?= t('view_favorites') ?></a>
                </div>
            </div>
        </div>

        <!-- Benefício 4: Notícias Antecipadas -->
        <div class="col-md-6 col-lg-4">
            <div class="card-exclusive">
                <div class="card-body">
                    <span class="badge-exclusive"><?= t('early_access') ?></span>
                    <h5 class="mt-3 mb-3"><?= t('news_early') ?></h5>
                    <p><?= t('news_benefit') ?></p>
                    <a href="noticias-exclusivas.php" class="btn-exclusive"><?= t('read_news') ?></a>
                </div>
            </div>
        </div>

        <!-- Benefício 5: Suporte Personalizado -->
        <div class="col-md-6 col-lg-4">
            <div class="card-exclusive">
                <div class="card-body">
                    <span class="badge-exclusive"><?= t('vip_support') ?></span>
                    <h5 class="mt-3 mb-3"><?= t('personal_support') ?></h5>
                    <p><?= t('support_benefit') ?></p>
                    <a href="contato.php?tipo=vip" class="btn-exclusive"><?= t('contact_support') ?></a>
                </div>
            </div>
        </div>

        <!-- Benefício 6: Mapa Interativo (opcional) -->
        <div class="col-md-6 col-lg-4">
            <div class="card-exclusive">
                <div class="card-body">
                    <span class="badge-exclusive"><?= t('interactive') ?></span>
                    <h5 class="mt-3 mb-3"><?= t('interactive_map') ?></h5>
                    <p><?= t('map_benefit') ?></p>
                    <a href="mapa-interativo.php" class="btn-exclusive"><?= t('explore_map') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="index.php" class="btn btn-outline-secondary px-4 py-2"><?= t('back_to_home') ?></a>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p>&copy; <?= date('Y') ?> Portal de Turismo de Angola. <?= t('all_rights_reserved') ?>.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Aplica tema salvo
    document.documentElement.setAttribute('data-theme', '<?= esc($user_theme) ?>');
</script>

</body>
</html>