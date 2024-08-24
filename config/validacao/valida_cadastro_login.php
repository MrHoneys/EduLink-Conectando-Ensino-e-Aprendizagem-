<?php
// Inclui o arquivo de configuração
include '../config.php';

// Obtém os dados do formulário
$nome = isset($_POST['nome']) ? $conn->real_escape_string($_POST['nome']) : '';
$senha = isset($_POST['senha']) ? $conn->real_escape_string($_POST['senha']) : '';

// Valida os dados
if (empty($nome) || empty($senha)) {
    echo "Nome e senha são obrigatórios.";
    exit;
}

// Define o cargo como "aluno"
$cargo = 'aluno';

// Prepara a query para inserção
$sql = "INSERT INTO usuarios (nome, senha, cargo) VALUES (?, ?, ?)";

// Prepara e executa a query
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

$stmt->bind_param("sss", $nome, $senha, $cargo);

if ($stmt->execute()) {
    // Redireciona para a página de login
    header('Location: ../../pages/login/login.php');
    exit(); // Importante para garantir que o script pare após o redirecionamento
}

// Fecha o statement e a conexão
$stmt->close();
$conn->close();
?>
