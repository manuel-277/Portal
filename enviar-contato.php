<?php
// Inclui configurações para acesso ao idioma e funções
include 'configuracoes.php';

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Método não permitido.');
}

// Função para obter tradução no contexto atual
function t_local($key) {
    global $translations, $user_lang;
    return $translations[$user_lang][$key] ?? $translations['pt'][$key] ?? $key;
}

// Captura e sanitiza os dados
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// Validação
$erros = [];

if (empty($nome)) {
    $erros[] = t_local('error_name_required');
} elseif (strlen($nome) < 3) {
    $erros[] = t_local('error_name_min');
}

if (empty($email)) {
    $erros[] = t_local('error_email_required');
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = t_local('error_email_invalid');
}

if (empty($assunto) || !in_array($assunto, ['info_turistica', 'parceria', 'reportar_erro', 'outro'])) {
    $erros[] = t_local('error_subject_required');
}

if (empty($mensagem)) {
    $erros[] = t_local('error_message_required');
} elseif (strlen($mensagem) < 10) {
    $erros[] = t_local('error_message_min');
}

// Proteção básica contra spam (verifica campos ocultos ou padrões suspeitos)
if (
    isset($_POST['url']) && !empty($_POST['url']) || // campo honeypot comum
    preg_match('/<script|javascript:/i', $mensagem) ||
    substr_count($mensagem, 'http') > 2
) {
    // Silenciosamente ignora (não informa ao spammer)
    header('Location: contato.php?status=success');
    exit();
}

if (!empty($erros)) {
    $_SESSION['contact_errors'] = $erros;
    $_SESSION['contact_data'] = [
        'nome' => $nome,
        'email' => $email,
        'assunto' => $assunto,
        'mensagem' => $mensagem
    ];
    header('Location: contato.php');
    exit();
}

// --- ENVIO DO EMAIL ---
$destino = 'info@turismoangola.ao'; // Altere para seu email real
$remetente = 'no-reply@turismoangola.ao'; // Use um email do mesmo domínio

// Assuntos traduzidos
$assuntos_map = [
    'pt' => [
        'info_turistica' => 'Informações Turísticas',
        'parceria' => 'Pedido de Parceria',
        'reportar_erro' => 'Relatório de Erro no Site',
        'outro' => 'Outro Assunto'
    ],
    'en' => [
        'info_turistica' => 'Tourism Information',
        'parceria' => 'Partnership Request',
        'reportar_erro' => 'Website Error Report',
        'outro' => 'Other Subject'
    ],
    'fr' => [
        'info_turistica' => 'Informations Touristiques',
        'parceria' => 'Demande de Partenariat',
        'reportar_erro' => 'Signalement d’Erreur sur le Site',
        'outro' => 'Autre Sujet'
    ]
];

$assunto_email = $assuntos_map[$user_lang][$assunto] ?? $assuntos_map['pt'][$assunto];

// Corpo do email
$corpo = "
Novo contacto recebido no Portal de Turismo de Angola

Nome: $nome
Email: $email
Assunto: $assunto_email
Mensagem:
$mensagem

Data: " . date('d/m/Y H:i:s') . "
IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Desconhecido');

// Cabeçalhos
$headers = "From: $remetente\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Tenta enviar
if (mail($destino, "Contato - $assunto_email", $corpo, $headers)) {
    $_SESSION['contact_success'] = true;
} else {
    $_SESSION['contact_errors'] = [t_local('error_send_failed')];
    $_SESSION['contact_data'] = compact('nome', 'email', 'assunto', 'mensagem');
}

header('Location: contato.php');
exit();
?>