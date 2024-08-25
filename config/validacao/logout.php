<?php
session_start(); // Inicia a sessão

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se houver um cookie de sessão, exclua-o
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Redireciona para a página de login ou página inicial
header("Location: ../../pages/login/login.php"); // Ou qualquer página para onde você queira redirecionar
exit;
?>
