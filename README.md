================================
LANDING PAGE - AGÊNCIA DIGITAL
================================

Este arquivo contém as instruções para instalar e testar a aplicação de landing page.

---------------------------------
1. TECNOLOGIAS UTILIZADAS
---------------------------------

- Front-end: HTML5, CSS3, JavaScript (Fetch API)
- Back-end: PHP 8
- Banco de Dados: MySQL / MariaDB
- Servidor: Apache (via XAMPP)

---------------------------------
2. INSTRUÇÕES DE INSTALAÇÃO
---------------------------------

Para que a aplicação funcione corretamente, siga os passos abaixo.

Pré-requisitos:
- Ter o XAMPP instalado (ou outro ambiente com Apache, MySQL e PHP).
- Manter todos os arquivos do projeto na pasta `C:/xampp/htdocs/LANDING-PAGE/`.

Passo 1: Iniciar o Servidor
- Abra o Painel de Controle do XAMPP.
- Inicie os módulos "Apache" e "MySQL".

Passo 2: Criar e Importar o Banco de Dados
- Abra seu navegador e acesse o phpMyAdmin: http://localhost/phpmyadmin/
- Clique na aba "Bancos de dados" e crie um novo banco de dados com o nome `landing_page_db`.
- Selecione o banco de dados `landing_page_db` que você acabou de criar.
- Clique na aba "Importar".
- Clique em "Escolher arquivo" e selecione o arquivo `schema.sql` que está na pasta do projeto.
- Role para baixo e clique no botão "Importar".
- As tabelas `servicos` e `clientes` serão criadas e populadas com dados de exemplo.

Passo 3: Configurar as Credenciais do Banco de Dados
- Abra o arquivo `conexao.php`.
- Verifique se as credenciais correspondem à sua configuração do MySQL. Por padrão, no XAMPP, a configuração é:
  $dbHost = 'localhost';
  $dbUser = 'root';
  $dbPass = ''; // Senha vazia
  $dbName = 'landing_page_db';
- Se sua senha do MySQL for diferente, altere a variável `$dbPass`.

---------------------------------
3. COMO TESTAR A APLICAÇÃO
---------------------------------

1. Abra seu navegador de internet.
2. Acesse a URL: http://localhost/LANDING-PAGE/
3. A página da agência digital deve ser exibida.
4. Preencha o formulário de contato:
   - O campo "Serviço Desejado" deve listar as opções que foram inseridas pelo `schema.sql`.
   - Teste as validações (deixar campos obrigatórios em branco, inserir um e-mail inválido).
5. Clique em "Enviar".
6. Se os dados forem válidos, uma mensagem de sucesso aparecerá e o formulário será limpo.
7. Para verificar se os dados foram salvos, acesse o phpMyAdmin, selecione o banco `landing_page_db` e abra a tabela `clientes`. O novo registro deve estar lá.
