<?php
// ✅ Inicia a sessão apenas uma vez no sistema (geralmente em config.php ou header)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações do banco de dados
$host = 'localhost';
$db   = 'turismo_angola';
$user = 'root';
$pass = '';

// Opções avançadas do PDO para segurança e compatibilidade
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,      // Lança exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,           // Retorna arrays associativos por padrão
    PDO::ATTR_EMULATE_PREPARES   => false,                      // Usa prepared statements reais (protege contra SQL injection)
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci", // Suporte completo a emojis e acentos
    PDO::ATTR_PERSISTENT         => false                        // Evita conexões persistentes (mais seguro em ambientes compartilhados)
];

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, $options);
} catch (PDOException $e) {
    // Registra o erro real no log do servidor (nunca expõe detalhes sensíveis ao usuário)
    error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
    
    // Mensagem amigável para o usuário
    http_response_code(500);
    die("Desculpe, estamos enfrentando problemas técnicos. Tente novamente mais tarde.");
}
?>
