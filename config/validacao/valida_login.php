<?php
session_start();
include '../config.php'; // Inclua o arquivo de configuração para conectar ao banco de dados

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém e sanitiza os valores do formulário
    $nome = isset($_POST['nome']) ? $conn->real_escape_string($_POST['nome']) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Verifica se nome ou senha estão vazios
    if (empty($nome) || empty($senha)) {
        header("Location: ../pages/login.php?error=empty");
        exit;
    }

    // Consulta SQL para buscar o usuário pelo nome
    $sql = "SELECT id, nome, senha FROM usuarios WHERE nome = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nome); // Faz o bind do parâmetro
        $stmt->execute(); // Executa a consulta
        $stmt->store_result(); // Armazena o resultado

        // Verifica se encontrou um usuário com o nome fornecido
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $nome_db, $senha_db); // Faz o bind dos resultados
            $stmt->fetch(); // Obtém os resultados

            // Comparar a senha diretamente, pois está em texto simples
            if ($senha === $senha_db) {
                // Inicia a sessão e redireciona para a página principal
                $_SESSION["logado"] = true;
                $_SESSION["nome"] = $nome;

                header("Location: ../../index.php");
                exit();
            } else {
                // Se a senha estiver incorreta, redireciona com erro
                header("Location: ../../pages/login/login.php?error=invalid");
            }
        } else {
            // Se o nome não for encontrado, redireciona com erro
            header("Location: ../../pages/login/login.php?error=invalid");
        }
        $stmt->close(); // Fecha a declaração
    } else {
        // Se a preparação da consulta falhar, redireciona com erro genérico
        header("Location: ../../pages/login/login.php?error=error");
    }
}

$conn->close(); // Fecha a conexão com o banco de dados
?>
