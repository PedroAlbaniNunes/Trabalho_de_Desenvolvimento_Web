# 🔐 Recuperação de Senha — Guia de Configuração

---

## 🗄️ Passo 1: Configuração do Banco de Dados

1.  Abra o **XAMPP Control Panel**.
2.  Dê **Start** no **Apache** e no **MySQL**.
3.  Clique no botão **Admin** na linha do MySQL (ou acesse `http://localhost/phpmyadmin`).
4.  Na barra lateral esquerda, clique em **Novo** (New).
5.  Crie um banco de dados com o nome: `crud`
6.  Clique na aba **Importar** (no menu superior).
7.  Selecione o arquivo [`crud.sql`](../crud_sql/crud.sql), e clique em **Importar**.
    - _Isso vai criar a tabela `usuarios` com as colunas necessárias para a recuperação de senha._

---

## 📧 Passo 2: Configurar o Simulador de E-mail (Mailtrap)

Para testar o envio de e-mail sem precisar mexer com segurança do Gmail, cada um deve usar sua própria conta de testes (grátis):

1.  Acesse [mailtrap.io](https://mailtrap.io) e crie uma conta (pode usar o Google).
2.  No menu lateral, vá em **Email Testing** > **Inboxes**.
3.  Clique na caixa **"My Inbox"**.
4.  Procure a área **"SMTP Settings"** ou clique em **"Show Credentials"**.
5.  Mantenha essa página aberta e vá para a pasta do projeto no seu computador.
6.  Abra o arquivo `src/php/mailer.php` no VS Code.
7.  Substitua as linhas de usuário e senha pelos códigos que aparecem no **seu** site do Mailtrap:

```php
// No arquivo src/php/mailer.php:

$mail->Username   = 'COLE_SEU_USUARIO_AQUI';
$mail->Password   = 'COLE_SUA_SENHA_AQUI';
```

## ✅ Passo 4: Como Testar

1. Abra o navegador e acesse o formulário: (http://localhost/Trabalho_de_Desenvolvimento_Web/src/php/forgot-password.php)

2. Digite um e-mail que já esteja cadastrado no banco de dados  
   (_se não souber um, verifique no phpMyAdmin na tabela `usuarios`_).

3. Clique em **Enviar Link**.

4. Vá para a aba do **Mailtrap** — o e-mail simulado deve aparecer na caixa de entrada.

5. Abra o e-mail no Mailtrap e clique no **link de recuperação**.

6. Crie a nova senha.

7. Tente fazer **Login** no sistema para confirmar que funcionou corretamente.
