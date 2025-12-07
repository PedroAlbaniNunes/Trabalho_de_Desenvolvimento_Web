<!DOCTYPE html>
<html>
<head>
    <title>Esqueci a Senha</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/crud_usuario_css/crud_usuario_style.css">
</head>
<body>

    <!-- <header class="cabecalho-navegacao">
        <nav>
            <a href="../../index.html">Início</a>
        </nav>
    </header> -->

    <div class="login-container">
        
        <h1>Esqueci a Senha</h1>

        <form method="post" action="send-password-reset.php">

            <div class="input-group">
                <label for="email">Digite seu e-mail</label>
                <input type="email" name="email" id="email" placeholder="exemplo@email.com" required>
            </div>

            <button type="submit">Enviar Link</button>

        </form>

        <div class="login-options">
            <a href="../../pages/crud_usuario/login.html">Voltar para o Login</a>
        </div>

    </div>

</body>
</html>