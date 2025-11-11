<?php
header('Content-Type: application/json');
require_once 'conexao.php';

$servicos = [];
$sql = "SELECT id, descricao FROM servicos ORDER BY descricao ASC";

try {
    $result = $conn->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $servicos[] = $row;
        }
    }
} catch (Exception $e) {
    // Não faz nada, apenas retorna um array vazio em caso de erro
}

$conn->close();
echo json_encode($servicos);
?>