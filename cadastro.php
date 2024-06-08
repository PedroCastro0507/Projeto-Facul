<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
        $nome = mysqli_real_escape_string($conexao, strip_tags($_POST['nome']));
        $email = mysqli_real_escape_string($conexao, strip_tags($_POST['email']));
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

        // Insere os dados na tabela 'usuarios'
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $resultado = mysqli_query($conexao, $sql);

        // Verifica se a inserção foi bem-sucedida
        if ($resultado) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar. Tente novamente.";
        }
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
} else {
    header("Location: cadastro.html");
    exit;
}

mysqli_close($conexao);
?>
