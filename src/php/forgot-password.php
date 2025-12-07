<!DOCTYPE html>
<html>
<head>
    <title>Esqueci a Senha</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>Esqueci a Senha</h1>

    <form method="post" action="send-password-reset.php">

        <label for="email">Digite seu e-mail cadastrado:</label>
        <input type="email" name="email" id="email" required>

        <button>Enviar Link de Recuperação</button>

    </form>

</body>
</html>