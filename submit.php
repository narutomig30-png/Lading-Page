<?php
// Define que a resposta será em formato JSON
header('Content-Type: application/json');

// Prepara a resposta padrão
$response = [
    'status' => 'error',
    'message' => 'Ocorreu um erro inesperado. Tente novamente.'
];

// Envolve todo o processo em um bloco try-catch para capturar qualquer erro
try {
    // Apenas permite que o script seja acessado via método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de requisição não permitido.');
    }

    // Inclui o arquivo de conexão. Se ele falhar, a exceção será capturada.
    require_once 'conexao.php';

    // Coleta e limpa os dados recebidos do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $servico_id = filter_var($_POST['servico_id'] ?? '', FILTER_VALIDATE_INT);

    // Validação dos dados no lado do servidor
    $errors = [];
    if (empty($nome)) {
        $errors['nome'] = 'O campo nome é obrigatório.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'O formato do email é inválido.';
    }
    if (empty($servico_id)) {
        $errors['servico_id'] = 'Por favor, selecione um serviço válido.';
    }

    // Se houver erros de validação, retorna uma resposta detalhada
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
        throw new Exception("Erro ao salvar os dados: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Captura qualquer exceção e mostra a mensagem de erro real para depuração.
    // Em produção, você logaria o erro e mostraria uma mensagem genérica.
    // error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

// Envia a resposta final em formato JSON
echo json_encode($response);
?>