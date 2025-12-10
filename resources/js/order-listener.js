import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true
});

const metaUserId = document.head.querySelector('meta[name="user-id"]');
const userId = metaUserId ? metaUserId.content : null;

window.Echo.private(`user.${userId}`)
    .listen('.order.status.updated', (e) => {
        alert(e.message);
    });