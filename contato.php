<?php
include 'configuracoes.php';

// Mensagens após envio
$mensagem_sucesso = '';
$erros = [];

if (isset($_SESSION['contact_success'])) {
    $mensagem_sucesso = t('message_sent_success');
    unset($_SESSION['contact_success']);
}

if (!empty($_SESSION['contact_errors'])) {
    $erros = $_SESSION['contact_errors'];
    unset($_SESSION['contact_errors']);
}

// Dados para repreencher em caso de erro
$dados = $_SESSION['contact_data'] ?? [];
unset($_SESSION['contact_data']);
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('contact') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('contact_desc') ?>">

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
            background: linear-gradient(rgba(0, 30, 25, 0.85), rgba(0, 30, 25, 0.85)), url('https://images.unsplash.com/photo-1505142468610-359e7d316be0?auto=format&fit=crop&w=1920&q=80');
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

        .contact-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            height: 100%;
        }
        [data-theme="dark"] .contact-card {
            background: #1e293b;
            color: #e2e8f0;
        }

        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: #1e293b;
            color: #e2e8f0;
            border-color: #334155;
        }

        .btn-contact {
            background: var(--secondary);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 700;
            font-size: 1.05rem;
            border-radius: 8px;
            transition: all 0.25s;
            color: white;
        }
        .btn-contact:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(21, 159, 95, 0.3);
        }

        .alert-custom {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
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
        <li class="nav-item"><a class="nav-link active" href="contato.php"><?= t('contact') ?></a></li>
        
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
    <h1><?= t('get_in_touch') ?></h1>
    <p class="lead"><?= t('contact_subtitle') ?></p>
  </div>
</section>

<div class="container">
  <?php if ($mensagem_sucesso): ?>
    <div class="alert alert-success alert-custom d-flex align-items-center">
      <i class="fas fa-check-circle me-2"></i> <?= esc($mensagem_sucesso) ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($erros)): ?>
    <div class="alert alert-danger alert-custom">
      <i class="fas fa-exclamation-triangle me-2"></i>
      <ul class="mb-0" style="list-style: none; padding-left: 0;">
        <?php foreach ($erros as $erro): ?>
          <li><?= esc($erro) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="contact-card h-100">
        <h3 class="mb-4"><?= t('send_message') ?></h3>
        <form id="contactForm" action="enviar-contato.php" method="POST">
          <div class="mb-3">
            <label for="nome" class="form-label"><?= t('full_name') ?></label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= esc($dados['nome'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label"><?= t('email') ?></label>
            <input type="email" class="form-control" id="email" name="email" value="<?= esc($dados['email'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label for="assunto" class="form-label"><?= t('subject') ?></label>
            <select class="form-select" id="assunto" name="assunto" required>
              <option value=""><?= t('select_subject') ?></option>
              <option value="info_turistica" <?= (isset($dados['assunto']) && $dados['assunto'] === 'info_turistica') ? 'selected' : '' ?>><?= t('tourism_info') ?></option>
              <option value="parceria" <?= (isset($dados['assunto']) && $dados['assunto'] === 'parceria') ? 'selected' : '' ?>><?= t('partnership') ?></option>
              <option value="reportar_erro" <?= (isset($dados['assunto']) && $dados['assunto'] === 'reportar_erro') ? 'selected' : '' ?>><?= t('report_error') ?></option>
              <option value="outro" <?= (isset($dados['assunto']) && $dados['assunto'] === 'outro') ? 'selected' : '' ?>><?= t('other') ?></option>
            </select>
          </div>
          <div class="mb-3">
            <label for="mensagem" class="form-label"><?= t('message') ?></label>
            <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required><?= esc($dados['mensagem'] ?? '') ?></textarea>
          </div>
          <button type="submit" class="btn btn-contact w-100"><?= t('send_message') ?></button>
        </form>
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="contact-card h-100">
        <h3 class="mb-4"><?= t('contact_info') ?></h3>
        
        <div class="d-flex align-items-start mb-4">
          <div class="me-3" style="color: var(--secondary); font-size: 1.4rem;">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div>
            <h5><?= t('address') ?></h5>
            <p><?= t('luanda_address') ?></p>
          </div>
        </div>
        
        <div class="d-flex align-items-start mb-4">
          <div class="me-3" style="color: var(--secondary); font-size: 1.4rem;">
            <i class="fas fa-phone"></i>
          </div>
          <div>
            <h5><?= t('phone') ?></h5>
            <p>+244 900 000 000<br>+244 222 123 456</p>
          </div>
        </div>
        
        <div class="d-flex align-items-start mb-4">
          <div class="me-3" style="color: var(--secondary); font-size: 1.4rem;">
            <i class="fas fa-envelope"></i>
          </div>
          <div>
            <h5><?= t('email') ?></h5>
            <p>info@turismoangola.ao<br>suporte@turismoangola.ao</p>
          </div>
        </div>
        
        <div class="d-flex align-items-start">
          <div class="me-3" style="color: var(--secondary); font-size: 1.4rem;">
            <i class="fas fa-clock"></i>
          </div>
          <div>
            <h5><?= t('working_hours') ?></h5>
            <p><?= t('mon_fri') ?>: 8h–17h<br><?= t('sat') ?>: 9h–13h</p>
          </div>
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