<?php 


$host = 'localhost'; // servidor do banco de dados
$db   = 'crud'; // nome do banco de dados
$user = 'root';  // usuário do banco de dados
$pass = '';   // senha do banco de dados
$charset = 'utf8mb4'; // conjunto de caracteres

// Configurações do PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass); // cria uma nova conexão PDO

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // define o modo de erro para exceções

} catch (PDOException $e) {
    // Log error securely and show user-friendly message
    error_log('Database connection failed: ' . $e->getMessage());
    die('Erro de conexão com o banco de dados. Verifique se o XAMPP está rodando.');
}

?>