<div id="notifications-container" class="fixed top-4 right-4 z-50 space-y-3 w-96 max-w-sm">
    <!-- Notifications will be dynamically inserted here -->
</div>

<script>
// Notification system
function showNotification(message, type = 'error', duration = 5000) {
    const container = document.getElementById('notifications-container');
    const notificationId = 'notification-' + Date.now();

    const notification = document.createElement('div');
    notification.id = notificationId;
    notification.className = `transform transition-all duration-300 ease-in-out translate-x-full opacity-0 w-full bg-white shadow-xl rounded-xl pointer-events-auto border overflow-hidden`;

    let bgColor, textColor, icon, borderColor;
    switch(type) {
        case 'success':
            bgColor = 'bg-green-50';
            textColor = 'text-green-800';
            borderColor = 'border-green-200';
            icon = `<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>`;
            break;
        case 'warning':
            bgColor = 'bg-yellow-50';
            textColor = 'text-yellow-800';
            borderColor = 'border-yellow-200';
            icon = `<svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>`;
            break;
        default: // error
            bgColor = 'bg-red-50';
            textColor = 'text-red-800';
            borderColor = 'border-red-200';
            icon = `<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>`;
    }

    notification.innerHTML = `
        <div class="p-4 ${bgColor} ${borderColor}">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    ${icon}
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-medium ${textColor} leading-5">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="inline-flex ${textColor} hover:opacity-75 focus:outline-none transition-opacity duration-200" onclick="dismissNotification('${notificationId}')">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

    container.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
        notification.classList.add('translate-x-0', 'opacity-100');
    }, 100);

    // Auto dismiss
    if (duration > 0) {
        setTimeout(() => {
            dismissNotification(notificationId);
        }, duration);
    }
}

function dismissNotification(id) {
    const notification = document.getElementById(id);
    if (notification) {
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
}

// Show session notifications - only run once
if (!window.notificationsInitialized) {
    window.notificationsInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showNotification('{{ $error }}', 'error');
            @endforeach
        @endif
    });
}
</script>
