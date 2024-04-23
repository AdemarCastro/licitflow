<?php
    // Iniciar sessão
    session_start();

    // Verificar se o usuário está logado
    include("scriptVerificarLogin.php");

    // Conectar ao banco de dados
    include("conexao.php");
    $conexao = conectar();

    // Verificar se o ID da licitação foi passado
    if (!isset($_GET['id'])) {
        die("ID da licitação não fornecido.");
    }

    // Preparar e executar a consulta de exclusão
    $id = $_GET['id'];
    $excluirLicitacao = $conexao->prepare("DELETE FROM licitacoes WHERE id = :id");
    $excluirLicitacao->bindParam(':id', $id, PDO::PARAM_INT);
    $excluirLicitacao->execute();

    // Verificar se a licitação foi excluída com sucesso
    if ($excluirLicitacao->rowCount() > 0) {
        // Redirecionar para uma página de confirmação ou lista de licitações
        header('Location: lista-licitacoes.php');
    } else {
        die("Falha ao excluir licitação.");
    }

    // Após a edição bem-sucedidad
    $_SESSION['licitacao_excluida'] = true;

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
        // Após uma falha na edição da licitação
        $_SESSION['licitacao_nao_excluida'] = true;
        // Redirecionar para a página de login se o usuário não for encontrado
        header('Location: login.php');
    }
    exit();
?>
