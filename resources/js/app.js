

import 'bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* ── Dark mode toggle ── */
function initThemeToggle() {
    const buttons = document.querySelectorAll('[data-theme-toggle]');
    if (!buttons.length) return;

    function updateIcons() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        document.querySelectorAll('[data-theme-icon]').forEach((icon) => {
            icon.className = isDark ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
        });
    }

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            try {
                localStorage.setItem('theme', next);
            } catch (e) {}
            updateIcons();
        });
    });

    updateIcons();
}

document.addEventListener('DOMContentLoaded', initThemeToggle);
