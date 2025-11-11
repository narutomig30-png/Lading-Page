<?php
// --- Configurações do Banco de Dados ---
$dbHost = 'localhost';
$dbUser = 'root'; // Usuário do seu banco de dados
$dbPass = '';     // Senha do seu banco de dados
$dbName = 'landing_page_db'; // Nome do seu banco de dados

// --- Conexão com o Banco de Dados ---
// O @ suprime o warning padrão do PHP para que possamos lançar nossa própria exceção.
$conn = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Checar conexão
if ($conn->connect_error) {
    // Lança uma exceção em vez de encerrar o script com die().
    // Isso permite que o script que incluiu este arquivo (submit.php) capture o erro.
    throw new Exception("Falha na conexão com o banco de dados. Verifique as credenciais em conexao.php.");
}

// Garante que a comunicação com o banco de dados use o charset correto.
$conn->set_charset("utf8mb4");
?>