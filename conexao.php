<?php
$host = 'localhost';
$usuario = 'mysql';
$senha = 'suaSenha'; 
$banco = 'suaBase';

$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica se ocorreu algum erro na conexão
if ($conexao->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conexao->connect_error);
} 
?>
