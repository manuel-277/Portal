<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Faça login para curtir.']);
    exit;
}

$ponto_id = $_POST['ponto_id'] ?? '';
if (!$ponto_id) {
    echo json_encode(['success' => false, 'message' => 'ID do destino inválido.']);
    exit;
}

$usuario_id = (int)$_SESSION['user_id'];

// Verifica se já votou
$stmt = $pdo->prepare("SELECT id FROM votos WHERE usuario_id = ? AND ponto_turistico_id = ?");
$stmt->execute([$usuario_id, $ponto_id]);

if ($stmt->rowCount() > 0) {
    $count = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE ponto_turistico_id = ?");
    $count->execute([$ponto_id]);
    echo json_encode(['success' => false, 'message' => 'Você já curtiu este destino.', 'total' => (int)$count->fetchColumn()]);
    exit;
}

// Salva voto
$pdo->prepare("INSERT INTO votos (usuario_id, ponto_turistico_id) VALUES (?, ?)")
    ->execute([$usuario_id, $ponto_id]);

// Retorna total atualizado
$count = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE ponto_turistico_id = ?");
$count->execute([$ponto_id]);
echo json_encode(['success' => true, 'total' => (int)$count->fetchColumn()]);
?>