<?php

// Inicia a sessão
session_start();

// Verifica se há uma sessão de usuário ativa e se é administrador
if ($_SESSION['admin'] != 1) {
    echo $_SESSION['admin'];
    // Redireciona para a página de login ou outra página adequada
    header('Location: /Home/');
    exit;
}
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclui o arquivo de conexão
    include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');

    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    // Neste exemplo, vamos considerar que o campo admin é enviado via formulário (pode ser um checkbox, por exemplo)
    $admin = isset($_POST['admin']) ? 1 : 0;

    // Prepara a consulta SQL para inserir um novo usuário
    $sql = "INSERT INTO usuarios (nome, email, senha, admin) VALUES (?, ?, ?, ?)";
    
    // Prepara a declaração SQL
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação da consulta foi bem sucedida
    if ($stmt) {
        // Vincula os parâmetros à declaração SQL
        $stmt->bind_param('sssi', $nome, $email, $senha, $admin);
        
        // Executa a consulta
        if ($stmt->execute()) {
            // Redireciona de volta para a página de listagem
            header("Location: list.php");
            exit();
        } else {
            echo "Erro ao inserir o usuário: " . $stmt->error;
        }
    } else {
        echo "Erro na preparação da consulta: " . $conexao->error;
    }
    
    // Fecha a declaração e a conexão
    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Adicionar Novo Usuário</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1">
                <label class="form-check-label" for="admin">Admin</label>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Usuário</button>
            <a href="list.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
