<?php
include 'configuracoes.php';
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('destinations') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('destinations_desc') ?>">

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
            background: url('assets/baia.jpg');
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

        .destination-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            height: 100%;
            background: white;
        }
        [data-theme="dark"] .destination-card {
            background: #1e293b;
            color: #e2e8f0;
        }
        .destination-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            color: var(--primary);
            margin: 1rem 0 0.5rem;
            font-size: 1.3rem;
        }
        [data-theme="dark"] .card-title {
            color: #a7f3d0;
        }
        .badge-custom {
            background: #ecfdf5;
            color: var(--secondary);
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.8rem;
        }
        [data-theme="dark"] .badge-custom {
            background: #0c4a35;
            color: #6ee7b7;
        }

        .like-btn {
            background: none;
            border: none;
            font-size: 1.4rem;
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
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }
        [data-theme="dark"] .likes-count {
            background: #0c4a35;
            color: #6ee7b7;
        }

        #map-container {
            height: 400px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            margin: 2rem 0 3rem;
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

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><?= t('add_to_stars') ?></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

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
        <li class="nav-item"><a class="nav-link active" href="destinos.php"><?= t('destinations') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="cultura.php"><?= t('living_culture') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="contato.php"><?= t('links') ?></a></li>
        
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
    <h1><?= t('must_visit_destinations') ?></h1>
    <p class="lead"><?= t('explore_diversity') ?></p>
  </div>
</section>

<div class="container">
  <!-- Mapa Interativo -->
  <h2 class="section-title"><?= t('explore_on_map') ?></h2>
  <div id="map-container"></div>

  <h2 class="section-title"><?= t('explore_by_region') ?></h2>
  
  <div class="row g-4">
    <?php
    $destinos = [
        'kalandula' => [
            'nome' => ['pt' => 'Quedas de Kalandula', 'en' => 'Kalandula Falls', 'fr' => 'Chutes de Kalandula'],
            'local' => 'Malanje',
            'tipo' => ['pt' => 'Natureza', 'en' => 'Nature', 'fr' => 'Nature'],
            'descricao' => [
                'pt' => 'Uma das maiores cataratas da África. Melhor vista na estação chuvosa (dezembro a abril).',
                'en' => 'One of Africa’s largest waterfalls. Best viewed in rainy season (December to April).',
                'fr' => 'L’une des plus grandes cascades d’Afrique. À voir en saison des pluies (décembre à avril).'
            ],
            'img' => 'assets/queda.jpg',
            'coords' => [-9.3333, 15.3333]
        ],
        'baia_azul' => [
            'nome' => ['pt' => 'Baía Azul', 'en' => 'Blue Bay', 'fr' => 'Baie Bleue'],
            'local' => 'Benguela',
            'tipo' => ['pt' => 'Praia', 'en' => 'Beach', 'fr' => 'Plage'],
            'descricao' => [
                'pt' => 'Águas calmas, areia dourada e infraestrutura para famílias. Ideal para descanso.',
                'en' => 'Calm waters, golden sand, and family-friendly facilities. Perfect for relaxation.',
                'fr' => 'Eaux calmes, sable doré et installations familiales. Idéal pour se détendre.'
            ],
            'img' => 'assets/baia_azul.jpg',
            'coords' => [-12.5769, 13.4047]
        ],
        'tundavala' => [
            'nome' => ['pt' => 'Tundavala', 'en' => 'Tundavala', 'fr' => 'Tundavala'],
            'local' => 'Huíla',
            'tipo' => ['pt' => 'Montanha', 'en' => 'Mountain', 'fr' => 'Montagne'],
            'descricao' => [
                'pt' => 'Miradouros com vistas panorâmicas do planalto. Clima fresco o ano todo.',
                'en' => 'Viewpoints with panoramic plateau views. Cool climate year-round.',
                'fr' => 'Belvédères avec vues panoramiques sur le plateau. Climat frais toute l’année.'
            ],
            'img' => 'assets/tundavala.jpg',
            'coords' => [-14.8167, 13.4833]
        ],
        'lua' => [
            'nome' => ['pt' => 'Miradouro da Lua', 'en' => 'Moon Viewpoint', 'fr' => 'Belvédère de la Lune'],
            'local' => 'Luanda',
            'tipo' => ['pt' => 'Geologia', 'en' => 'Geology', 'fr' => 'Géologie'],
            'descricao' => [
                'pt' => 'Formações que lembram a superfície lunar. Melhor ao pôr do sol.',
                'en' => 'Formations resembling the lunar surface. Best at sunset.',
                'fr' => 'Formations rappelant la surface lunaire. À voir au coucher du soleil.'
            ],
            'img' => 'assets/miradouro_lua.jpg',
            'coords' => [-8.8369, 13.2343]
        ],
        'namibe' => [
            'nome' => ['pt' => 'Deserto do Namibe', 'en' => 'Namib Desert', 'fr' => 'Désert du Namib'],
            'local' => 'Namibe',
            'tipo' => ['pt' => 'Deserto', 'en' => 'Desert', 'fr' => 'Désert'],
            'descricao' => [
                'pt' => 'O único deserto costeiro da África, com falésias e vida selvagem única.',
                'en' => 'Africa’s only coastal desert, with dramatic cliffs and unique wildlife.',
                'fr' => 'Le seul désert côtier d’Afrique, avec falaises spectaculaires et faune unique.'
            ],
            'img' => 'assets/namibia-4965457.jpg',
            'coords' => [-15.2083, 12.1528]
        ],
        'kissama' => [
            'nome' => ['pt' => 'Parque Nacional da Kissama', 'en' => 'Kissama National Park', 'fr' => 'Parc National de Kissama'],
            'local' => 'Luanda',
            'tipo' => ['pt' => 'Vida Selvagem', 'en' => 'Wildlife', 'fr' => 'Faune'],
            'descricao' => [
                'pt' => 'Safáris guiados para ver elefantes, girafas, antílopes e aves raras.',
                'en' => 'Guided safaris to see elephants, giraffes, antelopes, and rare birds.',
                'fr' => 'Safaris guidés pour voir éléphants, girafes, antilopes et oiseaux rares.'
            ],
            'img' => 'assets/kissama.jpg',
            'coords' => [-9.6667, 13.3333]
        ]
    ];

    foreach ($destinos as $id => $d):
        $ja_votou = verificarVoto($id, $usuario_id, $pdo);
        $total = getTotalCurtidas($id, $pdo);
    ?>
    <div class="col-md-6 col-lg-4">
      <div class="destination-card">
        <img src="<?= esc($d['img']) ?>" class="card-img-top" alt="<?= esc($d['nome']['pt']) ?>">
        <div class="card-body">
          <h5 class="card-title"><?= esc($d['nome'][$user_lang] ?? $d['nome']['pt']) ?></h5>
          <p class="text-muted"><?= esc($d['local']) ?></p>
          <span class="badge-custom"><?= esc($d['tipo'][$user_lang] ?? $d['tipo']['pt']) ?></span>
          <p class="mt-2"><?= esc($d['descricao'][$user_lang] ?? $d['descricao']['pt']) ?></p>
          
          <div class="d-flex justify-content-between align-items-center mt-3">
            <?php if (isLoggedIn()): ?>
                <button class="like-btn <?= $ja_votou ? 'liked' : '' ?>"
                    data-id="<?= $id ?>"
                    onclick="likePoint(this)"
                    <?= $ja_votou ? 'disabled' : '' ?>>
                    <i class="fas fa-star"></i>
                </button>
                <span class="likes-count">
                    <i class="fas fa-star"></i> <?= $total ?>
                </span>
            <?php else: ?>
                <button class="btn btn-sm" style="background: var(--secondary); color: white;" onclick="showLoginAlert()">
                    <i class="fas fa-star me-1"></i> <?= t('star') ?>
                </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  
  <div class="text-center mt-5 mb-5">
    <h2 class="section-title"><?= t('plan_your_trip') ?></h2>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="p-4 bg-white rounded-3 shadow-sm" style="<?= $user_theme === 'dark' ? 'background:#1e293b;color:#e2e8f0;' : '' ?>">
          <h4 class="text-center mb-3" style="color: var(--primary);"><?= t('practical_tips') ?></h4>
          <ul class="list-group list-group-flush">
            <li class="list-group-item" style="<?= $user_theme === 'dark' ? 'background:#1e293b;border-color:#334155;' : '' ?>">
              <i class="fas fa-calendar-alt me-2 text-success"></i> 
              <strong><?= t('best_time') ?>:</strong> <?= t('may_to_sept') ?>
            </li>
            <li class="list-group-item" style="<?= $user_theme === 'dark' ? 'background:#1e293b;border-color:#334155;' : '' ?>">
              <i class="fas fa-car me-2 text-success"></i> 
              <strong><?= t('transport') ?>:</strong> <?= t('rental_with_driver') ?>
            </li>
            <li class="list-group-item" style="<?= $user_theme === 'dark' ? 'background:#1e293b;border-color:#334155;' : '' ?>">
              <i class="fas fa-hotel me-2 text-success"></i> 
              <strong><?= t('accommodation') ?>:</strong> <?= t('hotels_and_lodges') ?>
            </li>
            <li class="list-group-item" style="<?= $user_theme === 'dark' ? 'background:#1e293b;border-color:#334155;' : '' ?>">
              <i class="fas fa-phone me-2 text-success"></i> 
              <strong><?= t('emergency') ?>:</strong> 112 (<?= t('police') ?>), 115 (<?= t('ambulance') ?>)
            </li>
          </ul>
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
        <a href="destinos.php"><?= t('destinations') ?></a>
        <a href="cultura.php"><?= t('living_culture') ?></a>
        <a href="contato.php"><?= t('contact') ?></a>
      </div>
      <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
        <h5><?= t('resources') ?></h5>
        <a href="provincias.php"><?= t('provinces') ?></a>
        <a href="gastronomia.php"><?= t('cuisine') ?></a>
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

<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const currentLang = '<?= esc($user_lang) ?>';
    const isLoggedIn = <?= json_encode(isLoggedIn()) ?>;
    const destinosData = <?= json_encode($destinos, JSON_HEX_TAG | JSON_HEX_AMP) ?>;

    // Aplica tema
    document.documentElement.setAttribute('data-theme', '<?= esc($user_theme) ?>');

    // Mapa
    const map = L.map('map-container').setView([-11.2027, 17.8739], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    Object.entries(destinosData).forEach(([id, d]) => {
        const [lat, lng] = d.coords;
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(`
            <strong><?= esc($user_lang === 'pt' ? 'Nome:' : ($user_lang === 'en' ? 'Name:' : 'Nom:')) ?></strong> ${d.nome[currentLang]}<br>
            <strong><?= esc($user_lang === 'pt' ? 'Local:' : ($user_lang === 'en' ? 'Location:' : 'Lieu:')) ?></strong> ${d.local}<br>
            <img src="${d.img}" style="width:100%; height:120px; object-fit:cover; border-radius:8px; margin-top:8px;">
        `);
    });

    // Curtidas
    function likePoint(btn) {
        const pontoId = btn.dataset.id;
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
                const countEl = btn.nextElementSibling.querySelector('span:last-child');
                if (countEl) countEl.textContent = data.total;
                showToast();
            } else {
                alert('<?= t('already_starred') ?>');
            }
        })
        .catch(() => alert('<?= t('connection_error') ?>'));
    }

    function showLoginAlert() {
        alert('<?= t('login_to_star') ?>');
    }

    function showToast() {
        const toast = new bootstrap.Toast(document.getElementById('liveToast'), { delay: 2500 });
        toast.show();
    }
</script>
</body>
</html>