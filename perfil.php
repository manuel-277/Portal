<?php
include 'configuracoes.php';
requireLogin();

// Busca dados do usuário
$stmt = $pdo->prepare("SELECT nome, email, foto_perfil FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('profile') ?> - Portal de Turismo de Angola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #004d40; --secondary: #159f5f; }
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .profile-card { border: none; border-radius: 16px; padding: 2.5rem; box-shadow: 0 6px 15px rgba(0,0,0,0.08); background: white; }
        [data-theme="dark"] .profile-card { background: #1e293b; color: #e2e8f0; }
        .avatar-large { width: 120px; height: 120px; border-radius: 50%; background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: bold; margin: 0 auto 1.5rem; }
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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card">
                    <h2 class="text-center mb-4"><?= t('profile') ?></h2>
                    
                    <div class="text-center mb-4">
                        <div class="avatar-large">
                            <?= strtoupper(substr($usuario['nome'], 0, 1)) ?>
                        </div>
                        <h4><?= esc($usuario['nome']) ?></h4>
                        <p class="text-muted"><?= esc($usuario['email']) ?></p>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label"><?= t('full_name') ?></label>
                            <input type="text" class="form-control" value="<?= esc($usuario['nome']) ?>" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><?= t('email') ?></label>
                            <input type="email" class="form-control" value="<?= esc($usuario['email']) ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="minhas-estrelas.php" class="btn" style="background: var(--secondary); color: white;"><?= t('view_my_stars') ?></a>
                        <a href="index.php" class="btn btn-outline-secondary"><?= t('back_to_home') ?></a>
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

</body>
</html>