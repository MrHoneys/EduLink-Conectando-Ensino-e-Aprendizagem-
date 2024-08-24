<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONECTA-SE ESCOLA DIGITAL</title>
    <!-- Link para o CSS do Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link para o CSS personalizado -->
    <link href="../../source/css/cadastro.css" rel="stylesheet">
</head>
<body>
    <div class="bubble" style="left: 20%;"></div>
    <div class="bubble" style="left: 40%;"></div>
    <div class="bubble" style="left: 60%;"></div>
    <div class="bubble" style="left: 80%;"></div>
    <div class="bubble" style="left: 50%;"></div>

    <div class="card">
        <div class="card-header">
            CONECTA-SE
        </div>
        <div class="card-body">
            <form id="loginForm" action="../../config/validacao/valida_login.php" method="post">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                    <small id="senhaError" class="form-text error-message"></small>
                </div>
                <button type="submit" class="btn btn-dark">Entrar</button>
                <small class="form-text text-muted">Não tem uma conta? <a href="cadastro.php">Cadastrar</a></small>
            </form>
        </div>
    </div>

    <!-- Link para o JavaScript do Bootstrap e dependências -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../source/js/valida_login.js"></script>
</body>
</html>
