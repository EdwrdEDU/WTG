<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Notifications</h1>
            <div class="d-flex gap-2">
                <button id="markAllReadBtn" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-check-all"></i> Mark All Read
                </button>
                <span class="badge bg-primary fs-6">{{ $unreadCount }} unread</span>
            </div>
        </div>

        @if($notifications->count() > 0)
            <div class="notification-list">
                @foreach($notifications as $notification)
                    <div class="notification-item {{ $notification->is_unread ? 'unread' : 'read' }}" 
                         data-notification-id="{{ $notification->id }}">
                        <div class="notification-content">
                            <div class="notification-header">
                                <div class="notification-icon">
                                    @switch($notification->type)
                                        @case('event_reminder')
                                            <i class="bi bi-bell text-primary"></i>
                                            @break
                                        @case('event_tomorrow')
                                            <i class="bi bi-calendar-date text-warning"></i>
                                            @break
                                        @case('event_today')
                                            <i class="bi bi-calendar-check text-success"></i>
                                            @break
                                        @case('event_update')
                                            <i class="bi bi-info-circle text-info"></i>
                                            @break
                                        @default
                                            <i class="bi bi-bell text-secondary"></i>
                                    @endswitch
                                </div>
                                <div class="notification-title">
                                    <h6 class="mb-0">{{ $notification->title }}</h6>
                                    <small class="text-muted">{{ $notification->time_ago }}</small>
                                </div>
                                <div class="notification-actions">
                                    @if($notification->is_unread)
                                        <button class="btn btn-sm btn-outline-secondary mark-read-btn" 
                                                data-notification-id="{{ $notification->id }}"
                                                title="Mark as read">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-danger delete-notification-btn" 
                                            data-notification-id="{{ $notification->id }}"
                                            title="Delete notification">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-message">
                                <p class="mb-2">{{ $notification->message }}</p>
                                @if($notification->savedEvent && $notification->savedEvent->display_url)
                                    <a href="{{ $notification->savedEvent->display_url }}" 
                                       class="btn btn-sm btn-primary"
                                       @if($notification->savedEvent->is_external_event) target="_blank" @endif>
                                        View Event
                                        @if($notification->savedEvent->is_external_event)
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bell-slash" style="font-size: 3rem; color: #ccc;"></i>
                <h3>No notifications yet</h3>
                <p class="text-muted">When you save events, we'll send you reminders here!</p>
                <a href="{{ route('homepage') }}" class="btn btn-primary">Explore Events</a>
            </div>
        @endif
    </div>

        <!-- Notification Styles -->
    <style>
    .notification-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 12px;
        padding: 16px;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .notification-item.unread {
        border-left: 4px solid #007bff;
        background-color: #f8f9ff;
    }

    .notification-item.read {
        opacity: 0.8;
    }

    .notification-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 8px;
    }

    .notification-icon {
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .notification-title {
        flex-grow: 1;
    }

    .notification-actions {
        display: flex;
        gap: 6px;
    }

    .notification-message {
        margin-left: 32px;
    }

    .notification-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    </style>

    <!-- Notification JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark single notification as read
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const notificationId = this.dataset.notificationId;
                markAsRead(notificationId);
            });
        });

        // Mark all notifications as read
        document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
            markAllAsRead();
        });

        // Delete notification
        document.querySelectorAll('.delete-notification-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const notificationId = this.dataset.notificationId;
                deleteNotification(notificationId);
            });
        });
    });

    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                notificationItem.classList.remove('unread');
                notificationItem.classList.add('read');
                
                // Remove the mark as read button
                const markReadBtn = notificationItem.querySelector('.mark-read-btn');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
                
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all notification items
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    
                    const markReadBtn = item.querySelector('.mark-read-btn');
                    if (markReadBtn) {
                        markReadBtn.remove();
                    }
                });
                
                updateUnreadCount();
                showToast('All notifications marked as read', 'success');
            }
        })
        .catch(error => console.error('Error marking all notifications as read:', error));
    }

    function deleteNotification(notificationId) {
        if (!confirm('Are you sure you want to delete this notification?')) {
            return;
        }

        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                notificationItem.style.transition = 'opacity 0.3s ease';
                notificationItem.style.opacity = '0';
                
                setTimeout(() => {
                    notificationItem.remove();
                    updateUnreadCount();
                }, 300);
                
                showToast('Notification deleted', 'success');
            }
        })
        .catch(error => console.error('Error deleting notification:', error));
    }

    function updateUnreadCount() {
        const unreadItems = document.querySelectorAll('.notification-item.unread').length;
        const badge = document.querySelector('.badge');
        if (badge) {
            badge.textContent = `${unreadItems} unread`;
        }
        
        // Update navbar notification count if it exists
        const navNotificationBadge = document.querySelector('.notification-badge');
        if (navNotificationBadge) {
            if (unreadItems > 0) {
                navNotificationBadge.textContent = unreadItems;
                navNotificationBadge.style.display = 'inline';
            } else {
                navNotificationBadge.style.display = 'none';
            }
        }
    }

    function showToast(message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast ${type === 'success' ? 'bg-success' : 'bg-danger'} text-white position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 1050;';
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">WTG?</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">${message}</div>
        `;
        
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }
    </script>
</x-layout>