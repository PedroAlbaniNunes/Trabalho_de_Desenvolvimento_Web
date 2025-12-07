<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

require __DIR__ . "/conexao.php";

$sql = "SELECT * FROM usuarios
        WHERE reset_token_hash = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$token_hash]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === false) {
    die("Token não encontrado");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token expirado");
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Redefinir Senha</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/crud_usuario_css/crud_usuario_style.css">
</head>
<body>

    <!-- <header class="cabecalho-navegacao">
        <nav>
            <a href="../../index.html">Início</a>
        </nav>
    </header> -->

    <div class="login-container">

        <h1>Redefinir Senha</h1>

        <form method="post" action="process-reset-password.php">

            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="input-group">
                <label for="password">Nova senha</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="password_confirmation">Repita a senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Salvar Nova Senha</button>
        </form>

    </div>

</body>
</html>