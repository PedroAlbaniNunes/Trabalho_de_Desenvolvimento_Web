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

        $mensagem = "<p style='color:green;'>Usuário cadastrado com sucesso! Continue aqui ou faça login.</p>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $mensagem = "<p style='color:red;'>Erro: E-mail já cadastrado. Tente outro.</p>";
        } else {
            $mensagem = "<p style='color:red;'> Erro ao cadastrar: " . $e->getMessage();
        }
    }
} else {
    header("Location: ../frontend/register.html");
    exit;
}

?>

