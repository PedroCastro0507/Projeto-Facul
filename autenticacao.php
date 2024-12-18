<?php
include('conexao.php');
// Recebe os dados do formulário
$email = $_POST['email'];
$pass = $_POST['senha'];

// Consulta SQL para verificar se o usuário existe
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conexao, $sql);
if ($resultado) {
    // Verifica se foi retornado algum resultado
    if (mysqli_num_rows($resultado) > 0) {
        $linha = mysqli_fetch_assoc($resultado);
        // Verifica se a senha está correta
        if (password_verify($pass, $linha['senha'])) {
            // Define as variáveis de sessão
            session_start();
            $_SESSION['usuario_id'] = $linha['id']; 
            $_SESSION['usuario_nome'] = $linha['nome'];
            $_SESSION['usuario_email'] = $linha['email'];
            $_SESSION['admin'] = $linha['admin'];

            header('Location: Admin/dashboard/lista-recursos');
            exit;
        } else {
            echo"erro";
            header('Location: Login/index.php?login_erro=true');
            exit;
        }
    } else {
        header('Location: Login/index.php?login_erro=true');
        exit;
    }
} else {
    echo "Erro ao executar a consulta: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>