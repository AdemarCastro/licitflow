<?php

    session_start(); // Iniciando uma sessão

    // Duas opções para chamar um arquivo: include e requery
    // Script que verifica se há um usuário logado
    include("scriptverificalogin.php");
?>

<!-- Mostrar o nome do usuário -->

<div align="right">
    <h2>Olá, <?php echo $_SESSION['usuario']; ?> </h2>
</div>

<!-- Link para encerrar a sessão do usuário -->
<nav align="right">
    <button><a style="color: black; text-decoration: none;" href="scriptlogout.php">Logout</a></button>
</nav>

<div align="center">
    <h1>Painel do Administrador</h1>
</div>