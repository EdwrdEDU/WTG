<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>WTG? - Where To Go? Find Events Near You</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link href="{{ asset('css/signup.css') }}" rel="stylesheet">
  <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
  <link href="{{ asset('css/contacts.css') }}" rel="stylesheet">
  <link href="{{ asset('css/create-event.css') }}" rel="stylesheet">
  <link href="{{ asset('css/contacts.css') }}" rel="stylesheet">
  <link href="{{ asset('css/help-center.css') }}" rel="stylesheet">
  <link href="{{ asset('css/search-page.css') }}" rel="stylesheet">
  <link href="{{ asset('css/settings.css') }}" rel="stylesheet">
  <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
  <link href="{{ asset('css/edit.css') }}" rel="stylesheet">
  <link href="{{ asset('css/show.css') }}" rel="stylesheet">
  <link href="{{ asset('css/contact-organizer-modal.css') }}" rel="stylesheet">
</head>
<body>
  
  <nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <!-- Brand - Always visible -->
    <a class="navbar-brand" href="/home">WTG?</a>
    
    <!-- Search Form - Hidden on mobile -->
    <form class="d-flex navbar-search-form" role="search" action="{{ route('events.search') }}" method="GET">
      <input class="form-control" type="search" name="event" placeholder="Search Events" aria-label="Search"/>
      <div class="vr mx-3" style="background-color: white;"></div>
      <div class="d-flex align-items-center">
        <span class="me-2">
          <i class="bi bi-geo-alt text-white"></i>
        </span>
        <input class="form-control" type="search" name="location" placeholder="Location" aria-label="Search"/>
      </div>
      <button type="submit" class="btn">
        <i class="bi bi-search text-white"></i>
      </button>
    </form>
    
    <!-- Toggler Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Collapsible Content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Mobile Search Form - Only visible on mobile -->
      <div class="mobile-search-container d-lg-none">
        <form class="mobile-search-form" action="{{ route('events.search') }}" method="GET">
          <input class="form-control" type="search" name="event" placeholder="Search Events" aria-label="Search"/>
          <div class="search-row">
            <div class="location-input-group">
              <i class="bi bi-geo-alt"></i>
              <input class="form-control" type="search" name="location" placeholder="Location" aria-label="Location"/>
            </div>
            <button type="submit" class="btn">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      
      <!-- Navigation Links -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap: 15px; display: flex;">
        <!-- Always visible -->
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/contacts">Contact Us</a>
        </li>
        
        <!-- Only show when logged in -->
        @auth
        <li class="nav-item">
          <a class="nav-link" href="/events/create">Create Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/dashboard">Dashboard</a>
        </li>
        @endauth
        
        <!-- Always visible -->
        <li class="nav-item">
          <a class="nav-link" href="/help-center">Help Center</a>
        </li>
        
        <!-- Only show when NOT logged in -->
        @guest
        <li class="nav-item">
          <a class="nav-link" href="/account/login">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/account/create">Sign Up</a>
        </li>
        @endguest

        <!-- Only show when logged in -->
        @auth
        <!-- Notification Bell -->
        <li class="nav-item dropdown me-2">
          <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell fs-5"></i>
            @if(auth()->user()->unread_notifications_count > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="font-size: 0.7rem;">
                {{ auth()->user()->unread_notifications_count }}
              </span>
            @endif
          </a>
          <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
            <li class="dropdown-header d-flex justify-content-between align-items-center">
              <span><i class="bi bi-bell me-1"></i>Notifications</span>
              <a href="{{ route('notifications.index') }}" class="small text-primary text-decoration-none">View All</a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="{{ route('notifications.settings') }}">
                <i class="bi bi-bell me-2"></i>Notification Settings
              </a>
            </li>
            <div id="notification-dropdown-content">
              <!-- Notifications will be loaded here via JavaScript -->
              <li class="dropdown-item-text text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 small text-muted">Loading notifications...</div>
              </li>
            </div>
          </ul>
        </li>

        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none; border-radius: 50%; width: 52px; height: 40px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <i class="bi bi-person-circle fs-3"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <div class="dropdown-item-text">
                <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong>
                <br><small class="text-muted">{{ Auth::user()->email }}</small>
              </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="/dashboard">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="/saved-events">
                <i class="bi bi-bookmark me-2"></i>Saved Events
                @if(auth()->user()->savedEvents()->count() > 0)
                  <span class="badge bg-secondary ms-2">{{ auth()->user()->savedEvents()->count() }}</span>
                @endif
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="/my-events">
                <i class="bi bi-calendar-event me-2"></i>My Events
                @if(auth()->user()->events()->count() > 0)
                  <span class="badge bg-primary ms-2">{{ auth()->user()->events()->count() }}</span>
                @endif
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('notifications.index') }}">
                <i class="bi bi-bell me-2"></i>Notifications
                @if(auth()->user()->unread_notifications_count > 0)
                  <span class="badge bg-danger ms-2">{{ auth()->user()->unread_notifications_count }}</span>
                @endif
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="/account/edit">
                <i class="bi bi-gear me-2"></i>Account Settings
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('notifications.settings') }}">
                <i class="bi bi-bell-gear me-2"></i>Notification Settings
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('account.logout') }}">
                @csrf
                <button class="dropdown-item text-danger" type="submit">
                  <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
              </form>
            </li>
          </ul>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

  <!-- Main Content -->
  <div class="main-content">
    {{ $slot }}
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>WTG?</h5>
          <p>Where To Go? Find the best events near you.</p>
        </div>
        <div class="col-md-3">
          <h5>Find Events</h5>
          <ul class="list-unstyled">
            <li><a href="/events/location" class="text-white-50">Browse by location</a></li>
            <li><a href="/events/category" class="text-white-50">Browse by category</a></li>
            <li><a href="/events/featured" class="text-white-50">Featured events</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>Organize</h5>
          <ul class="list-unstyled">
            <li><a href="/create-events" class="text-white-50">Create an event</a></li>
            <li><a href="/pricing" class="text-white-50">Pricing</a></li>
            <li><a href="/resources" class="text-white-50">Resources</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>Help</h5>
          <ul class="list-unstyled">
            <li><a href="/help-center" class="text-white-50">Help Center</a></li>
            <li><a href="/contact-us" class="text-white-50">Contact Us</a></li>
            <li><a href="/privacy-policy" class="text-white-50">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
      <hr class="my-4">
      <div class="d-flex justify-content-between align-items-center">
        <span>© 2025 WTG? All rights reserved.</span>
        <div>
          <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"></script>
  <script src="{{ asset('js/help-center.js') }}"></script>

  <!-- Custom Styles -->
  <style>
    /* Notification Dropdown Styles */
    .notification-dropdown {
      border: none;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      border-radius: 0.5rem;
    }

    .notification-dropdown-item {
      padding: 12px 16px;
      border-bottom: 1px solid #f1f3f4;
      cursor: pointer;
      transition: background-color 0.2s ease;
      display: block !important;
    }

    .notification-dropdown-item:hover {
      background-color: #f8f9fa;
    }

    .notification-dropdown-item:last-child {
      border-bottom: none;
    }

    .notification-icon {
      width: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 2px;
    }

    .notification-badge {
      font-size: 0.7rem;
      padding: 0.2em 0.4em;
    }

    .notification-content {
      max-width: 260px;
    }

    .notification-title {
      font-weight: 600;
      font-size: 0.9rem;
      margin-bottom: 2px;
      line-height: 1.2;
    }

    .notification-message {
      font-size: 0.8rem;
      color: #6c757d;
      line-height: 1.3;
      margin-bottom: 4px;
    }

    .notification-time {
      font-size: 0.75rem;
      color: #9ca3af;
    }

    /* Enhanced Save Button Styles */
    .save-event-btn, .save-external-event-btn {
      transition: all 0.2s ease;
      border-width: 2px;
      opacity: 0.9;
    }

    .save-event-btn:hover, .save-external-event-btn:hover {
      transform: scale(1.05);
      opacity: 1;
    }

    .save-event-btn.saved, .save-external-event-btn.saved {
      background-color: #dc3545;
      border-color: #dc3545;
      color: white;
    }

    .save-event-btn.saved:hover, .save-external-event-btn.saved:hover {
      background-color: #bb2d3b;
      border-color: #bb2d3b;
    }

    /* Dropdown improvements */
    .dropdown-menu {
      border: none;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
      transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
    }

    /* Badge animations */
    .badge {
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    /* Loading states */
    .spinner-border-sm {
      width: 1rem;
      height: 1rem;
    }

    /* Toast container */
    .toast-container {
      z-index: 1055;
    }
  </style>

  <script>
    if (performance.navigation.type === 2) {
      location.reload();
    }

    // Track buttons currently being processed to prevent duplicate requests
    const processingButtons = new Set();

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize save buttons with event delegation
        initializeSaveButtons();
        
        // Check saved status for all events on page load
        if (isLoggedIn()) {
            checkSavedStatus();
        }

        // Initialize notification system
        initializeNotifications();
    });

    // ==================== NOTIFICATION SYSTEM ====================
    function initializeNotifications() {
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationContent = document.getElementById('notification-dropdown-content');
        
        if (notificationDropdown) {
            notificationDropdown.addEventListener('click', function() {
                loadNotifications();
            });
        }
        
        // Auto-refresh notifications every 60 seconds
        if (isLoggedIn()) {
            setInterval(updateNotificationBadge, 60000);
            
            // Initial load
            setTimeout(updateNotificationBadge, 2000);
        }
    }

    function loadNotifications() {
        fetch('/notifications/unread')
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('notification-dropdown-content');
            
            if (data.notifications && data.notifications.length > 0) {
                let html = '';
                
                data.notifications.slice(0, 6).forEach(notification => {
                    const icon = getNotificationIcon(notification.type);
                    const truncatedMessage = notification.message.length > 80 
                        ? notification.message.substring(0, 80) + '...' 
                        : notification.message;
                    
                    html += `
                        <li class="dropdown-item notification-dropdown-item" onclick="markAsReadAndRedirect(${notification.id}, '${notification.saved_event?.display_url || '#'}')">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon me-2">
                                    <i class="${icon}"></i>
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <div class="notification-title">${notification.title}</div>
                                    <div class="notification-message">${truncatedMessage}</div>
                                    <div class="notification-time">${timeAgo(notification.created_at)}</div>
                                </div>
                            </div>
                        </li>
                    `;
                });
                
                if (data.count > 6) {
                    html += `
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-item text-center">
                            <a href="/notifications" class="text-primary small text-decoration-none">
                                View all ${data.count} notifications
                            </a>
                        </li>
                    `;
                }
                
                content.innerHTML = html;
            } else {
                content.innerHTML = `
                    <li class="dropdown-item-text text-center text-muted py-4">
                        <i class="bi bi-bell-slash fs-4 d-block mb-2"></i>
                        <div>No new notifications</div>
                        <small>We'll notify you about your saved events here</small>
                    </li>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notification-dropdown-content').innerHTML = `
                <li class="dropdown-item-text text-center text-danger py-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    <div>Error loading notifications</div>
                </li>
            `;
        });
    }

    function getNotificationIcon(type) {
        switch(type) {
            case 'event_reminder':
                return 'bi bi-bell text-primary';
            case 'event_tomorrow':
                return 'bi bi-calendar-date text-warning';
            case 'event_today':
                return 'bi bi-calendar-check text-success';
            case 'event_update':
                return 'bi bi-info-circle text-info';
            case 'test':
                return 'bi bi-check-circle text-success';
            default:
                return 'bi bi-bell text-secondary';
        }
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        const intervals = {
            year: 31536000,
            month: 2592000,
            week: 604800,
            day: 86400,
            hour: 3600,
            minute: 60
        };
        
        for (const [unit, secondsInUnit] of Object.entries(intervals)) {
            const interval = Math.floor(seconds / secondsInUnit);
            if (interval >= 1) {
                return `${interval} ${unit}${interval !== 1 ? 's' : ''} ago`;
            }
        }
        
        return 'Just now';
    }

    function markAsReadAndRedirect(notificationId, url) {
        // Mark as read
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(() => {
            updateNotificationBadge();
            // Redirect to event if URL exists
            if (url && url !== '#' && url !== 'null') {
                if (url.startsWith('http')) {
                    window.open(url, '_blank');
                } else {
                    window.location.href = url;
                }
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    function updateNotificationBadge() {
        fetch('/notifications/unread')
        .then(response => response.json())
        .then(data => {
            const badges = document.querySelectorAll('.notification-badge');
            badges.forEach(badge => {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline';
                } else {
                    badge.style.display = 'none';
                }
            });

            // Update dropdown menu badges
            const dropdownBadges = document.querySelectorAll('.dropdown-menu .badge');
            dropdownBadges.forEach(badge => {
                if (badge.classList.contains('bg-danger')) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
        })
        .catch(error => console.error('Error updating notification badge:', error));
    }

    // ==================== SAVE EVENTS SYSTEM ====================
    function initializeSaveButtons() {
        // Use event delegation to avoid duplicate listeners
        document.body.removeEventListener('click', handleSaveButtonClick);
        document.body.addEventListener('click', handleSaveButtonClick);
    }

    function handleSaveButtonClick(e) {
        // Handle local event save buttons
        if (e.target.closest('.save-event-btn')) {
            e.preventDefault();
            e.stopPropagation();
            
            const button = e.target.closest('.save-event-btn');
            const eventId = button.getAttribute('data-event-id');
            const buttonId = eventId + '_local';
            
            if (processingButtons.has(buttonId) || button.disabled) {
                return;
            }
            
            const isSaved = button.classList.contains('saved');
            
            if (isSaved) {
                unsaveLocalEvent(eventId, button);
            } else {
                saveLocalEvent(eventId, button);
            }
        }
        
        // Handle external event save buttons
        if (e.target.closest('.save-external-event-btn')) {
            e.preventDefault();
            e.stopPropagation();
            
            const button = e.target.closest('.save-external-event-btn');
            const eventId = button.getAttribute('data-event-id');
            const buttonId = eventId + '_external';
            
            if (processingButtons.has(buttonId) || button.disabled) {
                return;
            }
            
            const isSaved = button.classList.contains('saved');
            
            if (isSaved) {
                unsaveExternalEvent(button);
            } else {
                saveExternalEvent(button);
            }
        }
    }

    function saveLocalEvent(eventId, button) {
        if (!isLoggedIn()) {
            showLoginPrompt();
            return;
        }

        const buttonId = eventId + '_local';
        
        if (processingButtons.has(buttonId)) {
            return;
        }
        
        processingButtons.add(buttonId);
        button.disabled = true;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="bi bi-heart-fill"></i>';
        
        fetch(`/events/${eventId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.add('saved', 'btn-danger');
                button.classList.remove('btn-outline-danger');
                button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                button.title = 'Remove from saved';
                showToast(data.message, 'success');
                updateNotificationBadge(); // Update notification badge
            } else {
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalHtml;
            showToast('Failed to save event. Please try again.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            processingButtons.delete(buttonId);
        });
    }

    function unsaveLocalEvent(eventId, button) {
        const buttonId = eventId + '_local';
        
        if (processingButtons.has(buttonId)) {
            return;
        }
        
        processingButtons.add(buttonId);
        button.disabled = true;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="bi bi-heart"></i>';
        
        fetch(`/events/${eventId}/unsave`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.remove('saved', 'btn-danger');
                button.classList.add('btn-outline-danger');
                button.innerHTML = '<i class="bi bi-heart"></i>';
                button.title = 'Save Event';
                showToast(data.message, 'success');
            } else {
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalHtml;
            showToast('Failed to remove event. Please try again.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            processingButtons.delete(buttonId);
        });
    }

    function saveExternalEvent(button) {
        if (!isLoggedIn()) {
            showLoginPrompt();
            return;
        }

        const eventId = button.getAttribute('data-event-id');
        const buttonId = eventId + '_external';
        
        if (processingButtons.has(buttonId)) {
            return;
        }
        
        processingButtons.add(buttonId);
        button.disabled = true;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="bi bi-heart-fill"></i>';
        
        const eventData = {
            event_id: eventId,
            event_name: button.getAttribute('data-event-name'),
            event_url: button.getAttribute('data-event-url'),
            event_image: button.getAttribute('data-event-image'),
            event_date: button.getAttribute('data-event-date'),
            venue_name: button.getAttribute('data-venue-name'),
            venue_address: button.getAttribute('data-venue-address'),
            price_info: button.getAttribute('data-price-info')
        };
        
        fetch('/saved-events/external', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(eventData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.add('saved', 'btn-danger');
                button.classList.remove('btn-outline-danger');
                button.title = 'Remove from saved';
                showToast(data.message, 'success');
                updateNotificationBadge(); // Update notification badge
            } else {
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalHtml;
            showToast('Failed to save event. Please try again.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            processingButtons.delete(buttonId);
        });
    }

    function unsaveExternalEvent(button) {
        const eventId = button.getAttribute('data-event-id');
        const buttonId = eventId + '_external';
        
        if (processingButtons.has(buttonId)) {
            return;
        }
        
        processingButtons.add(buttonId);
        button.disabled = true;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="bi bi-heart"></i>';
        
        const eventData = {
            event_id: eventId
        };
        
        fetch('/saved-events/external', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(eventData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.remove('saved', 'btn-danger');
                button.classList.add('btn-outline-danger');
                button.title = 'Save Event';
                showToast(data.message, 'success');
            } else {
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalHtml;
            showToast('Failed to remove event. Please try again.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            processingButtons.delete(buttonId);
        });
    }

    function checkSavedStatus() {
        // Check local events
        document.querySelectorAll('.save-event-btn').forEach(button => {
            const eventId = button.getAttribute('data-event-id');
            
            fetch('/saved-events/check', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    event_id: eventId,
                    type: 'local'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.saved) {
                    button.classList.add('saved', 'btn-danger');
                    button.classList.remove('btn-outline-danger');
                    button.innerHTML = '<i class="bi bi-heart-fill"></i> Saved';
                    button.title = 'Remove from saved';
                }
            })
            .catch(error => console.error('Error checking saved status:', error));
        });
        
        // Check external events
        document.querySelectorAll('.save-external-event-btn').forEach(button => {
            const eventId = button.getAttribute('data-event-id');
            
            fetch('/saved-events/check', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    event_id: eventId,
                    type: 'external'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.saved) {
                    button.classList.add('saved', 'btn-danger');
                    button.classList.remove('btn-outline-danger');
                    button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    button.title = 'Remove from saved';
                }
            })
            .catch(error => console.error('Error checking saved status:', error));
        });
    }

    function isLoggedIn() {
        // Check if user is authenticated
        return document.querySelector('.navbar .dropdown-toggle') !== null;
    }

    function showLoginPrompt() {
        if (confirm('Please log in to save events. Would you like to go to the login page?')) {
            window.location.href = '/account/login';
        }
    }

    function showToast(message, type = 'success') {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '1055';
            document.body.appendChild(toastContainer);
        }
        
        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
        
        const toastHTML = `
            <div id="${toastId}" class="toast ${bgClass} text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header ${bgClass} text-white border-0">
                    <i class="${icon} me-2"></i>
                    <strong class="me-auto">WTG?</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        const toast = document.getElementById(toastId);
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 4000
        });
        bsToast.show();
        
        // Remove toast after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }

    // ==================== UTILITY FUNCTIONS ====================
    
    // Function for dynamically added content (called from homepage.blade.php)
    function initializeSaveButtonsForContainer(container) {
        // This function doesn't need to do anything since we're using event delegation
        // The event delegation in initializeSaveButtons() will handle all buttons automatically
        console.log('Save buttons initialized for new content via event delegation');
    }

    // Global notification functions for other pages to use
    window.updateNotificationBadge = updateNotificationBadge;
    window.showToast = showToast;
    window.markAsReadAndRedirect = markAsReadAndRedirect;
  </script>

  <!-- Additional Notification Features -->
  <script>
    // Show welcome notification for new users (optional)
    document.addEventListener('DOMContentLoaded', function() {
        // Check if this is a new user's first visit
        if (isLoggedIn() && localStorage.getItem('welcomeShown') !== 'true') {
            setTimeout(() => {
                showToast('Welcome to WTG?! Save events to get personalized reminders.', 'success');
                localStorage.setItem('welcomeShown', 'true');
            }, 2000);
        }

        // Show notification about saved events count if user has many
        if (isLoggedIn()) {
            const savedEventsBadge = document.querySelector('.dropdown-item[href="/saved-events"] .badge');
            if (savedEventsBadge && parseInt(savedEventsBadge.textContent) >= 5) {
                setTimeout(() => {
                    showToast(`You have ${savedEventsBadge.textContent} saved events! Check your notifications for reminders.`, 'success');
                }, 3000);
            }
        }
    });

    

    // Handle page visibility change to refresh notifications
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible' && isLoggedIn()) {
            updateNotificationBadge();
        }
    });

    // Keyboard shortcuts for notifications (optional)
    document.addEventListener('keydown', function(e) {
        // Alt + N to open notifications
        if (e.altKey && e.key === 'n' && isLoggedIn()) {
            e.preventDefault();
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.click();
            }
        }
    });

    // Handle browser notifications (if permission granted)
    function requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    showToast('Browser notifications enabled! You\'ll get event reminders even when WTG? is closed.', 'success');
                }
            });
        }
    }

    // Show browser notification for important events
    function showBrowserNotification(title, message, icon = '/favicon.ico') {
        if ('Notification' in window && Notification.permission === 'granted') {
            const notification = new Notification(title, {
                body: message,
                icon: icon,
                badge: '/favicon.ico',
                tag: 'wtg-event-reminder'
            });

            notification.onclick = function() {
                window.focus();
                notification.close();
            };

            setTimeout(() => {
                notification.close();
            }, 5000);
        }
    }

    // Auto-request notification permission after user saves first event
    let hasRequestedPermission = false;
    document.addEventListener('click', function(e) {
        if (!hasRequestedPermission && (e.target.closest('.save-event-btn') || e.target.closest('.save-external-event-btn'))) {
            hasRequestedPermission = true;
            setTimeout(() => {
                if ('Notification' in window && Notification.permission === 'default') {
                    if (confirm('Would you like to enable browser notifications for event reminders? This will help you never miss an event!')) {
                        requestNotificationPermission();
                    }
                }
            }, 2000);
        }
    });
  </script>

</body>
</html>