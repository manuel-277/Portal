<?php
include 'configuracoes.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('my_stars') ?> - Portal de Turismo de Angola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #004d40; --secondary: #159f5f; }
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        [data-theme="dark"] body { background-color: #0f172a; color: #e2e8f0; }
        .navbar { background: var(--primary); padding: 0.8rem 0; }
        .navbar-brand { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 1.4rem; color: white !important; display: flex; align-items: center; gap: 12px; }
        .destination-card { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 15px rgba(0,0,0,0.08); background: white; }
        [data-theme="dark"] .destination-card { background: #1e293b; color: #e2e8f0; }
        .card-img-top { height: 200px; object-fit: cover; }
        .badge-custom { background: #ecfdf5; color: var(--secondary); font-weight: 600; padding: 0.25rem 0.7rem; border-radius: 50px; }
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
        <h2 class="text-center mb-4"><?= t('my_stars') ?></h2>
        <p class="text-center mb-5"><?= t('stars_benefit') ?></p>
        
        <?php
        // Busca destinos salvos
        $stmt = $pdo->prepare("
            SELECT v.ponto_turistico_id, d.nome, d.local, d.tipo, d.preco, d.img, d.descricao_curta
            FROM votos v
            JOIN (
                SELECT 'kalandula' AS id, ? AS nome, 'Malanje' AS local, ? AS tipo, 'Gratis' AS preco, 'assets/Queda.jpg' AS img, ? AS descricao_curta
                UNION ALL SELECT 'lua', ?, 'Luanda', ?, 'Gratis', 'assets/Miradouro_lua.jpg', ?
                UNION ALL SELECT 'tundavala', 'Tundavala', 'Huíla', ?, 'Gratis', 'assets/Tundavala.jpg', ?
                UNION ALL SELECT 'baia_azul', ?, 'Benguela', ?, 'Gratis', 'assets/baia_azul.jpg', ?
                UNION ALL SELECT 'namibe', ?, 'Namibe', ?, 'Gratis', 'assets/namibe.jpg', ?
                UNION ALL SELECT 'kissama', ?, 'Benguela/Luanda', ?, 'Pago', 'assets/kissama.jpg', ?
            ) d ON v.ponto_turistico_id = d.id
            WHERE v.usuario_id = ?
            ORDER BY v.data_voto DESC
        ");
        $stmt->execute([
            t('kalandula_falls'), t('nature_adventure'), t('kalandula_desc'),
            t('moon_viewpoint'), t('nature_photography'), t('lua_desc'),
            t('nature_adventure'), t('tundavala_desc'),
            t('blue_bay'), t('beach_relax'), t('baia_azul_desc'),
            t('namib_desert'), t('desert_adventure'), t('namibe_desc'),
            t('kissama_national_park'), t('safari_wildlife'), t('kissama_desc'),
            $usuario_id
        ]);
        $destinos_salvos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if ($destinos_salvos): ?>
            <div class="row g-4">
                <?php foreach ($destinos_salvos as $d): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="destination-card">
                            <img src="<?= esc($d['img']) ?>" class="card-img-top" alt="<?= esc($d['nome']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($d['nome']) ?></h5>
                                <span class="badge-custom"><?= esc($d['local']) ?></span>
                                <span class="badge-custom"><?= esc($d['tipo']) ?></span>
                                <p class="mt-2"><?= esc($d['descricao_curta']) ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="price"><?= esc($d['preco']) ?></span>
                                    <button class="btn btn-sm" style="background: var(--secondary); color: white;">
                                        <i class="fas fa-star me-1"></i> <?= t('saved') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                <h4><?= t('no_stars_yet') ?></h4>
                <p><?= t('start_exploring') ?></p>
                <a href="index.php" class="btn" style="background: var(--secondary); color: white;"><?= t('explore_destinations') ?></a>
            </div>
        <?php endif; ?>
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