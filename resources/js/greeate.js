import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]');
    if (csrf) {
        window.csrfToken = csrf.content;
    }
});

window.showToast = (message, type = 'success') => {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
};

if (typeof window.Echo !== 'undefined') {
    const userId = document.body.dataset.userId;
    if (userId) {
        window.Echo.private(`greeate.notifications.${userId}`)
            .notification((notification) => {
                showToast(notification.title || 'New notification');
            });
    }
}
