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

// Inclui o arquivo de conexão com o banco de dados
include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');

// Verifica se o ID do usuário foi passado pela URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca os detalhes do usuário pelo ID
    $sql = "SELECT * FROM usuarios WHERE id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $email = $row['email'];
        $admin = $row['admin']; // Este campo deve ser um checkbox ou similar no formulário
    } else {
        // Se não encontrar o usuário, redireciona de volta para a página de listagem
        header("Location: index.php");
        exit();
    }
} else {
    // Se o ID do usuário não foi fornecido, redireciona de volta para a página de listagem
    header("Location: index.php");
    exit();
}

// Verifica se o formulário de edição foi enviado
if(isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    // Verifica se uma nova senha foi fornecida
    if(!empty($_POST['nova_senha'])) {
        $nova_senha = $_POST['nova_senha'];
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Atualiza a senha no banco de dados
        $sql = "UPDATE usuarios SET nome=?, email=?, senha=?, admin=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ssssi', $nome, $email, $senha_hash, $admin, $id);
    } else {
        // Mantém a senha existente se nenhuma nova senha foi fornecida
        $sql = "UPDATE usuarios SET nome=?, email=?, admin=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ssii', $nome, $email, $admin, $id);
    }

    // Executa a atualização no banco de dados
    if ($stmt->execute()) {
        // Redireciona de volta para a página de listagem
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar o usuário: " . $stmt->error;
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
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Usuário</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nova_senha" class="form-label">Nova Senha:</label>
                <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Deixe em branco para manter a senha atual">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1" <?php if($admin == 1) echo 'checked'; ?>>
                <label class="form-check-label" for="admin">Admin</label>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Salvar Alterações</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
