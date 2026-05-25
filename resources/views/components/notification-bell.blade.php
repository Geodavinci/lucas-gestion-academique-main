@auth
<div class="relative" x-data="{ open: false, count: 0 }" @click.outside="open = false">
    <!-- Bell Icon -->
    <button
        @click="open = !open"
        class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <!-- Unread Count Badge -->
        <span
            id="notification-count"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full hidden">
            <span id="notification-count-text">0</span>
        </span>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
            <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                Voir tout
            </a>
        </div>

        <div id="notification-list" class="max-h-96 overflow-y-auto">
            <!-- Notifications will be loaded here via JavaScript -->
            <div class="px-4 py-3 text-center text-gray-500 text-sm">
                Chargement...
            </div>
        </div>

        <div class="px-4 py-2 border-t border-gray-200 text-center">
            <button
                onclick="markAllRead()"
                class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Marquer tout comme lu
            </button>
        </div>
    </div>
</div>

<script>
let notificationRefreshInterval;

function loadNotifications() {
    fetch('{{ route('notifications.recent') }}')
        .then(r => r.json())
        .then(notifications => {
            const list = document.getElementById('notification-list');
            const countBadge = document.getElementById('notification-count');
            const countText = document.getElementById('notification-count-text');

            // Count unread
            const unreadCount = notifications.filter(n => !n.read_at).length;
            countText.textContent = unreadCount;
            countBadge.classList.toggle('hidden', unreadCount === 0);

            // Render notifications
            if (notifications.length === 0) {
                list.innerHTML = '<div class="px-4 py-3 text-center text-gray-500 text-sm">Aucune notification</div>';
                return;
            }

            list.innerHTML = notifications.map(notif => `
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer" onclick="deleteNotification(${notif.id})">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">${notif.title}</p>
                            <p class="text-xs text-gray-600 mt-1">${notif.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${new Date(notif.created_at).toLocaleDateString('fr-FR', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</p>
                        </div>
                        ${!notif.read_at ? '<span class="ml-2 w-2 h-2 bg-blue-600 rounded-full mt-1"></span>' : ''}
                    </div>
                </div>
            `).join('');
        })
        .catch(err => console.error('Error loading notifications:', err));
}

function markAllRead() {
    fetch('{{ route('notifications.readAll') }}', {
        method: 'PATCH'
    })
    .then(() => {
        loadNotifications();
    });
}

function deleteNotification(id) {
    fetch(`/notifications/${id}`, {
        method: 'DELETE'
    })
    .then(() => loadNotifications());
}

// Load notifications on page load
document.addEventListener('DOMContentLoaded', () => {
    loadNotifications();
    // Refresh every 30 seconds
    notificationRefreshInterval = setInterval(loadNotifications, 30000);
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    clearInterval(notificationRefreshInterval);
});
</script>
@endauth
