<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: pages/login/login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
require_once 'config/config.php';

// Processar o filtro de pesquisa
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Construir a consulta SQL com base no filtro de pesquisa
$sql = "SELECT id, nome, descricao, video, imagem, data_hora FROM atividades WHERE 1=1";

if ($searchQuery) {
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);
    $sql .= " AND (nome LIKE '%$searchQueryEscaped%' OR descricao LIKE '%$searchQueryEscaped%')";
}

if ($startDate && $endDate) {
    $startDateEscaped = $conn->real_escape_string($startDate);
    $endDateEscaped = $conn->real_escape_string($endDate);
    $sql .= " AND DATE(data_hora) BETWEEN '$startDateEscaped' AND '$endDateEscaped'";
}

$sql .= " ORDER BY data_hora DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

// Processar o envio de comentários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $atividade_id = isset($_POST['atividade_id']) ? intval($_POST['atividade_id']) : 0;
    $aluno_nome = isset($_POST['aluno_nome']) ? $conn->real_escape_string($_POST['aluno_nome']) : '';
    $comentario = isset($_POST['comentario']) ? $conn->real_escape_string($_POST['comentario']) : '';
    $data_hora = date('Y-m-d H:i:s');

    if ($atividade_id && $aluno_nome && $comentario) {
        $sql_insert = "INSERT INTO comentarios (atividade_id, aluno_nome, comentario, data_hora) VALUES ('$atividade_id', '$aluno_nome', '$comentario', '$data_hora')";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: index.php?search=" . urlencode($searchQuery) . "&start_date=" . urlencode($startDate) . "&end_date=" . urlencode($endDate)); // Redireciona para recarregar os comentários
            exit();
        } else {
            echo "<p>Erro: " . $conn->error . "</p>";
        }
    }
}

// Função para recuperar os comentários de uma atividade específica
function get_comments($atividade_id) {
    global $conn;
    $sql = "SELECT aluno_nome, comentario, data_hora FROM comentarios WHERE atividade_id = $atividade_id ORDER BY data_hora ASC";
    $result = $conn->query($sql);
    $comments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
    }
    return $comments;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="source/css/index.css">
    <title>Atividades dos Alunos</title>
</head>

<body>
    <!-- Header principal -->
    <header class="custom-header py-3">
        <div class="container text-center">
            <img src="source/img/logo/logo.png" alt="Logo Sistema" class="img-fluid custom-logo">
        </div>
    </header>

    <!-- Menu Secundário -->
    <nav class="custom-menu">
        <div class="container">
            <ul class="nav justify-content-center flex-wrap">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/student/student_postar_atividade.php">Publicar Tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="config/validacao/logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Filtro de Pesquisa -->
    <section class="search-container">
        <form method="GET" class="d-flex flex-column flex-md-row">
            <input type="text" name="search" class="form-control mb-2 mb-md-0" placeholder="Pesquisar por nome ou descrição" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="date" name="start_date" class="form-control mb-2 mb-md-0 ms-md-2" value="<?php echo htmlspecialchars($startDate); ?>">
            <input type="date" name="end_date" class="form-control mb-2 mb-md-0 ms-md-2" value="<?php echo htmlspecialchars($endDate); ?>">
            <button type="submit" class="btn btn-primary ms-md-2">Pesquisar</button>
        </form>
    </section>

    <!-- Feed de Atividades -->
    <main class="container my-5">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-light">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($row['nome']); ?>
                                    <span class="text-muted"><?php echo date('d/m/Y H:i', strtotime($row['data_hora'])); ?></span>
                                </h5>
                                <hr class="my-2">
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($row['descricao'])); ?></p>
                                <?php if (!empty($row['video'])): ?>
                                    <video controls class="custom-media">
                                        <source src="uploads/<?php echo htmlspecialchars(basename($row['video'])); ?>" type="video/mp4">
                                        Seu navegador não suporta a tag de vídeo.
                                    </video>
                                <?php elseif (!empty($row['imagem'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars(basename($row['imagem'])); ?>" class="custom-media" alt="Imagem">
                                <?php endif; ?>

                                <!-- Botão para abrir overlay de comentários -->
                                <button class="btn btn-primary mt-3" onclick="document.getElementById('overlay-<?php echo $row['id']; ?>').classList.toggle('open')">Ver Comentários</button>
                            </div>
                        </div>

                        <!-- Overlay de Comentários -->
                        <div id="overlay-<?php echo $row['id']; ?>" class="overlay">
                            <div class="overlay-content">
                                <button class="close-btn" onclick="document.getElementById('overlay-<?php echo $row['id']; ?>').classList.remove('open')">&times;</button>
                                <h4 class="overlay-title">Comentários</h4>
                                <div class="comments-container">
                                    <?php
                                    $comments = get_comments($row['id']);
                                    foreach ($comments as $comment):
                                    ?>
                                        <div class="comment">
                                            <strong><?php echo htmlspecialchars($comment['aluno_nome']); ?></strong>
                                            <p><?php echo nl2br(htmlspecialchars($comment['comentario'])); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <form method="POST" class="comment-form">
                                    <input type="hidden" name="atividade_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="aluno_nome" value="<?php echo htmlspecialchars($_SESSION['nome']); ?>">
                                    <div class="mb-3">
                                        <textarea name="comentario" class="form-control" rows="4" placeholder="Adicione um comentário..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Comentar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Nenhuma atividade encontrada.</p>
            <?php endif; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
