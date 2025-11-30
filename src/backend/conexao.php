// fazer a conexão com o banco de dados

<?php 


$host = 'localhost'; // servidor do banco de dados
$db   = 'crud'; // nome do banco de dados
$user = 'root';  // usuário do banco de dados
$pass = '';   // senha do banco de dados
$charset = 'utf8mb4'; // conjunto de caracteres


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass); // cria uma nova conexão PDO

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // define o modo de erro para exceções

    echo 'Conexão bem-sucedida!'; // mensagem de sucesso
} catch (PDOException $e) {
    echo 'Conexão falhou: ' . $e->getMessage(); // mensagem de erro 
}

?>