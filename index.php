<?php
// Inclui o arquivo de conexão para poder acessar o banco de dados.
$connection_error = false;
try {
    require_once 'conexao.php';
} catch (Exception $e) {
    $connection_error = true;
    // Opcional: logar o erro para depuração.
    // error_log($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agência Digital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="containerInicio">
    <header>
         <div class="text">
            <h1>Bem-vindo à nossa Agência Digital</h1>
            <p>Soluções criativas para impulsionar o seu negócio.</p>
         </div>
    </header>

    <main>
        <section id="contact">
            <div class="container">
                <h2>Entre em Contato</h2>
                <p>Preencha o formulário abaixo para solicitar um orçamento.</p>
                
                <form id="contact-form">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>
                        <div class="error-message" id="error-nome"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <div class="error-message" id="error-email"></div>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone">
                    </div>
                    <div class="form-group">
                        <label for="servico">Serviço Desejado:</label>
                        <select id="servico" name="servico_id" required>
                            <option value="1">Desenvolvimento de Website</option>
                            <option value="2">Marketing Digital</option>
                            <option value="3">Design Gráfico</option>
                            <option value="4">Otimização de SEO</option>
                            <?php
                                // Verifica se a conexão foi bem-sucedida
                                if (!$connection_error && isset($conn)) {
                                    // Busca os serviços no banco de dados
                                    $sql = "SELECT id, nome FROM servicos ORDER BY nome";
                                    $result = $conn->query($sql);

                                    if ($result && $result->num_rows > 0) {
                                        // Itera sobre os resultados e cria as opções do select
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['nome']) . '</option>';
                                        }
                                    } else {
                                        // Se não encontrar serviços, mostra uma opção de erro
                                        echo '<option value="" disabled>Nenhum serviço encontrado</option>';
                                    }
                                    // Fecha a conexão com o banco
                                    $conn->close();
                                } else {
                                    // Se a conexão falhar, exibe uma mensagem de erro
                                    echo '<option value="" disabled>Não foi possível carregar os serviços</option>';
                                }
                            ?>
                        </select>
                        <div class="error-message" id="error-servico_id"></div>
                    </div>
                    <button type="submit">Enviar</button>
                </div>
                </form>
                <div id="form-response"></div>
        </section>
    </main>
    </div>

<br> <br> <br> <br> <br> 

    <footer>
    <div class="footer-section">
        <h3>Desenvolvido por </h3>
        <h4>Pinesso e Miguel Vinícius</h4>
    </div>
    <div class="footer-section">
        <h3>Turma:</h3>
        <p>1º Ano A - SESI - Desenvolvimento de sistemas</p>
    </div>
    </footer>

    <script src="app.js"></script>
</body>
</html>
