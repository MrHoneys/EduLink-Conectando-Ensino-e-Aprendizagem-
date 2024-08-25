<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: pages/login/login.php");
    exit(); // Certifique-se de sair do script após o redirecionamento
}

// Obtém o nome do aluno a partir da sessão
$nome_aluno = isset($_SESSION["nome"]) ? $_SESSION["nome"] : "Aluno";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../source/css/student.css">
    <title>Área do Aluno - Postar Atividade</title>
</head>
<body>
    <!-- Header principal -->
    <header class="custom-header py-3">
        <div class="container text-center">
            <img src="../../source/img/logo/logo.png" alt="Logo Sistema" class="img-fluid custom-logo">
        </div>
    </header>

    <!-- Menu Secundário -->
    <nav class="custom-menu">
        <div class="container">
            <ul class="nav justify-content-center flex-wrap">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/student/student_postar_atividade.php">Publicar Tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../config/validacao/logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Área de Postagem -->
    <main class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Publicar Atividade</h2>
                <form action="../../config/validacao/valida.atividade.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nomeAluno" class="form-label">Nome do Aluno</label>
                        <input type="text" class="form-control" id="nomeAluno" name="nome_aluno" value="<?php echo htmlspecialchars($nome_aluno); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição da Atividade</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Descreva a atividade..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="arquivo" class="form-label">Anexar Arquivo (Imagem ou Vídeo)</label>
                        <input class="form-control" type="file" id="arquivo" name="arquivo" accept="image/*,video/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
