<?php
session_start();
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Destrói a sessão
header('Location: inicio.php'); // Redireciona para a página inicial
exit;
?>