<?php
// Define as credenciais corretas para o banco de dados do projeto.
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'Home@spSENAI2025!'; // Senha padrão do XAMPP/WAMP é vazia.
$dbName = 'landing_page_db';

// Ativa o report de erros para que as exceções sejam lançadas
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Captura a exceção do MySQLi e lança uma exceção genérica com uma mensagem mais clara.
    
    // O código de erro 1049 significa "Unknown database".
    if ($e->getCode() === 1049) {
        throw new Exception("Erro: O banco de dados '$dbName' não foi encontrado. Você executou o script SQL que forneci para criar o banco?");
    } 
    // O código de erro 1045 significa "Access denied".
    elseif ($e->getCode() === 1045) {
        throw new Exception("Erro: Acesso negado para o usuário '$dbUser'. Verifique se a senha no arquivo 'conexao.php' está correta. A senha padrão do XAMPP é vazia.");
    }
    // O código de erro 2002 significa que não pode se conectar ao servidor.
    elseif ($e->getCode() === 2002) {
        throw new Exception("Erro: Não foi possível conectar ao servidor MySQL. Verifique se o MySQL está iniciado no painel do XAMPP.");
    }
    // Para outros erros
    else {
        throw new Exception("Erro de conexão com o banco de dados: " . $e->getMessage());
    }
}
?>