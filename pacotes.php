<?php
include 'configuracoes.php';
requireLogin(); // Só acessível se logado
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('travel_packages') ?> - Portal de Turismo de Angola</title>
    <meta name="description" content="<?= t('packages_subtitle') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #004d40; --secondary: #159f5f; --accent: #f59e0b; }
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        [data-theme="dark"] body { background-color: #0f172a; color: #e2e8f0; }
        .navbar { background: var(--primary); box-shadow: 0 2px 15px rgba(0,0,0,0.1); padding: 0.8rem 0; }
        .navbar-brand { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 1.4rem; color: white !important; display: flex; align-items: center; gap: 12px; }
        .package-card { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 15px rgba(0,0,0,0.08); background: white; }
        [data-theme="dark"] .package-card { background: #1e293b; color: #e2e8f0; }
        .card-img-top { height: 200px; object-fit: cover; }
        .badge-exclusive { background: var(--accent); color: var(--primary); font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 20px; }
        footer { background: var(--primary); color: white; padding: 2.5rem 0 1.5rem; margin-top: 4rem; }
        footer h5 { font-family: 'Montserrat', sans-serif; margin-bottom: 1.2rem; color: var(--accent); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/logo.png" alt="Logotipo do Portal de Turismo de Angola" style="height: 42px; border-radius: 8px;">
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

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4"><?= t('travel_packages') ?></h2>
        <p class="text-center mb-5"><?= t('packages_subtitle') ?></p>
        
        <div class="row g-4">
            <!-- Pacote 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="package-card">
                    <img src="assets/pacotes/angola-classica.jpg" class="card-img-top" alt="<?= t('classic_angola') ?>">
                    <div class="card-body">
                        <span class="badge-exclusive"><?= t('exclusive') ?></span>
                        <h5 class="mt-3"><?= t('classic_angola') ?></h5>
                        <p><?= t('classic_angola_desc') ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price"><?= t('from') ?> 1.200.000 Kz</span>
                            <a href="reservas.php?pacote=classico" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('book_now') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pacote 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="package-card">
                    <img src="assets/pacotes/safari-natureza.jpg" class="card-img-top" alt="<?= t('nature_safari') ?>">
                    <div class="card-body">
                        <span class="badge-exclusive"><?= t('exclusive') ?></span>
                        <h5 class="mt-3"><?= t('nature_safari') ?></h5>
                        <p><?= t('safari_desc') ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price"><?= t('from') ?> 950.000 Kz</span>
                            <a href="reservas.php?pacote=safari" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('book_now') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pacote 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="package-card">
                    <img src="assets/pacotes/praias-relax.jpg" class="card-img-top" alt="<?= t('beach_relax') ?>">
                    <div class="card-body">
                        <span class="badge-exclusive"><?= t('exclusive') ?></span>
                        <h5 class="mt-3"><?= t('beach_relax') ?></h5>
                        <p><?= t('beach_desc') ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price"><?= t('from') ?> 750.000 Kz</span>
                            <a href="reservas.php?pacote=praia" class="btn btn-sm" style="background: var(--secondary); color: white;"><?= t('book_now') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container text-center">
        <p>&copy; <?= date('Y') ?> Portal de Turismo de Angola. <?= t('all_rights_reserved') ?>.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.documentElement.setAttribute('data-theme', '<?= esc($user_theme) ?>');
</script>

</body>
</html>