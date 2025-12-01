<?php


require 'conexao.php';

//1. Processa o formulário quando for enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //2. Criptografa a senha
    $password_criptografada = password_hash($password, PASSWORD_BCRYPT);

    try {
        //3. Prepara e executa a inserção no banco
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $password_criptografada
        ]);

        $mensagem = "<p style='color:green;'>Usuário cadastrado com sucesso! Continue aqui ou faça login.</p>";
    } catch (PDOException $e) {
        //4. Trata erros, como e-mail duplicado
        if ($e->getCode() == 23000) {
            $mensagem = "<p style='color:red;'>Erro: E-mail já cadastrado. Tente outro.</p>";
        } else {
            $mensagem = "<p style='color:red;'> Erro ao cadastrar: " . $e->getMessage();
        }
    }
} else {
    // Redireciona se o acesso não for via POST
    header("Location: ../frontend/register.html");
    exit;
}

?>

