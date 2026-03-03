<?php
include 'configuracoes.php';
requireLogin();

$pacote = $_GET['pacote'] ?? '';
$nomes_pacotes = [
    'classico' => t('classic_angola'),
    'safari' => t('nature_safari'),
    'praia' => t('beach_relax')
];
$nome_pacote = $nomes_pacotes[$pacote] ?? t('custom_trip');
?>

<!DOCTYPE html>
<html lang="<?= esc($user_lang) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= t('priority_booking') ?> - Portal de Turismo de Angola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #004d40; --secondary: #159f5f; --accent: #f59e0b; }
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .navbar { background: var(--primary); padding: 0.8rem 0; }
        .reservation-card { border: none; border-radius: 16px; padding: 2rem; box-shadow: 0 6px 15px rgba(0,0,0,0.08); background: white; }
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
                <div class="reservation-card">
                    <h2 class="text-center mb-4"><?= t('make_reservation') ?></h2>
                    <p class="text-center mb-4"><?= sprintf(t('booking_for_package'), esc($nome_pacote)) ?></p>
                    
                    <form id="bookingForm">
                        <input type="hidden" name="pacote" value="<?= esc($pacote) ?>">
                        <input type="hidden" name="usuario_id" value="<?= esc($usuario_id) ?>">
                        
                        <div class="mb-3">
                            <label class="form-label"><?= t('full_name') ?></label>
                            <input type="text" class="form-control" value="<?= esc($user_name) ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?= t('email') ?></label>
                            <input type="email" class="form-control" value="<?= esc($_SESSION['user_email'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?= t('check_in_date') ?></label>
                            <input type="date" class="form-control" name="data_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?= t('duration_days') ?></label>
                            <select class="form-select" name="duracao" required>
                                <option value="3">3 dias</option>
                                <option value="5">5 dias</option>
                                <option value="7" selected>7 dias</option>
                                <option value="10">10 dias</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?= t('number_of_people') ?></label>
                            <input type="number" class="form-control" name="pessoas" min="1" max="10" value="2" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?= t('special_requests') ?></label>
                            <textarea class="form-control" name="observacoes" rows="3" placeholder="<?= t('any_special_needs') ?>"></textarea>
                        </div>
                        <button type="submit" class="btn w-100" style="background: var(--secondary); color: white;"><?= t('confirm_booking') ?></button>
                    </form>
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
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('<?= t('booking_success') ?>');
    window.location.href = 'minhas-estrelas.php';
});
</script>

</body>
</html>