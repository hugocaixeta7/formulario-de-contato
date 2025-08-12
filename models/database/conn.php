<?php 

// Configurações de conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "form-contato-email";
$port = 3306;

try {
    // Tenta criar a conexão PDO com o banco MySQL
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe a mensagem de erro
    echo "Erro: " . $e->getMessage();
}
