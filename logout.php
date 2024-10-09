<?php
  include 'config.php';
  session_start();

// Destruir todas as informações da sessão
session_unset();
session_destroy();

// Redirecionar para a página de login
header("Location: index.php");
exit();
?>
