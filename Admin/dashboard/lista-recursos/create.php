<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
    include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');

    // Obtém os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];

    // Obtém o ID do usuário da sessão
    $id_usuario = $_SESSION['usuario_id'];

    // Verifica se a imagem foi enviada
    if (isset($_FILES['imagem'])) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/' . $imagem_nome;
        $imagem_dir = '/uploads/images/' . $imagem_nome;

        // Move o arquivo de imagem para o diretório de destino
        if (move_uploaded_file($imagem_tmp, $imagem_destino)) {
            // Grava o novo recurso no banco de dados com status 'em_triagem'
            $sql = "INSERT INTO recursos (titulo, descricao, tipo, imagem, status, id_usuario) 
                    VALUES ('$titulo', '$descricao', '$tipo', '$imagem_dir', 'em_triagem', $id_usuario)";
            if ($conexao->query($sql) === TRUE) {
                // Redireciona de volta para a página de listagem
                header("Location: index.php");
                exit();
            } else {
                echo "Erro ao adicionar o recurso: " . $conexao->error;
            }
        } else {
            echo "Erro ao fazer o upload da imagem.";
        }
    } else {
        echo "Nenhum arquivo de imagem enviado.";
    }

    // Fecha a conexão
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Recurso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Adicionar Novo Recurso</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo">
                    <option value="evento">Evento</option>
                    <option value="atlética">Atlética</option>
                    <option value="comodidade" selected>Comodidade</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Adicionar Recurso</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
