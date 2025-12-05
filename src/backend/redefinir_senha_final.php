<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $nova_senha = $_POST['new_password'] ?? '';
    $confirma_senha = $_POST['confirm_password'] ?? '';

    // 1. Validação simples
    if (empty($token) || empty($nova_senha) || $nova_senha !== $confirma_senha) {
        header("Location: ../frontend/redefinir_senha.html?erro=dados_invalidos");
        exit;
    }

    try {
        // 2. Verifica se o token existe e não expirou
        $agora = date('Y-m-d H:i:s');
        $sql_check = "SELECT email FROM password_resets WHERE token = :token AND expira_em > :agora";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([':token' => $token, ':agora' => $agora]);
        
        $reset_data = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (!$reset_data) {
            header("Location: ../frontend/redefinir_senha.html?erro=token_invalido");
            exit;
        }

        $email_usuario = $reset_data['email'];

        // 3. Criptografa a nova senha
        $senha_criptografada = password_hash($nova_senha, PASSWORD_BCRYPT);

        // 4. Atualiza a senha no banco de dados 'usuarios'
        $sql_update = "UPDATE usuarios SET senha = :senha WHERE email = :email";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([':senha' => $senha_criptografada, ':email' => $email_usuario]);

        // 5. Deleta o token de recuperação (para que não possa ser usado novamente)
        $sql_delete = "DELETE FROM password_resets WHERE token = :token";
        $pdo->prepare($sql_delete)->execute([':token' => $token]);

        // Sucesso
        header("Location: ../frontend/login.html?reset_sucesso=true");
        exit;

    } catch (PDOException $e) {
        header("Location: ../frontend/redefinir_senha.html?erro=sistema");
        exit;
    }
} else {
    header("Location: ../frontend/login.html");
    exit;
}
?>