export default function confirmPassword() {
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('form');

        form.addEventListener('submit', function (event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;

            if (password !== confirmPassword) {
                const errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback');
                errorSpan.innerHTML = '<strong>Le password non corrispondono.</strong>';

                const confirmPasswordField = document.getElementById('password-confirm');
                confirmPasswordField.classList.add('is-invalid');
                confirmPasswordField.parentNode.appendChild(errorSpan);

                event.preventDefault();
            }
        });
    });
}