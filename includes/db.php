<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca_digital_biblyos"; // Nome do seu banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>