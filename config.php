<?php
// Configuração do banco de dados
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'vechat';

// Conexão com o banco de dados
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Verifica se houve erro na conexão
if (!$conn) {
    die('Erro na conexão com o banco de dados: ' . mysqli_connect_error());
}
?>

