<?php
    // Inicializando as sessões
    session_start();

    // Criar conexão com o banco de dados
    include("conexao.php");
    $conexao = conectar();

    // Recuperar dados do formulário utilizando o método POST
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $n_da_casa = $_POST['n_da_casa'];
    $rua = $_POST['rua'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $senha = md5($_POST['senha']); // MD5 está criptografando a senha do usuário
    $nivel_acesso = 'usuario'; // Default de cadastro

    // Verificar se o e-mail do usuário já não está registrado no banco de dados
    $verificarEmail = $conexao->prepare("SELECT * FROM usuarios WHERE email = :email");
    $verificarEmail->bindValue(":email", $email);
    $verificarEmail->execute();
    $consultaEmail = $verificarEmail->rowCount();

    // Verificar se o CPF do usuário já não está registrado no banco de dados
    $verificarCPF = $conexao->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
    $verificarCPF->bindValue(":cpf", $cpf);
    $verificarCPF->execute();
    $consultaCPF = $verificarCPF->rowCount();

    if ($consultaEmail == 0 && $consultaCPF == 0) {
        // E-mail e CPF não estão registrados, prosseguir com o cadastro
        $cadastro = $conexao->prepare(
            "INSERT INTO usuarios(nome, email, cpf, cep, n_da_casa, rua, estado, cidade, senha, nivel_acesso)
            VALUES (:nome, :email, :cpf, :cep, :n_da_casa, :rua, :estado, :cidade, :senha, :nivel_acesso)"
        );

        // Passando os dados das variáveis para os pseudo-nomes através do método bindValue
        $cadastro->bindValue(":nome", $nome);
        $cadastro->bindValue(":email", $email);
        $cadastro->bindValue(":cpf", $cpf);
        $cadastro->bindValue(":cep", $cep);
        $cadastro->bindValue(":n_da_casa", $n_da_casa);
        $cadastro->bindValue(":rua", $rua);
        $cadastro->bindValue(":estado", $estado);
        $cadastro->bindValue(":cidade", $cidade);
        $cadastro->bindValue(":senha", $senha);
        $cadastro->bindValue(":nivel_acesso", $nivel_acesso);

        $cadastro->execute();
        echo "Usuário cadastrado com sucesso!";
        $_SESSION['cadastrado'] = true;
    } else {
        // Informar ao usuário sobre os conflitos encontrados
        if ($consultaEmail > 0) {
            echo "E-mail já cadastrado!";
        }
        if ($consultaCPF > 0) {
            echo "CPF já cadastrado!";
        }
        $_SESSION['nao_cadastrado'] = true;
    }

    header('Location: cadastro.php');
    exit();
?>
