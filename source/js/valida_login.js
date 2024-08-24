document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const errorMessageElement = document.getElementById('senhaError');

    if (error) {
        switch (error) {
            case 'empty':
                errorMessageElement.textContent = 'Nome e senha são obrigatórios.';
                break;
            case 'invalid':
                errorMessageElement.textContent = 'Usuário ou senha incorretos.';
                break;
            case 'error':
                errorMessageElement.textContent = 'Ocorreu um erro. Tente novamente mais tarde.';
                break;
            default:
                errorMessageElement.textContent = 'Erro desconhecido.';
        }
        errorMessageElement.style.display = 'block'; // Exibir a mensagem de erro
    }
});