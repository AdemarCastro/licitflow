<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="assets/css/cadastro.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro - LicitFlow</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap"
    />
</head>
<body>
    <main class="main-container-login">
        <div id="bola-1"></div>
        <form id="form-login" form method="post" action="scriptcadastro.php">
            <input 
                type="text" 
                name="nome"
                placeholder="Nome completo"
                required
            >
            <input 
                type="email" 
                name="email"
                placeholder="E-mail"
                required
            >
            <input 
                type="text" 
                name="cpf"
                placeholder="CPF/CNPJ"
                required
            >
            <div id="divisao">
                <input 
                    type="text"
                    name="cep"
                    id="cep"
                    size="10"
                    value=""
                    onblur="pesquisacep(this.value)"
                    placeholder="CEP"
                    required
                >
                <span></span>
                <input 
                    type="text"
                    name="n_da_casa"
                    placeholder="N° da casa"
                    required
                >
            </div>
            <input 
                type="text" 
                name="rua"
                id="rua"
                placeholder="Rua"
                required
            >
            <input 
                type="text" 
                name="estado"
                placeholder="Estado"
                id="uf"
                required
            >
            <input 
                type="text"
                name="cidade"
                placeholder="Cidade"
                id="cidade"
                required
            >
            <input 
                type="password" 
                placeholder="Senha"
                name="senha"
                required
            >

            <!-- Exibindo mensagens de sucesso ou erro -->
            <?php if(isset($_SESSION['cadastrado'])): ?>
                <div class="notification is-success" align="center">
                    <p style="color:white">Usuário cadastrado com sucesso!</p>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['nao_cadastrado'])): ?>
                <div class="notification is-danger" align="center">
                    <p style="color:#f00">Erro: e-mail já cadastrado!</p>
                </div>
            <?php endif; ?>

            <div class="container-entrar">
                <a href="index.php">Já possui conta? <strong>Faça login</strong></a>
                <button type="submit">Cadastrar</button>
            </div>
        </form>
        <div id="bola-2"></div>
    </main>
    <script src="assets/js/cadastroscript.js"></script>
</body>
</html>

<?php
    // Limpa as sessões de mensagem após serem exibidas
    unset($_SESSION['cadastrado']);
    unset($_SESSION['nao_cadastrado']);
?>
