<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$is_admin = $_SESSION['admin']; // Assume que a sessão armazena se o usuário é admin ou não

// Verifica se o ID do recurso foi passado pela URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca os detalhes do recurso pelo ID
    $sql = "SELECT * FROM recursos WHERE id=$id";
    $result = $conexao->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $titulo = $row['titulo'];
        $descricao = $row['descricao'];
        $tipo = $row['tipo'];
        $status = $row['status'];
        $imagem = $row['imagem'];
        $id_usuario = $row['id_usuario']; // Adicionando para comparar depois
    } else {
        // Se não encontrar o recurso, redireciona de volta para a página de listagem
        header("Location: index.php");
        exit();
    }
} else {
    // Se o ID do recurso não foi fornecido, redireciona de volta para a página de listagem
    header("Location: index.php");
    exit();
}

// Verifica se o formulário de edição foi enviado
if (isset($_POST['submit'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];

    // Atualiza o status somente se o usuário for admin
    if ($is_admin) {
        $status = $_POST['status'];
    }

    // Verifica se foi enviado um novo arquivo de imagem
    if (isset($_FILES['nova_imagem']) && $_FILES['nova_imagem']['error'] == UPLOAD_ERR_OK) {
        $nova_imagem_nome = $_FILES['nova_imagem']['name'];
        $nova_imagem_tmp = $_FILES['nova_imagem']['tmp_name'];
        $nova_imagem_destino = $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/' . $nova_imagem_nome;
        $nova_imagem_destino_db = '/uploads/images/' . $nova_imagem_nome;

        // Move o novo arquivo de imagem para o diretório de destino
        if (move_uploaded_file($nova_imagem_tmp, $nova_imagem_destino)) {
            // Atualiza o nome da imagem no banco
            $sql = "UPDATE recursos SET imagem='$nova_imagem_destino_db' WHERE id=$id";
            $conexao->query($sql);
        } else {
            echo "Erro ao fazer o upload da nova imagem.";
        }
    }

    // Atualiza os outros campos no banco
    if ($is_admin) {
        $sql = "UPDATE recursos SET titulo='$titulo', descricao='$descricao', tipo='$tipo', status='$status' WHERE id=$id";
    } else {
        $sql = "UPDATE recursos SET titulo='$titulo', descricao='$descricao', tipo='$tipo' WHERE id=$id";
    }
    $conexao->query($sql);

    // Redireciona de volta para a página de listagem
    header("Location: index.php");
    exit();
}

// Verifica se a ação de deletar foi enviada
if (isset($_POST['delete'])) {
    // Permite deletar se o usuário for admin ou o autor do recurso
    if ($is_admin || $id_usuario == $usuario_id) {
        $sql = "DELETE FROM recursos WHERE id=$id";
        $conexao->query($sql);

        // Redireciona de volta para a página de listagem
        header("Location: index.php");
        exit();
    } else {
        echo "Você não tem permissão para deletar este recurso.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Recurso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Recurso</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 border rounded">
                <?php if (!empty($imagem)): ?>
                    <img src="<?php echo $imagem; ?>" alt="Imagem Atual" class="img-thumbnail mb-2" style="max-width: 300px;">
                    <a href="<?php echo $imagem; ?>" download class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                    </svg>  Baixar
                    </a>
                <?php else: ?>
                    <p>Nenhuma imagem disponível.</p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($descricao); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo">
                    <option value="evento" <?php if ($tipo == 'evento') echo 'selected'; ?>>Evento</option>
                    <option value="atlética" <?php if ($tipo == 'atlética') echo 'selected'; ?>>Atlética</option>
                    <option value="comodidade" <?php if ($tipo == 'comodidade') echo 'selected'; ?>>Comodidade</option>
                </select>
            </div>

            <?php if ($is_admin): ?>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="ativo" <?php if ($status == 'ativo') echo 'selected'; ?>>Ativo</option>
                    <option value="inativo" <?php if ($status == 'inativo') echo 'selected'; ?>>Inativo</option>
                    <option value="em_triagem" <?php if ($status == 'em_triagem') echo 'selected'; ?>>Em Triagem</option>
                </select>
            </div>
            <?php endif; ?>
            <?php if (!$is_admin): ?>
            <div class="mb-3">
                <p class="text-decoration-underline text-danger">Seu recurso está em triagem, deve aguardar até que um administrador aprove para que ele se torne pubico.</p>
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="nova_imagem" class="form-label">Nova Imagem</label>
                <input type="file" class="form-control" id="nova_imagem" name="nova_imagem" accept="image/*">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <?php if ($is_admin || $id_usuario == $usuario_id): ?>
                <button type="submit" name="delete" class="btn btn-danger">Deletar Recurso</button>
            <?php endif; ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
