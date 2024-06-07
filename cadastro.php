<?php
include('conexao.php');

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_Post['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

// Insere os dados na tabela 'usuarios'
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
$resultado = mysqli_query($conexao, $sql);

if ($resultado) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar. Tente novamente.";
}
?>