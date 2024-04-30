<?php
// Iniciar sessão
session_start();

// Verificar se o usuário está logado
include("scriptverificalogin.php");

// Conectar ao banco de dados
include("conexao.php");
$conexao = conectar();

// Verificar se o ID da licitação foi passado
if (!isset($_GET['id'])) {
    die("ID da licitação não fornecido.");
}

// Preparar e executar a consulta para buscar os detalhes da licitação
$id = $_GET['id'];
$buscarLicitacao = $conexao->prepare("SELECT * FROM licitacoes WHERE id = :id");
$buscarLicitacao->bindParam(':id', $id, PDO::PARAM_INT);
$buscarLicitacao->execute();
$licitacao = $buscarLicitacao->fetch(PDO::FETCH_ASSOC);

// Verificar se a licitação existe
if (!$licitacao) {
    die("Licitação não encontrada.");
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar a licitação no banco de dados
    $titulo = $_POST['titulo'];
    $servico = $_POST['servico'];
    $descricao = $_POST['descricao'];
    $documento = $_FILES['documento']['name'];

    // Mover o arquivo do documento para o diretório de uploads
    move_uploaded_file($_FILES['documento']['tmp_name'], 'uploads/' . $documento);

    // Preparar e executar a consulta de atualização
    $atualizarLicitacao = $conexao->prepare("UPDATE licitacoes SET titulo = :titulo, servico = :servico, descricao = :descricao, documento = :documento WHERE id = :id");
    $atualizarLicitacao->bindParam(':titulo', $titulo);
    $atualizarLicitacao->bindParam(':servico', $servico);
    $atualizarLicitacao->bindParam(':descricao', $descricao);
    $atualizarLicitacao->bindParam(':documento', $documento);
    $atualizarLicitacao->bindParam(':id', $id);
    $atualizarLicitacao->execute();

    // Após a edição bem-sucedidad
    $_SESSION['licitacao_editada'] = true;

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
                header('Location: index.php');
                break;
        }
    } else {
        // Após uma falha na edição da licitação
        $_SESSION['licitacao_nao_editada'] = true;
        // Redirecionar para a página de login se o usuário não for encontrado
        header('Location: index.php');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Licitação</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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

    <div class="container mt-5">
        <h1 class="mb-4">Editar Licitação</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo htmlspecialchars($licitacao['titulo']); ?>" required>
            </div>

            <div class="form-group">
                <label for="servico">Serviço:</label>
                <input type="text" class="form-control" name="servico" id="servico" value="<?php echo htmlspecialchars($licitacao['servico']); ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" name="descricao" id="descricao" rows="3" required><?php echo htmlspecialchars($licitacao['descricao']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="documento">Documento:</label>
                <input type="file" class="form-control-file" name="documento" id="documento">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Licitação</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

