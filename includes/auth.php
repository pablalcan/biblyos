<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    // Se o usuário não está logado, redireciona para a página de login
    header('Location: login.php');
    exit;
}
?>