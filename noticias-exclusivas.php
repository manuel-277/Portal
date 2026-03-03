<?php
include 'configuracoes.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('news_early') ?> - Portal de Turismo de Angola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #004d40; --secondary: #159f5f; --accent: #f59e0b; }
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .navbar { background: var(--primary); padding: 0.8rem 0; }
        .news-card { border: none; border-radius: 16px; padding: 1.8rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: white; }
        [data-theme="dark"] .news-card { background: #1e293b; color: #e2e8f0; }
        footer { background: var(--primary); color: white; padding: 2.5rem 0 1.5rem; margin-top: 4rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/logo.png" alt="Logotipo" style="height: 42px; border-radius: 8px;">
            <span>Portal de Turismo de Angola</span>
        </a>
        <a href="logout.php" class="btn btn-sm" style="background: var(--accent); color: var(--primary);"><?= t('logout') ?></a>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4"><?= t('news_early') ?></h2>
        <p class="text-center mb-5"><?= t('news_benefit') ?></p>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="news-card">
                    <h4><?= t('new_air_routes') ?></h4>
                    <small class="text-muted"><?= t('published_on') ?>: 15 Fev, 2026</small>
                    <p class="mt-2"><?= t('air_routes_desc') ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="news-card">
                    <h4><?= t('kalandula_access') ?></h4>
                    <small class="text-muted"><?= t('published_on') ?>: 10 Fev, 2026</small>
                    <p class="mt-2"><?= t('kalandula_news_desc') ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="news-card">
                    <h4><?= t('tourism_awards') ?></h4>
                    <small class="text-muted"><?= t('published_on') ?>: 5 Fev, 2026</small>
                    <p class="mt-2"><?= t('awards_desc') ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="news-card">
                    <h4><?= t('new_lodges_kissama') ?></h4>
                    <small class="text-muted"><?= t('published_on') ?>: 1 Fev, 2026</small>
                    <p class="mt-2"><?= t('lodges_kissama_desc') ?></p>
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

</body>
</html>