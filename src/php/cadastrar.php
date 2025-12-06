<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_criptografada = password_hash($password, PASSWORD_BCRYPT);


    try {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $password_criptografada
        ]);

        header("Location: ../pages/crud_usuario/register.html?sucesso=true");        
        exit;

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header("Location: ../pages/crud_usuario/register.html?erro=email_existe");
            exit;
        } else {
            header("Location: ../pages/crud_usuario/register.html?erro=sistema");
            exit;
        }
    }
} else {
    header("Location: ../pages/crud_usuario/register.html");
    exit;
}
?>