<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /Login/index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$is_admin = $_SESSION['admin'];

// Consulta para obter recursos com informações do usuário
$sql = "SELECT r.*, u.nome AS nome_usuario 
        FROM recursos r
        INNER JOIN usuarios u ON r.id_usuario = u.id";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Recursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Recursos Disponíveis</h2>
        <a href="/Home/" class="btn btn-primary mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z"/>
        </svg>
        </a>
        <a href="create.php" class="btn btn-primary mb-3">Adicionar Recurso</a>
        <?php if ($is_admin): ?>
            <a href="/Admin/dashboard/lista-usuarios/" class="btn btn-warning mb-3">Gerenciar Usuários</a>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Criado por</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["titulo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["descricao"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["tipo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["data_criacao"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nome_usuario"]) . "</td>";
                        echo "<td>";

                        // Verifica se o usuário é o criador do recurso ou um administrador
                        if ($is_admin || $row["id_usuario"] == $usuario_id) {
                            echo "<a href='edit.php?id={$row["id"]}' class='btn btn-primary btn-sm'>Editar</a> ";
                        } else {
                            echo '<a type="button" class="btn btn-danger disabled btn-sm" >Sem permissão</a>';
                            
                        }
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum recurso encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
