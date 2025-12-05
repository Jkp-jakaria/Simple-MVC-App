document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const toggle = document.getElementById('theme-toggle');

    // Load saved theme
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark');
        if (toggle) toggle.checked = true;
    }

    if (!toggle) return;

    toggle.addEventListener('change', function () {
        if (toggle.checked) {
            body.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            body.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    });
});
