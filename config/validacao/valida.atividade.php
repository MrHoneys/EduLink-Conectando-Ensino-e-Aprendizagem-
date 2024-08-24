<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: ../login/login.php");
    exit(); // Certifique-se de sair do script após o redirecionamento
}

// Obtém o nome do aluno a partir da sessão
$nome_aluno = isset($_SESSION["nome"]) ? $_SESSION["nome"] : "Aluno";

// Incluir o arquivo de conexão com o banco de dados
require_once '../config.php';

// Definir variáveis e inicializar com valores vazios
$descricao = $_POST["descricao"];
$arquivo = $_FILES["arquivo"];

// Variáveis para o caminho dos arquivos
$video_path = "";
$imagem_path = "";

// Diretório para uploads (ajustar o caminho conforme necessário)
$upload_dir = "C:/xampp/htdocs/markteplace/uploads/";

// Verificar se o diretório de upload existe
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        die("Erro ao criar o diretório de uploads.");
    }
}

// Verificar se o arquivo é um vídeo ou imagem e processar
if (isset($arquivo) && $arquivo["error"] == 0) {
    $file_type = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));
    $file_path = $upload_dir . basename($arquivo["name"]);

    if (in_array($file_type, ["mp4", "avi", "mov"])) {
        $video_path = $file_path;
        if (move_uploaded_file($arquivo["tmp_name"], $video_path)) {
            // O vídeo foi enviado corretamente
        } else {
            echo "Erro ao enviar o vídeo.";
            exit();
        }
    } elseif (in_array($file_type, ["jpg", "jpeg", "png", "gif"])) {
        $imagem_path = $file_path;
        if (move_uploaded_file($arquivo["tmp_name"], $imagem_path)) {
            // A imagem foi enviada corretamente
        } else {
            echo "Erro ao enviar a imagem.";
            exit();
        }
    } else {
        echo "Tipo de arquivo não permitido.";
        exit();
    }
} else {
    echo "Nenhum arquivo enviado ou erro no envio.";
    exit();
}

// Inserir dados na tabela 'atividades'
$sql = "INSERT INTO atividades (nome, descricao, video, imagem, data_hora) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome_aluno, $descricao, $video_path, $imagem_path);

if ($stmt->execute()) {
    echo "Atividade publicada com sucesso!";
} else {
    echo "Erro ao publicar a atividade: " . $stmt->error;
}

// Fechar a conexão
$stmt->close();
$conn->close();

// Redirecionar para a página inicial ou onde preferir
header("Location: ../../index.php");
exit();
?>
