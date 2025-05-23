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
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="/home">WTG?</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <form class="d-flex" role="search" action="{{ url('/search/page') }}" method="GET">
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
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
          <a class="nav-link" href="/help-center">
              Help Center
          </a>
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none; border-radius: 50%; width: 52px; height: 40px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
              <i class="bi bi-person-circle fs-3"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li>
                <div class="dropdown-item-text">
                  <small>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</small>
                </div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="/dashboard">
                  <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/profile">
                  <i class="bi bi-person me-2"></i>Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/saved-events">
                  <i class="bi bi-bookmark me-2"></i>Saved Events
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/my-events">
                  <i class="bi bi-calendar-event me-2"></i>My Events
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/settings">
                  <i class="bi bi-gear me-2"></i>Settings
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('account.logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">
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
  <footer class="bg-dark text-white py-5">
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
  <script>
    if (performance.navigation.type === 2) {
      location.reload();
    }

document.addEventListener('DOMContentLoaded', function() {
    // Initialize save buttons
    initializeSaveButtons();
    
    // Check saved status for all events on page load
    if (isLoggedIn()) {
        checkSavedStatus();
    }
});

function initializeSaveButtons() {
    // Handle local event save buttons
    document.querySelectorAll('.save-event-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const eventId = this.getAttribute('data-event-id');
            const isSaved = this.classList.contains('saved');
            
            if (isSaved) {
                unsaveLocalEvent(eventId, this);
            } else {
                saveLocalEvent(eventId, this);
            }
        });
    });

    // Handle external event save buttons
    document.querySelectorAll('.save-external-event-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isSaved = this.classList.contains('saved');
            
            if (isSaved) {
                unsaveExternalEvent(this);
            } else {
                saveExternalEvent(this);
            }
        });
    });
}

function saveLocalEvent(eventId, button) {
    if (!isLoggedIn()) {
        showLoginPrompt();
        return;
    }

    button.disabled = true;
    const originalHtml = button.innerHTML;
    button.innerHTML = '<i class="bi bi-heart-fill"></i> Saving...';
    
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
            button.innerHTML = '<i class="bi bi-heart-fill"></i> Saved';
            button.title = 'Remove from saved';
            showToast(data.message, 'success');
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
    });
}

function unsaveLocalEvent(eventId, button) {
    button.disabled = true;
    const originalHtml = button.innerHTML;
    button.innerHTML = '<i class="bi bi-heart"></i> Removing...';
    
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
            button.innerHTML = '<i class="bi bi-heart"></i> Save Event';
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
    });
}

function saveExternalEvent(button) {
    if (!isLoggedIn()) {
        showLoginPrompt();
        return;
    }

    button.disabled = true;
    button.innerHTML = '<i class="bi bi-heart-fill"></i>';
    
    const eventData = {
        event_id: button.getAttribute('data-event-id'),
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
        } else {
            button.innerHTML = '<i class="bi bi-heart"></i>';
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = '<i class="bi bi-heart"></i>';
        showToast('Failed to save event. Please try again.', 'error');
    })
    .finally(() => {
        button.disabled = false;
    });
}

function unsaveExternalEvent(button) {
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-heart"></i>';
    
    const eventData = {
        event_id: button.getAttribute('data-event-id')
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
            button.innerHTML = '<i class="bi bi-heart-fill"></i>';
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = '<i class="bi bi-heart-fill"></i>';
        showToast('Failed to remove event. Please try again.', 'error');
    })
    .finally(() => {
        button.disabled = false;
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
        document.body.appendChild(toastContainer);
    }
    
    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast ${type === 'success' ? 'bg-success' : 'bg-danger'} text-white" role="alert">
            <div class="toast-header">
                <strong class="me-auto">WTG?</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toast = document.getElementById(toastId);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}
  </script>

<!-- Save Button Styles -->
<style>
.save-event-btn, .save-external-event-btn {
    transition: all 0.2s ease;
    border-width: 2px;
}

.save-event-btn:hover, .save-external-event-btn:hover {
    transform: scale(1.05);
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
</style>

</body>
</html>