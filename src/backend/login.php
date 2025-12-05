<?php


session_start();
require 'conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Recebemos os dados. No HTML o campo se chama 'username' mas é o email
    $email = $_POST['username']; 
    $password = $_POST['password'];

    try {
        // Buscamos pelo email (campo único) como era originalmente
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        
        $stmt = $pdo->prepare($sql);

        $stmt->execute([':email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se achou o usuário E se a senha bate
        if ($user && password_verify($password, $user['senha'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: ../../src2/frontend/index.html");
            exit;

        } else {
            header("Location: ../frontend/login.html?login_erro=true");
        }

    } catch (PDOException $e) {
        // Log error securely
        error_log('Login error: ' . $e->getMessage());
        header("Location: ../frontend/login.html?login_erro=true");
        exit;
    }
} else {
    header("Location: ../frontend/login.html");
    exit;
}
?>