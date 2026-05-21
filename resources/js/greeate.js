import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('greeateAdmin', () => ({
        sidebarOpen: localStorage.getItem('greeate-sidebar') !== 'collapsed',
        mobileSidebar: false,
        darkMode: localStorage.getItem('greeate-dark') === 'true',

        toggleDark() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('greeate-dark', this.darkMode);
            document.documentElement.classList.toggle('dark', this.darkMode);
        },
    }));
});

window.toggleDark = function () {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('greeate-dark', isDark);
};

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]');
    if (csrf) {
        window.csrfToken = csrf.content;
    }
});

window.showToast = function (message, type = 'success') {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
};

if (typeof window.Echo !== 'undefined') {
    const userId = document.body?.dataset?.userId;
    if (userId) {
        window.Echo.private(`greeate.notifications.${userId}`).notification((notification) => {
            showToast(notification.title || 'New notification');
        });
    }
}
