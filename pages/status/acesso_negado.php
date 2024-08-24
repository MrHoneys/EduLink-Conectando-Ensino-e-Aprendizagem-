<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACESSO NEGADO!</title>
    <!-- Link para o CSS do Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .card-header {
            background-color: #dc3545;
            color: #fff;
            border-radius: 10px 10px 0 0;
            font-size: 1.5rem;
        }
        .card-body {
            padding: 2rem;
        }
        .card-body p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .btn {
            background-color: #dc3545;
            border: none;
        }
        .btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="card w-50">
        <div class="card-header">
            ACESSO NEGADO
        </div>
        <div class="card-body">
            <h5 class="card-title">Ops! Você não tem permissão para acessar esta página.</h5>
            <p class="card-text">Por favor, entre em contato com o administrador do sistema se achar que isso é um erro.</p>
            <a href="../../index.php" class="btn btn-danger">Voltar à página inicial</a>
        </div>
    </div>

    <!-- Link para o JavaScript do Bootstrap e dependências -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
