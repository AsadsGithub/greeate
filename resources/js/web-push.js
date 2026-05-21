async function registerGreeateWebPush() {
    if (!('Notification' in window) || !('serviceWorker' in navigator)) {
        return;
    }

    const permission = await Notification.requestPermission();
    if (permission !== 'granted') {
        return;
    }

    const token = window.FCM_TOKEN;
    if (!token || !window.csrfToken) {
        return;
    }

    await fetch('/api/v1/device-tokens', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken,
            Accept: 'application/json',
        },
        credentials: 'same-origin',
        body: JSON.stringify({ token, platform: 'web' }),
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.enableWebPush === 'true') {
        registerGreeateWebPush();
    }
});
