document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const email = loginForm.email.value.trim();
            const password = loginForm.password.value.trim();
            let errors = [];

            if (!validateEmail(email)) {
                errors.push('Please enter a valid email.');
            }
            if (password.length === 0) {
                errors.push('Password is required.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', function (e) {
            const name = signupForm.name.value.trim();
            const email = signupForm.email.value.trim();
            const password = signupForm.password.value.trim();
            let errors = [];

            if (name.length === 0) {
                errors.push('Name is required.');
            }
            if (!validateEmail(email)) {
                errors.push('Please enter a valid email.');
            }
            if (password.length < 6) {
                errors.push('Password must be at least 6 characters.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }
});
