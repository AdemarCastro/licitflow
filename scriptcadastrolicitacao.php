<?php
    // Inicializando as sessões
    session_start();

    // Verificar se o usuário está logado

    if (!isset($_SESSION['usuario'])) {
        // Redirecionar para a página de login se o usuário não estiver logado
        header('Location: login.php');
        exit();
    }

    // Criar conexão com o banco de dados
    include("conexao.php");
    $conexao = conectar();

    // Recuperar dados do formulário utilizando o método POST
    $titulo = $_POST['titulo'];
    $servico = $_POST['servico'];
    $descricao = $_POST['descricao'];
    $documento = $_FILES['documento']['name']; // Nome do arquivo
    $documento_tmp = $_FILES['documento']['tmp_name']; // Caminho temporário do arquivo

    // Verificar se o título da licitação já não está registrado no banco de dados
    $verificarTitulo = $conexao->prepare("SELECT * FROM licitacoes WHERE titulo = :titulo");
    $verificarTitulo->bindValue(":titulo", $titulo);
    $verificarTitulo->execute();
    $consultaTitulo = $verificarTitulo->rowCount();

    if ($consultaTitulo == 0) {
        // Título não está registrado, prosseguir com o cadastro
        $cadastro = $conexao->prepare(
            "INSERT INTO licitacoes(titulo, servico, descricao, documento)
            VALUES (:titulo, :servico, :descricao, :documento)"
        );

        // Passando os dados das variáveis para os pseudo-nomes através do método bindValue
        $cadastro->bindValue(":titulo", $titulo);
        $cadastro->bindValue(":servico", $servico);
        $cadastro->bindValue(":descricao", $descricao);
        $cadastro->bindValue(":documento", $documento);

        // Mover o arquivo para o diretório de destino
        $diretorioDestino = 'uploads/'; // Diretório onde o arquivo será armazenado
        move_uploaded_file($documento_tmp, $diretorioDestino . $documento);

        $cadastro->execute();
        echo "Licitação cadastrada com sucesso!";
        $_SESSION['cadastrado'] = true;
    } else {
        // Informar ao usuário sobre o conflito encontrado
        echo "Título da licitação já cadastrado!";
        $_SESSION['nao_cadastrado'] = true;
    }

    // Recuperar o email do usuário da sessão
    $email = $_SESSION['usuario'];

    // Buscar o usuário no banco de dados pelo email
    $buscarUsuario = $conexao->prepare("SELECT * FROM usuarios WHERE email = :email");
    $buscarUsuario->bindValue(":email", $email);
    $buscarUsuario->execute();
    $usuario = $buscarUsuario->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário foi encontrado
    if ($usuario) {
        // Recuperar o nível de acesso do usuário
        $nivel_acesso = $usuario['nivel_acesso'];

        // Redirecionar com base no nível de acesso
        switch ($nivel_acesso) {
            case 'admin':
                header('Location: painel-admin.php');
                break;
            case 'usuario':
                header('Location: painel-usuario.php');
                break;
            case 'sem-acesso':
                header('Location: sem-acesso.php');
                break;
            default:
                header('Location: login.php');
                break;
        }
    } else {
        // Redirecionar para a página de login se o usuário não for encontrado
        header('Location: login.php');
    }
    exit();
?>
