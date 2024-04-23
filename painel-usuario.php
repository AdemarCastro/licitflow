<?php
    session_start(); // Iniciando uma sessão

    // Duas opções para chamar um arquivo: include e require
    // Script que verifica se há um usuário logado
    include("scriptverificalogin.php");

    // Criar conexão com o banco de dados
    include("conexao.php");
    $conexao = conectar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar {
            background-color: #003366; /* Azul escuro */
        }
        .navbar-brand, .nav-link {
            color: #FFA500; /* Laranja corrida */
        }
        .container {
            margin-top: 20px;
        }
        .laranja {
            color: #FFA500
        }
    </style>
</head>
<body>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Painel do Usuário</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center">
                <p class="mr-3 mb-0 laranja"><?php echo $_SESSION['usuario']; ?></p>
                <a class="nav-link" href="scriptlogout.php">Logout</a>
            </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Olá, <?php echo $_SESSION['usuario']; ?> </h1>
                <p>Bem-vindo ao seu painel de usuário.</p>

                <?php
                    // Verificar se há uma mensagem de sucesso ou falha para exibir
                    if (isset($_SESSION['cadastrado']) && $_SESSION['cadastrado'] == true) {
                        echo '<div class="alert alert-success" role="alert">Licitação cadastrada com sucesso!</div>';
                        // Limpar a variável de sessão para que a mensagem não seja exibida novamente
                        unset($_SESSION['cadastrado']);
                    } elseif (isset($_SESSION['nao_cadastrado']) && $_SESSION['nao_cadastrado'] == true) {
                        echo '<div class="alert alert-danger" role="alert">Título da licitação já cadastrado!</div>';
                        // Limpar a variável de sessão para que a mensagem não seja exibida novamente
                        unset($_SESSION['nao_cadastrado']);
                    }

                    // Verificar se há uma mensagem de sucesso para exibir
                    if (isset($_SESSION['licitacao_editada']) && $_SESSION['licitacao_editada'] == true) {
                        echo '<div class="alert alert-success" role="alert">Licitação editada com sucesso!</div>';
                        // Limpar a variável de sessão para que a mensagem não seja exibida novamente
                        unset($_SESSION['licitacao_editada']);
                    }

                    // Verificar se há uma mensagem de erro para exibir
                    if (isset($_SESSION['licitacao_nao_editada']) && $_SESSION['licitacao_nao_editada'] == true) {
                        echo '<div class="alert alert-danger" role="alert">Falha ao editar a licitação!</div>';
                        // Limpar a variável de sessão para que a mensagem não seja exibida novamente
                        unset($_SESSION['licitacao_nao_editada']);
                    }

                    // Verificar se há uma mensagem de sucesso ou falha para exibir
                    if (isset($_SESSION['licitacao_excluida']) && $_SESSION['licitacao_excluida'] == true) {
                        echo '<div class="alert alert-success" role="alert">Licitação exclída com sucesso!</div>';
                        // Limpar a variável de sessão para que a mensagem não seja exibida novamente
                        unset($_SESSION['licitacao_excluida']);
                    } elseif (isset($_SESSION['licitacao_nao_excluida']) && $_SESSION['licitacao_nao_excluida'] == true) {
                        echo '<div class="alert alert-danger" role="alert">Falha ao excluir licitação!</div>';
                        // Limpar a variável de sessão para que a mensagem não seja exibida novamente
                        unset($_SESSION['licitacao_nao_excluida']);
                    }
                ?>

            </div>
        </div>
    </div>

    <!-- Formulário de Cadastro de Licitação -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Cadastro de Licitação</h2>
                <form action="scriptcadastrolicitacao.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título da licitação" required>
                    </div>
                    <div class="form-group">
                        <label for="servico">Serviço</label>
                        <input type="text" class="form-control" id="servico" name="servico" placeholder="Descreva o serviço" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descreva a licitação" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="file" class="form-control-file" id="documento" name="documento" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Licitação</button>
                </form>
            </div>
        </div>
    </div>

    <?php
        // Consulta para buscar todas as licitações
        $buscarLicitacoes = $conexao->prepare("SELECT * FROM licitacoes");
        $buscarLicitacoes->execute();
        $licitacoes = $buscarLicitacoes->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Lista de Licitações -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Licitações Cadastradas</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Serviço</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($licitacoes as $licitacao): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($licitacao['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($licitacao['servico']); ?></td>
                                <td><?php echo htmlspecialchars($licitacao['descricao']); ?></td>
                                <td>
                                    <!-- <a href="uploads/<?php echo htmlspecialchars($licitacao['documento']); ?>" target="_blank" class="btn btn-primary">Documento</a> -->
                                    <a href="scripteditarlicitacao.php?id=<?php echo htmlspecialchars($licitacao['id']); ?>" class="btn btn-warning">Editar</a>
                                    <a href="scriptexcluirlicitacao.php?id=<?php echo htmlspecialchars($licitacao['id']); ?>" class="btn btn-danger">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

