document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    const formResponse = document.getElementById('form-response');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearErrors();

        const formData = new FormData(form);
        
        try {
            const response = await fetch('submit.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`Erro de comunicação com o servidor. Status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success') {
                formResponse.className = 'success';
                formResponse.textContent = result.message;
                form.reset();
            } else {
                formResponse.className = 'error';
                formResponse.textContent = result.message || 'Ocorreu um erro ao enviar o formulário.';
                if (result.errors) {
                    displayErrors(result.errors);
                }
            }
        } catch (error) {
            formResponse.className = 'error';
            formResponse.textContent = 'Erro de comunicação com o servidor. Tente novamente.';
            console.error('Fetch error:', error);
        }
    });

    function displayErrors(errors) {
        for (const field in errors) {
            const errorElement = document.getElementById(`error-${field}`);
            if (errorElement) {
                errorElement.textContent = errors[field];
            }
        }
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.textContent = '');
        formResponse.textContent = '';
        formResponse.className = '';
    }
});