<?php
// Função para gerar um hash seguro para a senha
function generateHash($password) {
    $cost = 12; // O custo define o quão seguro o hash será, pode ser ajustado conforme necessário
    $salt = strtr(base64_encode(random_bytes(16)), '+', '.'); // Gera um salt aleatório
    $salt = sprintf("$2y$%02d$", $cost) . $salt; // Formata o salt com o custo desejado
    $hash = crypt($password, $salt); // Gera o hash usando o salt e a senha

    return $hash;
}

// Função para verificar se a senha corresponde ao hash
function verifyPassword($password, $hash) {
    return crypt($password, $hash) === $hash;
}

// Função para redirecionar para outra página
function redirect($url) {
    header("Location: index.php");
    exit();
}
?>
