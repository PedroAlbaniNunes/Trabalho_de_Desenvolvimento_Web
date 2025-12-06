<?php
require 'conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        header("Location: ..pages/crud_usuario/recuperar_senha.html?erro=vazio");
        exit;
    }

    try {
        // ... (Lógica de verificação de email, geração de token e salvamento no DB) ...
        $sql_check = "SELECT id FROM usuarios WHERE email = :email";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([':email' => $email]);
        
        if ($stmt_check->rowCount() === 0) {
            header("Location: ../pages/crud_usuario/recuperar_senha.html?erro=email_nao_encontrado");
            exit;
        }

        $token = bin2hex(random_bytes(32)); 
        $expira_em = date('Y-m-d H:i:s', strtotime('+1 hour')); 

        $sql_delete = "DELETE FROM password_resets WHERE email = :email";
        $pdo->prepare($sql_delete)->execute([':email' => $email]);
        
        $sql_insert = "INSERT INTO password_resets (email, token, expira_em) VALUES (:email, :token, :expira_em)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([
            ':email' => $email,
            ':token' => $token,
            ':expira_em' => $expira_em
        ]);

        $reset_link = "http://localhost/web/src/pages/crud_usuario/redefinir_senha.html?token=" . $token;        
        // =================================================================
        // MODO SIMULAÇÃO (EXIBE O TOKEN NA TELA)
        // O código de envio de email foi removido para fins de teste local.
        // =================================================================
        
        echo "<h2>SIMULAÇÃO DE ENVIO DE E-MAIL (APENAS PARA TESTES)</h2>";
        echo "<p>O token de reset gerado é: <strong>" . $token . "</strong></p>";
        echo "<p>O link que você deve usar é: <a href='" . $reset_link . "'>" . $reset_link . "</a></p>";
        echo "<p>Copie e cole este link na barra de endereços para continuar o processo.</p>";
        exit; // Finaliza o script aqui.
        
    } catch (PDOException $e) {
        // Se houver um erro no banco de dados, você será redirecionado aqui.
        header("Location: ../pages/crud_usuario/recuperar_senha.html?erro=sistema");
        exit;
    }
} else {
    header("Location: ../pages/crud_usuario/recuperar_senha.html");
    exit;
}