<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
        $nome = mysqli_real_escape_string($conexao, strip_tags($_POST['nome']));
        $email = mysqli_real_escape_string($conexao, strip_tags($_POST['email']));
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

        // Verifica se o email já está cadastrado
        $sql_verifica = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado_verifica = mysqli_query($conexao, $sql_verifica);

        if (mysqli_num_rows($resultado_verifica) > 0) {
            // Se o email já está cadastrado, redireciona com um erro
            header("Location: /Cadastro/index.php?login_error=email");
            exit();
        } else {
            // Insere os dados na tabela 'usuarios'
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
            $resultado = mysqli_query($conexao, $sql);

            // Verifica se a inserção foi bem-sucedida
            if ($resultado) {
                header("Location: /Login/index.php?new_account=true");

            } else {
                header("Location: /Cadastro/index.php?new_account=false");
            }
        }
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
} else {
    header("Location: /Cadastro/");
    exit();
}

mysqli_close($conexao);
?>
