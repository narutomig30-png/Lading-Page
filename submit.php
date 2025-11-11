<?php
header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => 'Ocorreu um erro inesperado. Tente novamente.'
];

try {
    // Inclui a conexão. Se falhar, o bloco catch irá capturar o erro.
    require_once 'conexao.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de requisição não permitido.');
    }

    // Validação dos dados recebidos do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $servico_id = filter_var($_POST['servico_id'] ?? '', FILTER_VALIDATE_INT);

    $errors = [];
    if (empty($nome)) { $errors['nome'] = 'O campo nome é obrigatório.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'O formato do email é inválido.'; }
    if (empty($servico_id)) { $errors['servico_id'] = 'Por favor, selecione um serviço válido.'; }

    if (!empty($errors)) {
        $response['message'] = 'Por favor, corrija os erros no formulário.';
        $response['errors'] = $errors;
        echo json_encode($response);
        if (isset($conn)) $conn->close();
        exit;
    }

    // Prepara e executa a inserção no banco de dados
    $sql = "INSERT INTO clientes (nome, email, telefone, servico_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $nome, $email, $telefone, $servico_id);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Obrigado! Seus dados foram enviados com sucesso.';
    } else {
        throw new Exception("Erro ao salvar os dados no banco: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Captura qualquer erro (de conexão ou de execução) e o envia como resposta JSON
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>