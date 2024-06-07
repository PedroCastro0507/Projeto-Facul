<?php
include('conexao.php');
// Recebe os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta SQL para verificar se o usuário existe
$sql = "SELECT * FROM usuarios WHERE login = '$login'";
$resultado = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_assoc($resultado);

if ($linha && password_verify($senha, $linha['senha'])) {
    echo "Login realizado com sucesso!";
    // Aqui você pode redirecionar o usuário para a página principal
} else {
    echo "Usuário ou senha incorretos. Tente novamente.";
}
?>