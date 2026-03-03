<?php
include 'configuracoes.php'; // ← carrega $pdo, sessão, tema, idioma

// ←←← ADICIONE AS FUNÇÕES AQUI →→→
if (!function_exists('verificarVoto')) {
    function verificarVoto($pontoId, $usuarioId, $pdo) {
        if (!$usuarioId) return false;
        $stmt = $pdo->prepare("SELECT 1 FROM votos WHERE usuario_id = ? AND ponto_turistico_id = ?");
        $stmt->execute([$usuarioId, $pontoId]);
        return $stmt->rowCount() > 0;
    }
}
if (!function_exists('getTotalCurtidas')) {
    function getTotalCurtidas($pontoId, $pdo) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE ponto_turistico_id = ?");
        $stmt->execute([$pontoId]);
        return (int) $stmt->fetchColumn();
    }
}
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('home') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('home') ?> - Descubra a riqueza natural, cultural e histórica de Angola. Guia oficial de destinos, experiências e património.">
    
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        :root {
            --primary: #004d40;
            --secondary: #159f5f;
            --accent: #f59e0b;
            --light: #f8fafc;
            --dark: #0f172a;
        }

        /* Tema Claro (padrão) */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1e293b;
            scroll-behavior: smooth;
        }

        /* Tema Escuro */
        [data-theme="dark"] body {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        [data-theme="dark"] .info-card,
        [data-theme="dark"] .destination-card,
        [data-theme="dark"] .stats-section,
        [data-theme="dark"] footer,
        [data-theme="dark"] .quote-section {
            background: #1e293b !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .card-title,
        [data-theme="dark"] h4,
        [data-theme="dark"] .section-title {
            color: #a7f3d0 !important;
        }
        [data-theme="dark"] .badge-custom {
            background: #0c4a35 !important;
            color: #6ee7b7 !important;
        }
        [data-theme="dark"] .lang-switcher,
        [data-theme="dark"] .user-info {
            background: rgba(255,255,255,0.1) !important;
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] .navbar {
            background: #003d33 !important;
        }
        [data-theme="dark"] .nav-link {
            color: rgba(255,255,255,0.9) !important;
        }
        [data-theme="dark"] .toast {
            background: #0f172a;
            color: #fff;
        }
        [data-theme="dark"] .dropdown-menu {
            background: #1e293b;
            border: 1px solid #334155;
        }
        [data-theme="dark"] .dropdown-item {
            color: #e2e8f0;
        }
        [data-theme="dark"] .dropdown-item:hover {
            background: var(--secondary);
            color: white;
        }

        /* Estilos Comuns */
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
            object-fit: cover;
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

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
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
            padding: 0.5rem 0;
        }
        .dropdown-item { padding: 0.5rem 1rem; color: var(--dark); font-weight: 500; }
        .dropdown-item:hover { background: var(--secondary); color: white; }
        .dropdown-header { font-weight: 600; color: var(--primary); padding: 0.5rem 1rem; }

        .video-section {
            width: 100%;
            height: 500px;
            position: relative;
            overflow: hidden;
            margin-bottom: 3rem;
        }
        .video-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 30, 25, 0.65);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            color: white;
            padding: 1.5rem;
        }
        .video-content {000000000000000000text-align: center; }
        .video-content h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.4);
        }
        .video-content p {
            font-size: 1.25rem;
            opacity: 0.95;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
        }

        .destination-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: white;
        }
        .destination-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .card-img-top { height: 200px; object-fit: cover; transition: transform 0.5s; }
        .destination-card:hover .card-img-top { transform: scale(1.05); }
        .card-body { padding: 1.5rem; flex-grow: 1; }
        .card-title { color: var(--primary); margin-bottom: 0.8rem; font-size: 1.35rem; font-weight: 700; }
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
        .price { font-weight: 700; color: var(--primary); }
        .card-actions {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }
        .like-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #cbd5e1;
            transition: all 0.25s;
            padding: 0.3rem;
            border-radius: 8px;
        }
        .like-btn:hover:not(.liked) { background: #f1f5f9; color: #94a3b8; }
        .like-btn.liked { color: var(--accent); transform: scale(1.1); }
        .likes-count {
            background: #f0fdf4;
            color: var(--secondary);
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.8rem;
            margin: 3rem 0 2rem;
            text-align: center;
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
        .section-subtitle {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            color: #475569;
            font-size: 1.1rem;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 1.8rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .info-card h4 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-family: 'Montserrat', sans-serif;
        }

        footer {
            background: var(--primary);
            color: white;
            padding: 3rem 0 2rem;
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
        footer a:hover { color: white; }
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            margin: 0 8px;
            color: white;
            font-size: 1.2rem;
            line-height: 40px;
            text-align: center;
            transition: all 0.3s;
        }
        .social-icons a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        .toast { border-radius: 10px; box-shadow: 0 6px 18px rgba(0,0,0,0.2); }

        .btn-outline-modern,
        .btn-primary-modern {
            padding: 0.4rem 1rem;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-outline-modern {
            color: var(--secondary);
            border-color: var(--secondary);
        }
        .btn-outline-modern:hover {
            background: var(--secondary);
            color: white;
        }
        .btn-primary-modern {
            background: var(--secondary);
            border-color: var(--secondary);
        }
        .btn-primary-modern:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .quote-section {
            background: linear-gradient(to right, var(--primary), #003d33);
            color: white;
            padding: 4rem 0;
            margin: 3rem 0;
            border-radius: 16px;
            text-align: center;
        }
        .quote {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-style: italic;
            max-width: 900px;
            margin: 0 auto 1.5rem;
            line-height: 1.4;
        }
        .quote-author { font-size: 1.2rem; opacity: 0.9; }

        .why-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 3px solid white;
        }
        .why-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .lang-switcher {
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 0.2rem;
            display: inline-flex;
        }
        .lang-btn {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.9);
            padding: 0.3rem 0.8rem;
            border-radius: 18px;
            cursor: pointer;
            font-weight: 600;
        }
        .lang-btn.active, .lang-btn:hover {
            background: var(--accent);
            color: var(--primary);
        }

        #angola-map {
            width: 100%;
            height: 400px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            margin: 1.5rem 0 3rem;
        }

        img, video { max-width: 100%; height: auto; }

        @media (max-width: 576px) {
            .navbar-brand span { font-size: 1rem; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .navbar-brand img { height: 34px; }
            .video-section { height: 350px; }
            .video-content h2 { font-size: 1.8rem; }
            .video-content p { font-size: 1rem; }
            #angola-map { height: 300px; }
            .user-avatar { width: 32px; height: 32px; }
        }
    </style>
</head>
<body>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <span class="lang-pt">Adicionado às suas estrelas!</span>
                <span class="lang-en d-none">Added to your stars!</span>
                <span class="lang-fr d-none">Ajouté à vos étoiles !</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Modal de Detalhes -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= t('cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
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
                <li class="nav-item"><a class="nav-link active" href="index.php"><?= t('home') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="destinos.php"><?= t('destinations') ?></a></li>
                
              
                <!-- Troca de Idioma -->
                <li class="nav-item ms-2">
                    <div class="lang-switcher">
                        <button class="lang-btn <?= $user_lang === 'pt' ? 'active' : '' ?>" data-lang="pt">PT</button>
                        <button class="lang-btn <?= $user_lang === 'en' ? 'active' : '' ?>" data-lang="en">EN</button>
                        <button class="lang-btn <?= $user_lang === 'fr' ? 'active' : '' ?>" data-lang="fr">FR</button>
                    </div>
                </li>

                <!-- Ícone de Tema -->
                <li class="nav-item ms-2">
                    <button class="btn" style="color: white;" onclick="toggleTheme()">
                        <i class="fas fa-moon" id="theme-icon"></i>
                    </button>
                </li>

                <!-- Perfil ou Login -->
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <?php if ($user_avatar): ?>
                                    <img src="<?= esc($user_avatar) ?>" alt="Avatar">
                                <?php else: ?>
                                    <?= strtoupper(substr($user_name, 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><span class="dropdown-header"><?= esc($user_name) ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="perfil.php"><i class="fas fa-user me-2"></i> <?= t('profile') ?></a></li>
                            <li><a class="dropdown-item" href="minhas-estrelas.php"><i class="fas fa-star me-2"></i> <?= t('my_stars') ?></a></li>
                            <li><a class="dropdown-item" href="configuracoes.php"><i class="fas fa-cog me-2"></i> <?= t('settings') ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> <?= t('logout') ?></a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link ms-2" href="login.php" style="color: var(--accent);"><?= t('login') ?></a></li>
                    <li class="nav-item"><a class="nav-link ms-2" href="cadastro.php" style="color:var(--accent);"><?= t('cadastro') ?></a></li>
                  
                    <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Vídeo Promocional -->
<section class="video-section">
    <div class="video-wrapper">
        <video autoplay muted loop playsinline poster="assets/img/turismo-video-thumb.jpg" class="video-bg">
            <source src="video/angola.mp4" type="video/mp4">
            Seu navegador não suporta vídeos HTML5.
        </video>
        <div class="video-overlay">
            <div class="container">
                <div class="video-content">
                    <h2 class="lang-pt">Descubra a Beleza de Angola</h2>
                    <h2 class="lang-en d-none">Discover the Beauty of Angola</h2>
                    <h2 class="lang-fr d-none">Découvrez la Beauté de l’Angola</h2>
                    
                    <p class="lang-pt">Do deserto do Namibe às cataratas de Kalandula — uma jornada inesquecível.</p>
                    <p class="lang-en d-none">From the Namib Desert to Kalandula Falls — an unforgettable journey.</p>
                    <p class="lang-fr d-none">Du désert du Namib aux chutes de Kalandula — un voyage inoubliable.</p>
                    
                    <a href="destinos.php" class="btn btn-light btn-lg px-4 py-2 lang-pt">Explore Agora</a>
                    <a href="destinos.php" class="btn btn-light btn-lg px-4 py-2 lang-en d-none">Explore Now</a>
                    <a href="destinos.php" class="btn btn-light btn-lg px-4 py-2 lang-fr d-none">Explorer Maintenant</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Em Números -->
<section class="container py-5">
    <h2 class="section-title lang-pt">Angola em Números</h2>
    <h2 class="section-title lang-en d-none">Angola by Numbers</h2>
    <h2 class="section-title lang-fr d-none">L’Angola en Chiffres</h2>
    
    <p class="section-subtitle lang-pt">Dados que revelam a riqueza geográfica, cultural e natural do nosso país.</p>
    <p class="section-subtitle lang-en d-none">Facts that reveal the geographical, cultural, and natural richness of our country.</p>
    <p class="section-subtitle lang-fr d-none">Chiffres qui révèlent la richesse géographique, culturelle et naturelle de notre pays.</p>
    
    <div class="row g-4">
        <div class="col-6 col-md-3">
            <div class="info-card text-center h-100">
                <div class="icon mb-3"><i class="fas fa-map-marked-alt" style="font-size: 2.4rem; color: var(--secondary);"></i></div>
                <div class="stat-number" style="font-size: 2rem; font-weight: 800; color: var(--primary);">21</div>
                <div class="stat-label lang-pt">Províncias</div>
                <div class="stat-label lang-en d-none">Provinces</div>
                <div class="stat-label lang-fr d-none">Provinces</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card text-center h-100">
                <div class="icon mb-3"><i class="fas fa-water" style="font-size: 2.4rem; color: var(--secondary);"></i></div>
                <div class="stat-number" style="font-size: 2rem; font-weight: 800; color: var(--primary);">1246</div>
                <div class="stat-label lang-pt">km de Costa</div>
                <div class="stat-label lang-en d-none">km of Coastline</div>
                <div class="stat-label lang-fr d-none">km de Côte</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card text-center h-100">
                <div class="icon mb-3"><i class="fas fa-tree" style="font-size: 2.4rem; color: var(--secondary);"></i></div>
                <div class="stat-number" style="font-size: 2rem; font-weight: 800; color: var(--primary);">24</div>
                <div class="stat-label lang-pt">Parques Nacionais</div>
                <div class="stat-label lang-en d-none">National Parks</div>
                <div class="stat-label lang-fr d-none">Parcs Nationaux</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card text-center h-100">
                <div class="icon mb-3"><i class="fas fa-users" style="font-size: 2.4rem; color: var(--secondary);"></i></div>
                <div class="stat-number" style="font-size: 2rem; font-weight: 800; color: var(--primary);">40+</div>
                <div class="stat-label lang-pt">Etnias</div>
                <div class="stat-label lang-en d-none">Ethnic Groups</div>
                <div class="stat-label lang-fr d-none">Groupes Ethniques</div>
            </div>
        </div>
    </div>
</section>

<!-- Destinos em Destaque -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title lang-pt">Destinos Imperdíveis em Angola</h2>
        <h2 class="section-title lang-en d-none">Must-Visit Destinations in Angola</h2>
        <h2 class="section-title lang-fr d-none">Destinations Incontournables en Angola</h2>
        
        <p class="section-subtitle lang-pt">Explore os tesouros naturais e culturais que fazem de Angola um destino único no mundo.</p>
        <p class="section-subtitle lang-en d-none">Explore the natural and cultural treasures that make Angola a unique destination in the world.</p>
        <p class="section-subtitle lang-fr d-none">Explorez les trésors naturels et culturels qui font de l’Angola une destination unique au monde.</p>
        
        <div class="row g-4">
            <?php
            $destinos = [
                'kalandula' => [
                    'nome' => ['pt' => 'Quedas de Kalandula', 'en' => 'Kalandula Falls', 'fr' => 'Chutes de Kalandula'],
                    'local' => 'Malanje',
                    'tipo' => ['pt' => 'Natureza • Aventura', 'en' => 'Nature • Adventure', 'fr' => 'Nature • Aventure'],
                    'preco' => 'Gratis',
                    'img' => 'assets/Queda.jpg',
                    'descricao_curta' => [
                        'pt' => 'Uma das maiores cataratas da África, símbolo natural de Angola.',
                        'en' => 'One of Africa\'s largest waterfalls, a natural symbol of Angola.',
                        'fr' => 'L’une des plus grandes cascades d’Afrique, symbole naturel de l’Angola.'
                    ],
                    'descricao_longa' => [
                        'pt' => '<p>As Quedas de Kalandula, localizadas na província de Malanje, têm cerca de 410 metros de largura e 105 metros de altura. São as segundas maiores de África em volume de água. A melhor época para visitar é entre abril e setembro, após a estação chuvosa.</p><p><strong>Dicas:</strong> Leve calçado antiderrapante, protetor solar e água. Guias locais disponíveis no local.</p>',
                        'en' => '<p>Kalandula Falls, located in Malanje Province, span about 410 meters wide and 105 meters high. They are Africa’s second-largest by volume. Best visited between April and September, after the rainy season.</p><p><strong>Tips:</strong> Wear non-slip shoes, sunscreen, and bring water. Local guides available on-site.</p>',
                        'fr' => '<p>Les chutes de Kalandula, situées dans la province de Malanje, mesurent environ 410 mètres de large et 105 mètres de haut. Ce sont les deuxièmes plus grandes d’Afrique en volume d’eau. À visiter entre avril et septembre, après la saison des pluies.</p><p><strong>Conseils :</strong> Portez des chaussures antidérapantes, de la crème solaire et de l’eau. Des guides locaux sont disponibles sur place.</p>'
                    ],
                    'coords' => [-9.3333, 15.3333]
                ],
                // ... (os destinos)
                'lua' => [
                    'nome' => ['pt' => 'Miradouro da Lua', 'en' => 'Moon Viewpoint', 'fr' => 'Belvédère de la Lune'],
                    'local' => 'Luanda',
                    'tipo' => ['pt' => 'Natureza • Fotografia', 'en' => 'Nature • Photography', 'fr' => 'Nature • Photographie'],
                    'preco' => 'Gratis',
                    'img' => 'assets/Miradouro_lua.jpg',
                    'descricao_curta' => [
                        'pt' => 'Formações geológicas que lembram paisagens lunares.',
                        'en' => 'Geological formations resembling lunar landscapes.',
                        'fr' => 'Formations géologiques rappelant des paysages lunaires.'
                    ],
                    'descricao_longa' => [
                        'pt' => '<p>O Miradouro da Lua fica a cerca de 40 km de Luanda. Suas formações erosionadas pelo vento e pela chuva criam um cenário surreal. Melhor horário: pôr do sol, quando a luz dourada realça as texturas.</p><p><strong>Acesso:</strong> Estrada asfaltada até o estacionamento. Entrada controlada por segurança.</p>',
                        'en' => '<p>The Moon Viewpoint is located about 40 km from Luanda. Wind and rain erosion have sculpted surreal landscapes. Best time: sunset, when golden light enhances textures.</p><p><strong>Access:</strong> Paved road to parking. Entrance monitored by security.</p>',
                        'fr' => '<p>Le Belvédère de la Lune se trouve à environ 40 km de Luanda. L’érosion du vent et de la pluie a sculpté des paysages surréalistes. Meilleur moment : coucher de soleil, quand la lumière dorée met en valeur les textures.</p><p><strong>Accès :</strong> Route goudronnée jusqu’au parking. Entrée surveillée par la sécurité.</p>'
                    ],
                    'coords' => [-8.8369, 13.2343]
                ],
                'tundavala' => [
                    'nome' => ['pt' => 'Tundavala', 'en' => 'Tundavala', 'fr' => 'Tundavala'],
                    'local' => 'Huíla',
                    'tipo' => ['pt' => 'Natureza • Aventura', 'en' => 'Nature • Adventure', 'fr' => 'Nature • Aventure'],
                    'preco' => 'Gratis',
                    'img' => 'assets/Tundavala.jpg',
                    'descricao_curta' => [
                        'pt' => 'Desfiladeiro imponente próximo ao Lubango.',
                        'en' => 'Imposing cliff near Lubango.',
                        'fr' => 'Falaise imposante près de Lubango.'
                    ],
                    'descricao_longa' => [
                        'pt' => '<p>Tundavala é um desfiladeiro com mais de 1.000 metros de altura, oferecendo uma das vistas mais espetaculares de Angola. Localizado na Serra da Leba, é perfeito para trekking e fotografia aérea.</p><p><strong>Clima:</strong> Fresco o ano todo. Leve casaco leve.</p>',
                        'en' => '<p>Tundavala is a cliff over 1,000 meters high, offering one of Angola’s most spectacular views. Located in Serra da Leba, it’s perfect for trekking and aerial photography.</p><p><strong>Climate:</strong> Cool year-round. Bring a light jacket.</p>',
                        'fr' => '<p>Tundavala est une falaise de plus de 1 000 mètres de haut, offrant l’une des vues les plus spectaculaires d’Angola. Située dans la Serra da Leba, elle est parfaite pour la randonnée et la photographie aérienne.</p><p><strong>Climat :</strong> Frais toute l’année. Apportez une veste légère.</p>'
                    ],
                    'coords' => [-14.8167, 13.4833]
                ],
                'baia_azul' => [
                    'nome' => ['pt' => 'Baía Azul', 'en' => 'Blue Bay', 'fr' => 'Baie Bleue'],
                    'local' => 'Benguela',
                    'tipo' => ['pt' => 'Praia • Relax', 'en' => 'Beach • Relax', 'fr' => 'Plage • Détente'],
                    'preco' => 'Gratis',
                    'img' => 'assets/baia_azul.jpg',
                    'descricao_curta' => [
                        'pt' => 'Praia famosa de Benguela, águas calmas e cenário perfeito para famílias.',
                        'en' => 'Famous beach in Benguela, calm waters, perfect for families.',
                        'fr' => 'Plage célèbre de Benguela, eaux calmes, idéale pour les familles.'
                    ],
                    'descricao_longa' => [
                        'pt' => '<p>A Baía Azul é uma das praias mais tranquilas de Benguela, ideal para banhos e piqueniques. Possui infraestrutura básica: bares, estacionamento e segurança.</p><p><strong>Atividades:</strong> Caiaque, passeios de barco e observação de golfinhos.</p>',
                        'en' => '<p>Blue Bay is one of Benguela’s calmest beaches, ideal for swimming and picnics. Basic amenities: bars, parking, and security.</p><p><strong>Activities:</strong> Kayaking, boat tours, and dolphin watching.</p>',
                        'fr' => '<p>La Baie Bleue est l’une des plages les plus calmes de Benguela, idéale pour la baignade et les pique-niques. Infrastructures de base : bars, parking et sécurité.</p><p><strong>Activités :</strong> Kayak, excursions en bateau et observation de dauphins.</p>'
                    ],
                    'coords' => [-12.5769, 13.4047]
                ],
                'namibe' => [
                    'nome' => ['pt' => 'Deserto do Namibe', 'en' => 'Namib Desert', 'fr' => 'Désert du Namib'],
                    'local' => 'Namibe',
                    'tipo' => ['pt' => 'Deserto • Aventura', 'en' => 'Desert • Adventure', 'fr' => 'Désert • Aventure'],
                    'preco' => 'Gratis',
                    'img' => 'assets/namibe.jpg',
                    'descricao_curta' => [
                        'pt' => 'O único deserto costeiro da África, com falésias dramáticas.',
                        'en' => 'Africa’s only coastal desert, with dramatic cliffs.',
                        'fr' => 'Le seul désert côtier d’Afrique, avec des falaises spectaculaires.'
                    ],
                    'descricao_longa' => [
                        'pt' => '<p>O Deserto do Namibe é um dos mais antigos do mundo, com mais de 80 milhões de anos. Seu encontro com o Oceano Atlântico cria paisagens únicas. Fauna adaptada: elefantes do deserto, chitas e pássaros endêmicos.</p><p><strong>Recomendação:</strong> Visite com operadora turística credenciada.</p>',
                        'en' => '<p>The Namib Desert is one of the world’s oldest, over 80 million years. Its meeting with the Atlantic Ocean creates unique landscapes. Adapted wildlife: desert elephants, cheetahs, and endemic birds.</p><p><strong>Recommendation:</strong> Visit with a licensed tour operator.</p>',
                        'fr' => '<p>Le désert du Namib est l’un des plus anciens du monde, âgé de plus de 80 millions d’années. Sa jonction avec l’océan Atlantique crée des paysages uniques. Faune adaptée : éléphants du désert, guépards et oiseaux endémiques.</p><p><strong>Recommandation :</strong> Visitez avec un opérateur touristique agréé.</p>'
                    ],
                    'coords' => [-15.2083, 12.1528]
                ],
                'kissama' => [
                    'nome' => ['pt' => 'Parque Nacional da Kissama', 'en' => 'Kissama National Park', 'fr' => 'Parc National de Kissama'],
                    'local' => 'Benguela/Luanda',
                    'tipo' => ['pt' => 'Safári • Vida Selvagem', 'en' => 'Safari • Wildlife', 'fr' => 'Safari • Faune'],
                    'preco' => 'Gratis',
                    'img' => 'assets/kissama.jpg',
                    'descricao_curta' => [
                        'pt' => 'Refúgio de elefantes, girafas, antílopes e leões reintroduzidos.',
                        'en' => 'Home to reintroduced elephants, giraffes, antelopes, and lions.',
                        'fr' => 'Refuge pour éléphants, girafes, antilopes et lions réintroduits.'
                    ],
                    'descricao_longa' => [
                        'pt' => '<p>O Parque Nacional da Kissama é resultado do projeto "Operation Noah", que reintroduziu espécies após a guerra civil. Safáris guiados partem de Luanda ou do Lubango. Duração: meio-dia a dia inteiro.</p><p><strong>Reserva obrigatória:</strong> Contate operadoras locais com antecedência.</p>',
                        'en' => '<p>Kissama National Park is the result of "Operation Noah", which reintroduced wildlife after the civil war. Guided safaris depart from Luanda or Lubango. Duration: half-day to full-day.</p><p><strong>Booking required:</strong> Contact local operators in advance.</p>',
                        'fr' => '<p>Le parc national de Kissama est le fruit de l’« Opération Noé », qui a réintroduit la faune après la guerre civile. Safaris guidés au départ de Luanda ou Lubango. Durée : demi-journée à journée complète.</p><p><strong>Réservation obligatoire :</strong> Contactez des opérateurs locaux à l’avance.</p>'
                    ],
                    'coords' => [-9.6667, 13.3333]
                ]
            ];

            foreach ($destinos as $id => $d):
                $ja_votou = verificarVoto($id, $usuario_id, $pdo);
                $total = getTotalCurtidas($id, $pdo);
            ?>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="destination-card">
                    <img src="<?= esc($d['img']) ?>" class="card-img-top" alt="<?= esc($d['nome']['pt']) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($d['nome']['pt']) ?></h5>
                        <div class="mb-2">
                            <span class="badge-custom"><?= esc($d['local']) ?></span>
                            <span class="badge-custom"><?= esc($d['tipo']['pt']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rating"></div>
                            <span class="price"><?= esc($d['preco']) ?></span>
                        </div>
                        <p class="card-text flex-grow-1"><?= esc($d['descricao_curta']['pt']) ?></p>
                        <div class="card-actions">
                            <button class="btn btn-outline-modern btn-sm" onclick="showDetails('<?= addslashes($id) ?>')">
                                <i class="fas fa-info-circle me-1"></i>
                                <span class="lang-pt">Detalhes</span>
                                <span class="lang-en d-none">Details</span>
                                <span class="lang-fr d-none">Détails</span>
                            </button>
                            <div class="d-flex align-items-center gap-2">
                                <?php if (isLoggedIn()): ?>
                                    <button class="like-btn <?= $ja_votou ? 'liked' : '' ?>"
                                        data-id="<?= $id ?>"
                                        onclick="likePoint(this)"
                                        <?= $ja_votou ? 'disabled' : '' ?>>
                                        <i class="fas fa-star"></i>
                                    </button>
                                    <span class="likes-count">
                                        <i class="fas fa-star"></i>
                                        <span><?= $total ?></span>
                                    </span>
                                <?php else: ?>
                                    <button class="btn btn-primary-modern btn-sm" onclick="showLoginAlert()">
                                        <i class="fas fa-star me-1"></i>
                                        <span class="lang-pt">Estrela</span>
                                        <span class="lang-en d-none">Star</span>
                                        <span class="lang-fr d-none">Étoile</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="destinos.php" class="btn btn-primary-modern px-4 py-2">
                <span class="lang-pt">Ver Todos os Destinos</span>
                <span class="lang-en d-none">View All Destinations</span>
                <span class="lang-fr d-none">Voir Toutes les Destinations</span>
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
<!-- Por que visitar Angola -->

<section class="container py-5">
    <h2 class="section-title lang-pt">Por que Visitar Angola?</h2>
    <h2 class="section-title lang-en d-none">Why Visit Angola?</h2>
    <h2 class="section-title lang-fr d-none">Pourquoi Visiter l’Angola ?</h2>
    
    <div class="row g-4 text-center">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="why-card">
                <div class="why-image"><img src="assets/img/why/biodiversidade.jpg" alt="Biodiversidade"></div>
                <h4 class="lang-pt">Biodiversidade</h4>
                <h4 class="lang-en d-none">Biodiversity</h4>
                <h4 class="lang-fr d-none">Biodiversité</h4>
                <p class="lang-pt">Palanca negra, elefantes e aves endémicas.</p>
                <p class="lang-en d-none">Giant sable antelope, elephants, and endemic birds.</p>
                <p class="lang-fr d-none">Palanche noire, éléphants et oiseaux endémiques.</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="why-card">
                <div class="why-image"><img src="assets/img/why/cultura.jpg" alt="Cultura"></div>
                <h4 class="lang-pt">Cultura Viva</h4>
                <h4 class="lang-en d-none">Living Culture</h4>
                <h4 class="lang-fr d-none">Culture Vivante</h4>
                <p class="lang-pt">Semba, kizomba, artesanato e festivais.</p>
                <p class="lang-en d-none">Semba, kizomba, crafts, and festivals.</p>
                <p class="lang-fr d-none">Semba, kizomba, artisanat et festivals.</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="why-card">
                <div class="why-image"><img src="assets/img/why/gastronomia.jpg" alt="Gastronomia"></div>
                <h4 class="lang-pt">Gastronomia</h4>
                <h4 class="lang-en d-none">Cuisine</h4>
                <h4 class="lang-fr d-none">Gastronomie</h4>
                <p class="lang-pt">Funge com muamba, calulu e mufete.</p>
                <p class="lang-en d-none">Funge with muamba, calulu, and mufete.</p>
                <p class="lang-fr d-none">Funge avec muamba, calulu et mufete.</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="why-card">
                <div class="why-image"><img src="assets/img/why/clima.jpg" alt="Clima"></div>
                <h4 class="lang-pt">Clima Ideal</h4>
                <h4 class="lang-en d-none">Perfect Climate</h4>
                <h4 class="lang-fr d-none">Climat Idéal</h4>
                <p class="lang-pt">Maio a Setembro: estação seca perfeita.</p>
                <p class="lang-en d-none">May to September: perfect dry season.</p>
                <p class="lang-fr d-none">Mai à septembre : saison sèche parfaite.</p>
            </div>
        </div>
    </div>
</section>

<!-- Informações Práticas com Imagens -->
<section class="container mt-5">
    <h2 class="section-title lang-pt">Viaje com Segurança e Conforto</h2>
    <h2 class="section-title lang-en d-none">Travel Safely and Comfortably</h2>
    <h2 class="section-title lang-fr d-none">Voyagez en Toute Sécurité et Confort</h2>
    
    <p class="section-subtitle text-center mb-4 lang-pt">Tudo o que você precisa saber antes de embarcar na sua aventura angolana.</p>
    <p class="section-subtitle text-center mb-4 lang-en d-none">Everything you need to know before embarking on your Angolan adventure.</p>
    <p class="section-subtitle text-center mb-4 lang-fr d-none">Tout ce que vous devez savoir avant de partir à l’aventure en Angola.</p>
    
    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="info-card h-100 d-flex flex-column">
                <div style="height: 120px; overflow: hidden; border-radius: 12px 12px 0 0; margin: -1.8rem -1.8rem 1rem -1.8rem;">
                    <img src="assets/visto.jpg" 
                         alt="Passaporte e visto" class="w-100 h-100" style="object-fit: cover;">
                </div>
                <h4 class="d-flex align-items-center"><i class="fas fa-passport me-2 text-primary"></i> <span class="lang-pt">Visto</span><span class="lang-en d-none">Visa</span><span class="lang-fr d-none">Visa</span></h4>
                <p class="flex-grow-1 lang-pt">Cidadãos de muitos países precisam de visto. Solicite com antecedência através do consulado angolano.</p>
                <p class="flex-grow-1 lang-en d-none">Citizens of many countries require a visa. Apply in advance through the Angolan consulate.</p>
                <p class="flex-grow-1 lang-fr d-none">Les ressortissants de nombreux pays ont besoin d’un visa. Demandez-le à l’avance auprès du consulat angolais.</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="info-card h-100 d-flex flex-column">
                <div style="height: 120px; overflow: hidden; border-radius: 12px 12px 0 0; margin: -1.8rem -1.8rem 1rem -1.8rem;">
                    <img src="assets/clima.jpg" 
                         alt="Clima ensolarado em Angola" class="w-100 h-100" style="object-fit: cover;">
                </div>
                <h4 class="d-flex align-items-center"><i class="fas fa-sun me-2 text-warning"></i> <span class="lang-pt">Clima</span><span class="lang-en d-none">Climate</span><span class="lang-fr d-none">Climat</span></h4>
                <p class="flex-grow-1 lang-pt">Angola tem clima tropical. A melhor época para visitar é de maio a setembro (estação seca).</p>
                <p class="flex-grow-1 lang-en d-none">Angola has a tropical climate. The best time to visit is from May to September (dry season).</p>
                <p class="flex-grow-1 lang-fr d-none">L’Angola a un climat tropical. La meilleure période pour visiter est de mai à septembre (saison sèche).</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="info-card h-100 d-flex flex-column">
                <div style="height: 120px; overflow: hidden; border-radius: 12px 12px 0 0; margin: -1.8rem -1.8rem 1rem -1.8rem;">
                    <img src="assets/moeda.jpg" 
                         alt="Moedas e cartão de crédito" class="w-100 h-100" style="object-fit: cover;">
                </div>
                <h4 class="d-flex align-items-center"><i class="fas fa-money-bill-wave me-2 text-success"></i> <span class="lang-pt">Moeda</span><span class="lang-en d-none">Currency</span><span class="lang-fr d-none">Monnaie</span></h4>
                <p class="flex-grow-1 lang-pt">A moeda oficial é o <strong>Kwanza angolano (AOA)</strong>. Cartões são aceitos nas cidades, mas leve dinheiro para áreas rurais.</p>
                <p class="flex-grow-1 lang-en d-none">The official currency is the <strong>Angolan Kwanza (AOA)</strong>. Cards are accepted in cities, but carry cash for rural areas.</p>
                <p class="flex-grow-1 lang-fr d-none">La monnaie officielle est le <strong>Kwanza angolais (AOA)</strong>. Les cartes sont acceptées en ville, mais emportez du liquide pour les zones rurales.</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="info-card h-100 d-flex flex-column">
                <div style="height: 120px; overflow: hidden; border-radius: 12px 12px 0 0; margin: -1.8rem -1.8rem 1rem -1.8rem;">
                    <img src="assets/segurança.jpg" 
                         alt="Segurança em viagem" class="w-100 h-100" style="object-fit: cover;">
                </div>
                <h4 class="d-flex align-items-center"><i class="fas fa-shield-alt me-2 text-info"></i> <span class="lang-pt">Segurança</span><span class="lang-en d-none">Safety</span><span class="lang-fr d-none">Sécurité</span></h4>
                <p class="flex-grow-1 lang-pt">Angola é segura para turistas. Evite zonas remotas sem guia e siga as orientações locais.</p>
                <p class="flex-grow-1 lang-en d-none">Angola is safe for tourists. Avoid remote areas without a guide and follow local advice.</p>
                <p class="flex-grow-1 lang-fr d-none">L’Angola est sûre pour les touristes. Évitez les zones reculées sans guide et suivez les conseils locaux.</p>
            </div>
        </div>
    </div>
</section>

<!-- CONTEÚDO EXCLUSIVO PARA USUÁRIOS LOGADOS -->
<?php if (isLoggedIn()): ?>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title"><?= t('exclusive_for_members') ?> <span class="exclusive-badge"><?= t('exclusive') ?></span></h2>
        <p class="section-subtitle"><?= t('member_benefits_desc') ?></p>
        
        <div class="row g-4">
            <!-- Pacotes -->
            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <h4><i class="fas fa-gift me-2"></i> <?= t('travel_packages') ?></h4>
                    <p><?= t('packages_benefit') ?></p>
                    <a href="pacotes.php" class="btn btn-primary-modern btn-sm mt-2"><?= t('view_packages') ?></a>
                </div>
            </div>
            
            <!-- Reservas -->
            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <h4><i class="fas fa-calendar-check me-2"></i> <?= t('priority_booking') ?></h4>
                    <p><?= t('booking_benefit') ?></p>
                    <a href="reservas.php" class="btn btn-primary-modern btn-sm mt-2"><?= t('make_reservation') ?></a>
                </div>
            </div>
            
            <!-- Notícias -->
            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <h4><i class="fas fa-newspaper me-2"></i> <?= t('news_early') ?></h4>
                    <p><?= t('news_benefit') ?></p>
                    <a href="noticias-exclusivas.php" class="btn btn-primary-modern btn-sm mt-2"><?= t('read_news') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Frase Inspiradora -->
<section class="container">
    <div class="quote-section">
        <div class="quote lang-pt">"Angola não é só um país no mapa. É um sentimento que nasce na alma de quem a conhece."</div>
        <div class="quote lang-en d-none">"Angola is not just a country on the map. It’s a feeling born in the soul of those who know it."</div>
        <div class="quote lang-fr d-none">"L’Angola n’est pas qu’un pays sur la carte. C’est un sentiment qui naît dans l’âme de ceux qui le connaissent."</div>
        <div class="quote-author lang-pt">— Provérbio Angolano</div>
        <div class="quote-author lang-en d-none">— Angolan Proverb</div>
        <div class="quote-author lang-fr d-none">— Proverbe Angolais</div>
    </div>
</section>

<!-- Rodapé -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                <h5>Portal de Turismo de Angola</h5>
                <p class="lang-pt">Celebrando a diversidade, a beleza e a alma do nosso país. Um guia confiável para explorar Angola.</p>
                <p class="lang-en d-none">Celebrating the diversity, beauty, and soul of our country. A trusted guide to explore Angola.</p>
                <p class="lang-fr d-none">Célébrant la diversité, la beauté et l’âme de notre pays. Un guide fiable pour explorer l’Angola.</p>
                <div class="social-icons mt-3">
                    <a href="https://facebook.com/angolaturismo" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://instagram.com/angolaturismo" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://youtube.com/@angolaturismo" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://wa.me/244923456789" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                <h5 class="lang-pt">Links</h5>
                <h5 class="lang-en d-none">Links</h5>
                <h5 class="lang-fr d-none">Liens</h5>
                <a href="destinos.php" class="lang-pt">Destinos</a>
                <a href="destinos.php" class="lang-en d-none">Destinations</a>
                <a href="destinos.php" class="lang-fr d-none">Destinations</a>
                <a href="cultura.php" class="lang-pt">Cultura</a>
                <a href="cultura.php" class="lang-en d-none">Culture</a>
                <a href="cultura.php" class="lang-fr d-none">Culture</a>
                <a href="login.php" class="lang-pt">Login</a>
                <a href="login.php" class="lang-en d-none">Login</a>
                <a href="login.php" class="lang-fr d-none">Connexion</a>
                <a href="cadastro.php" class="lang-pt">Cadastro</a>
                <a href="cadastro.php" class="lang-en d-none">Register</a>
                <a href="cadastro.php" class="lang-fr d-none">Inscription</a>
            </div>
            <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                <h5 class="lang-pt">Recursos</h5>
                <h5 class="lang-en d-none">Resources</h5>
                <h5 class="lang-fr d-none">Ressources</h5>
                <a href="provincias.php" class="lang-pt">Províncias</a>
                <a href="provincias.php" class="lang-en d-none">Provinces</a>
                <a href="provincias.php" class="lang-fr d-none">Provinces</a>
                <a href="gastronomia.php" class="lang-pt">Gastronomia</a>
                <a href="gastronomia.php" class="lang-en d-none">Cuisine</a>
                <a href="gastronomia.php" class="lang-fr d-none">Gastronomie</a>
                <a href="experiencias.php" class="lang-pt">Experiências</a>
                <a href="experiencias.php" class="lang-en d-none">Experiences</a>
                <a href="experiencias.php" class="lang-fr d-none">Expériences</a>
                <a href="contato.php" class="lang-pt">Contato</a>
                <a href="contato.php" class="lang-en d-none">Contact</a>
                <a href="contato.php" class="lang-fr d-none">Contact</a>
                <a href="galeria .php" class="lang-fr d-none">Galeria </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <h5 class="lang-pt">Conecte-se</h5>
                <h5 class="lang-en d-none">Stay Connected</h5>
                <h5 class="lang-fr d-none">Restez Connecté</h5>
                <p class="lang-pt">Receba novidades e ofertas exclusivas diretamente no seu celular.</p>
                <p class="lang-en d-none">Receive news and exclusive offers directly to your celular.</p>
                <p class="lang-fr d-none">Recevez des nouveautés et offres exclusives directement dans votre email.</p>
                <div class="input-group">
                </div>
                        <!--Email-->
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="<?= t('your_email') ?>">
                    <button class="btn" style="background: var(--secondary); color: white;"><?= t('ok') ?></button>
                </div>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
        <div class="text-center">
            &copy; <?= date('Y') ?> Portal de Turismo de Angola. Todos os direitos reservados.
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ========== CONFIGURAÇÕES GLOBAIS ==========
    const currentLang = '<?= esc($user_lang) ?>';
    const currentTheme = '<?= esc($user_theme) ?>';
    const destinosData = <?= json_encode($destinos, JSON_HEX_TAG | JSON_HEX_AMP) ?>;

    // Aplica tema salvo
    document.documentElement.setAttribute('data-theme', currentTheme);
    updateThemeIcon();

    // ========== TEMA ==========
    function toggleTheme() {
        const newTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon();
        
        // Opcional: salvar no backend
        fetch('api/set-theme.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'theme=' + newTheme
        });
    }

    function updateThemeIcon() {
        const icon = document.getElementById('theme-icon');
        if (document.documentElement.getAttribute('data-theme') === 'dark') {
            icon.className = 'fas fa-sun';
        } else {
            icon.className = 'fas fa-moon';
        }
    }

    // ========== IDIOMA ==========
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const newLang = btn.dataset.lang;
            document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Oculta todos, mostra só do idioma selecionado
            document.querySelectorAll('[class*="lang-"]').forEach(el => el.classList.add('d-none'));
            document.querySelectorAll(`.lang-${newLang}`).forEach(el => el.classList.remove('d-none'));
            
            // Salva
            localStorage.setItem('lang', newLang);
            fetch('api/set-lang.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'lang=' + newLang
            });
        });
    });

    
    const map = L.map('angola-map').setView([-11.2027, 17.8739], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    Object.entries(destinosData).forEach(([id, d]) => {
        const [lat, lng] = d.coords;
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(`
            <strong>${d.nome[currentLang]}</strong><br>
            ${d.local}<br>
            <small>${d.descricao_curta[currentLang]}</small><br>
            <button class="btn btn-sm mt-2" style="background:#159f5f;color:white;" onclick="showDetails('${id}')">
                ${currentLang === 'pt' ? 'Detalhes' : (currentLang === 'en' ? 'Details' : 'Détails')}
            </button>
        `);
    });

    // ========== FUNÇÕES EXISTENTES ==========
    function showDetails(id) {
        const d = destinosData[id];
        if (!d) return;
        document.getElementById('modalTitle').textContent = d.nome[currentLang];
        document.getElementById('modalBody').innerHTML = `
            <img src="${d.img}" class="img-fluid rounded mb-3" alt="${d.nome[currentLang]}">
            <p><strong>${currentLang === 'pt' ? 'Local:' : (currentLang === 'en' ? 'Location:' : 'Lieu:')}</strong> ${d.local}</p>
            <p><strong>${currentLang === 'pt' ? 'Tipo:' : (currentLang === 'en' ? 'Type:' : 'Type:')}</strong> ${d.tipo[currentLang]}</p>
            <p><strong>${currentLang === 'pt' ? 'Preço:' : (currentLang === 'en' ? 'Price:' : 'Prix:')}</strong> ${d.preco}</p>
            ${d.descricao_longa[currentLang]}
        `;
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }

    function likePoint(btn) {
        const pontoId = btn.dataset.id;
        const countEl = btn.nextElementSibling.querySelector('span:last-child');
        fetch('curtir.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'ponto_id=' + encodeURIComponent(pontoId)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.classList.add('liked');
                btn.disabled = true;
                countEl.textContent = data.total;
                showToast();
            } else {
                if (data.total !== undefined) {
                    countEl.textContent = data.total;
                }
                alert(currentLang === 'pt' ? 'Você já curtiu este destino.' : 
                      currentLang === 'en' ? 'You already liked this destination.' : 
                      'Vous avez déjà aimé cette destination.');
            }
        })
        .catch(() => alert(currentLang === 'pt' ? 'Erro de conexão.' : 
                           currentLang === 'en' ? 'Connection error.' : 
                           'Erreur de connexion.'));
    }

    function showToast() {
        const toastEl = document.getElementById('liveToast');
        const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
        toast.show();
    }

    function showLoginAlert() {
        const msg = currentLang === 'pt' ? 'Faça login para adicionar este destino às suas estrelas!' :
                   currentLang === 'en' ? 'Log in to add this destination to your stars!' :
                   'Connectez-vous pour ajouter cette destination à vos étoiles !';
        alert(msg);
    }
</script>
</body>
</html>