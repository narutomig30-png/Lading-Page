document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contact-form');
    const formMessage = document.getElementById('form-message');

    // A função para carregar serviços foi removida, pois eles agora estão no HTML.

    if (!form) return;

    // Adiciona o listener para o envio do formulário
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Previne o envio padrão da página

        clearErrors();

        // Valida os campos no lado do cliente antes de enviar
        if (!validateClientSide()) {
            return;
        }

        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Enviando...';

        // Envia os dados do formulário para o submit.php
        fetch('submit.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            formMessage.textContent = data.message;
            formMessage.className = 'form-feedback ' + data.status;

            if (data.status === 'success') {
                form.reset(); // Limpa o formulário
            } else if (data.errors) {
                displayErrors(data.errors); // Mostra erros específicos retornados pelo PHP
            }
        })
        .catch(error => {
            console.error('Erro no envio do formulário:', error);
            formMessage.textContent = 'Erro de comunicação com o servidor. Tente novamente.';
            formMessage.className = 'form-feedback error';
        })
        .finally(() => {
            // Reabilita o botão de envio
            submitButton.disabled = false;
            submitButton.textContent = 'Enviar';
        });
    });

    // Função de validação do lado do cliente
    function validateClientSide() {
        let isValid = true;
        const fieldsToValidate = [
            { id: 'nome', message: 'O campo nome é obrigatório.' },
            { id: 'servico', message: 'Por favor, selecione um serviço.' }
        ];

        fieldsToValidate.forEach(field => {
            const input = document.getElementById(field.id);
            if (!input.value || input.value.trim() === '') {
                isValid = false;
                showError(input, field.message);
            }
        });

        const emailInput = document.getElementById('email');
        const emailValue = emailInput.value.trim();
        if (emailValue === '') {
            isValid = false;
            showError(emailInput, 'O campo email é obrigatório.');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
            isValid = false;
            showError(emailInput, 'Por favor, insira um email válido.');
        }

        return isValid;
    }

    // Funções auxiliares para mostrar e limpar erros
    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        formGroup.classList.add('error');
        const errorContainer = formGroup.querySelector('.error-message');
        if (errorContainer) {
            errorContainer.textContent = message;
            errorContainer.style.display = 'block';
        }
    }

    function clearErrors() {
        form.querySelectorAll('.form-group.error').forEach(group => {
            group.classList.remove('error');
        });
        form.querySelectorAll('.error-message').forEach(msg => {
            msg.style.display = 'none';
            msg.textContent = '';
        });
        formMessage.textContent = '';
        formMessage.className = 'form-feedback';
    }

    function displayErrors(errors) {
        for (const fieldName in errors) {
            const inputId = fieldName.replace('_id', '');
            const input = document.getElementById(inputId);
            if (input) {
                showError(input, errors[fieldName]);
            }
        }
    }
});