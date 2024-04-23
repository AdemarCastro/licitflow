<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <link rel="stylesheet" href="assets/css/login.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login LicitFlow</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap"
    />
  </head>
  <body>
    <main class="main-container-login">
      <div id="bola-1"></div>

      

      <form id="form-login" method="post" action="scriptlogin.php">
        <input 
          type="text" 
          name="email"
          placeholder="Ensirar o e-mail/usuário"
          >
        <input 
          name="senha"
          type="password" 
          placeholder="Ensirar a senha">

        <div class="container-entrar">
          <div class="navegacao">
            <a href="cadastro.php">Não tem uma conta? Cadastre-se</a>
            <a href="recupera_senha.html">Esqueceu a senha</a>
          </div>
          <button type="submit">ENTRAR</button>
        </div>
      </form>
      <div id="bola-2"></div>
    </main>
    <script src="assets/js/loginscript.js"></script>
  </body>
</html>
