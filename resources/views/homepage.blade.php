<!-- homepage.blade.php -->
<x-layout>
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Popular Events</li>
    </ol>
  </nav>

  <!-- Hero Section -->
  <div class="hero-section" style="background-image: url('{{ asset('images/fred-again-london-slack-vndedikiow.jpg') }}')">
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title">Find amazing events near you</h1>
        <p class="hero-subtitle">Whether you're a local, a tourist or just cruising through, we've got loads of great tips and events. You can explore by location, what's popular, or our top picks.</p>
<a href="{{ url('/account/create') }}" class="location-btn">
  <i class="bi bi-geo-alt"></i>
  Find events nearby
</a>

      </div>
    </div>
  </div>

<div class="mt-5">
    <div class="section-title">
        Featured Events
        <a href="#events" class="explore-link">
            Explore more events
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="row">
        @forelse ($featuredEvents as $event)
            <div class="col-md-4">
                <div class="event-card">
                    <div class="position-relative">
                        <img src="{{ $event['images'][0]['url'] ?? 'default-image.jpg' }}" class="event-img" alt="Event image">
                        <span class="featured-badge">Featured</span>
                    </div>
                    <div class="p-3">
                        <div class="event-date">
                            {{ \Carbon\Carbon::parse($event['dates']['start']['dateTime'])->format('D, M j • g:i A') }}
                        </div>
                        <h3 class="event-title">{{ $event['name'] }}</h3>
                        <div class="event-location">
                            <i class="bi bi-geo-alt"></i>
                            {{ $event['_embedded']['venues'][0]['name'] ?? 'Location not available' }}
                        </div>
                        <a href="{{ $event['url'] ?? '#' }}" target="_blank" class="event-link">View Event</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No featured events available at this time.</p>
        @endforelse
    </div>
</div>

<!-- Popular Categories -->
<div class="mt-5 mb-5">
  <div class="section-title">
    Browse by Category
  </div>

  <div class="row">
    <div class="col-md-3 col-6 mb-4">
      <div class="category-card" data-category="Music">
        <i class="bi bi-music-note-beamed category-icon"></i>
        <h4 class="category-title">Music</h4>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-4">
      <div class="category-card" data-category="Sports">
        <i class="bi bi-bicycle category-icon"></i>
        <h4 class="category-title">Sports</h4>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-4">
      <div class="category-card" data-category="Arts & Theatre">
        <i class="bi bi-palette category-icon"></i>
        <h4 class="category-title">Arts & Theatre</h4>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-4">
      <div class="category-card" data-category="Miscellaneous">
        <i class="bi bi-list-ul category-icon"></i>
        <h4 class="category-title">Miscellaneous</h4>
      </div>
    </div>
  </div>
</div>

<!-- Event Results Section -->
<div id="event-results" class="mt-4">
  <!-- Dynamic event cards will be displayed here -->
</div>

<!-- Optional Loading Spinner -->
<div id="loading-spinner" style="display: none;" class="text-center">
  <div class="spinner-border text-primary" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

 <!-- Events Section -->
  <div id="events" class="events-section mt-5 mb-5">
    <!-- Event Categories -->
    <div class="category-tabs">
      <ul class="nav nav-tabs border-0">
        <li class="nav-item">
          <a class="nav-link active" href="#">All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">For you</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Online</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Today</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">This weekend</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Free</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Music</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Food & Drink</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Charity & Causes</a>
        </li>
      </ul>
    </div>
    
  <!-- Events Near You Section -->
<div class="section-title">
    Events Near You
    <a href="#" class="explore-link">
        Explore more events
        <i class="bi bi-arrow-right"></i>
    </a>
</div>

<div class="row">
    @foreach ($eventsNearYou as $event)
        <div class="col-md-3 mb-4">
            <div class="card event-card">
                <div class="position-relative">
                    <img src="{{ $event['images'][0]['url'] ?? asset('images/default-image.jpg') }}" class="card-img-top" alt="Event">
                </div>
                <div class="card-body p-3">
                    <h5 class="card-title">{{ $event['name'] }}</h5>

                    <p class="card-text text-muted">
                        @if(isset($event['dates']['start']['dateTime']))
                            {{ \Carbon\Carbon::parse($event['dates']['start']['dateTime'])->format('D, M j • g:i A') }}
                        @else
                            <em>Date and time not available</em>
                        @endif
                    </p>

                    <p class="card-text text-muted">
                        {{ $event['_embedded']['venues'][0]['name'] ?? 'Location not available' }}
                    </p>

                    <p class="card-text">{{ $event['priceRanges'][0]['currency'] ?? 'Free' }}</p>

                    <p class="card-text">
                        <small class="text-muted">
                            <i class="bi bi-person"></i> {{ number_format($event['attendance'] ?? 0) }} followers
                        </small>
                    </p>
                   <a href="{{ $event['url'] ?? '#' }}" class="custom-event-btn" target="_blank">View Event</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Interest Section -->
<div class="interest-container mt-5 mb-4">
    <h2 class="mb-3">Let's make it personal</h2>
    <p class="text-muted mb-4">Select your interests to get event suggestions based on what you love</p>

    @auth
    <!-- Logged in users get interactive interests -->
    <div class="interests-section" id="interests-container">
        @if(isset($interests) && $interests->count() > 0)
            @foreach($interests as $interest)
            <button class="interest-pill" 
                    data-interest-id="{{ $interest->id }}" 
                    data-interest-name="{{ $interest->name }}"
                    style="--interest-color: {{ $interest->color ?? '#6366f1' }}"
                    onclick="toggleInterest({{ $interest->id }}, '{{ $interest->name }}')">
                @if($interest->icon)
                    <i class="{{ $interest->icon }} me-1"></i>
                @endif
                {{ $interest->name }}
            </button>
            @endforeach
        @else
            <p class="text-muted">No interests available. Please run the interest seeder.</p>
        @endif
    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center">
        <div>
            <span id="selected-count">0</span> interests selected
        </div>
        <div>
            <button id="save-interests-btn" class="btn btn-primary btn-sm" onclick="saveInterests()" disabled>
                Save My Interests
            </button>
            <button id="get-recommendations-btn" class="btn btn-outline-primary btn-sm" onclick="getRecommendations()" disabled>
                Get Recommendations
            </button>
        </div>
    </div>
    
    <!-- Personalized Events Section -->
    @if(isset($personalizedEvents) && $personalizedEvents->isNotEmpty())
    <div class="mt-5">
        <h3>Recommended for You</h3>
        <div class="row">
            @foreach($personalizedEvents->take(4) as $event)
                <div class="col-md-3 mb-4">
                    <div class="card event-card">
                        <div class="position-relative">
                            @if(isset($event['images']) && count($event['images']) > 0)
                                <img src="{{ $event['images'][0]['url'] }}" class="card-img-top" alt="{{ $event['name'] }}">
                            @endif
                            <span class="badge position-absolute top-0 end-0 m-2" 
                                  style="background-color: {{ $event['interest_color'] ?? '#6366f1' }}">
                                {{ $event['interest_category'] ?? 'Recommended' }}
                            </span>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title">{{ Str::limit($event['name'], 50) }}</h6>
                            <p class="card-text small text-muted">
                                @if(isset($event['dates']['start']['dateTime']))
                                    {{ \Carbon\Carbon::parse($event['dates']['start']['dateTime'])->format('M j, g:i A') }}
                                @endif
                                <br>
                                {{ $event['_embedded']['venues'][0]['name'] ?? 'Venue TBA' }}
                            </p>
                            <a href="{{ $event['url'] ?? '#' }}" class="btn btn-sm btn-primary" target="_blank">
                                View Event
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @else
    <!-- Not logged in users see signup prompts -->
    <div class="interests-section">
        @if(isset($interests) && $interests->count() > 0)
            @foreach($interests->take(12) as $interest)
            <a href="/account/create" class="interest-pill" style="--interest-color: {{ $interest->color ?? '#6366f1' }}">
                @if($interest->icon)
                    <i class="{{ $interest->icon }} me-1"></i>
                @endif
                {{ $interest->name }}
            </a>
            @endforeach
        @else
            <div class="interests-section">
                <a href="/account/create" class="interest-pill">Comedy</a>
                <a href="/account/create" class="interest-pill">Food</a>
                <a href="/account/create" class="interest-pill">Education</a>
                <a href="/account/create" class="interest-pill">Pop</a>
                <a href="/account/create" class="interest-pill">Design</a>
                <a href="/account/create" class="interest-pill">R&B</a>
                <a href="/account/create" class="interest-pill">Hip Hop / Rap</a>
                <a href="/account/create" class="interest-pill">Film</a>
                <a href="/account/create" class="interest-pill">Personal health</a>
                <a href="/account/create" class="interest-pill">Blues & Jazz</a>
                <a href="/account/create" class="interest-pill">Travel</a>
                <a href="/account/create" class="interest-pill">Rock</a>
            </div>
        @endif
    </div>
    
    <div class="mt-4 text-center">
        <a href="/account/create" class="btn btn-primary">Sign Up to Save Your Interests</a>
    </div>
    @endauth
</div>

<!-- Recommendations Modal -->
<div class="modal fade" id="recommendationsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recommended Events for You</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="recommendations-content">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Call to Action -->
  <div class="mt-5 mb-5 text-center p-5" style="background-color: #f8f7fa; border-radius: 8px;">
    <h2>Ready to host your own event?</h2>
    <p class="mb-4">It's easy to get started and reach thousands of potential attendees!</p>
    @auth
        <a href="/events/create" class="btn btn-lg" style="background-color: var(--primary-color); color: white;">Create Event</a>
    @else
        <a href="/account/create" class="btn btn-lg" style="background-color: var(--primary-color); color: white;">Sign Up to Create Events</a>
    @endauth
  </div>

<!-- CSS for Interest Pills -->
<style>
.interest-pill {
    display: inline-block;
    padding: 8px 16px;
    margin: 4px;
    background-color: #f3f4f6;
    color: #374151;
    border: 2px solid transparent;
    border-radius: 25px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.interest-pill:hover {
    background-color: var(--interest-color, #6366f1);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.interest-pill.selected {
    background-color: var(--interest-color, #6366f1);
    color: white;
    border-color: var(--interest-color, #6366f1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.interest-pill.selected:hover {
    opacity: 0.9;
}
</style>

<!-- JavaScript -->
<script>
// Category cards functionality
document.addEventListener("DOMContentLoaded", () => {
  const API_KEY = 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R';
  const eventContainer = document.getElementById('event-results');
  const loadingSpinner = document.getElementById('loading-spinner');

  // Add event listener to all category cards
  document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('click', async () => {
      const category = card.getAttribute('data-category');
      const url = `https://app.ticketmaster.com/discovery/v2/events.json?classificationName=${encodeURIComponent(category)}&apikey=${API_KEY}`;

      // Show loading spinner
      loadingSpinner.style.display = 'block';
      eventContainer.innerHTML = '';

      try {
        const res = await fetch(url);
        const data = await res.json();

        // Hide loading spinner after fetching data
        loadingSpinner.style.display = 'none';

        // Check if events are available
        if (data._embedded && data._embedded.events.length > 0) {
          data._embedded.events.forEach(event => {
            const div = document.createElement('div');
            div.classList.add('event-card');
            div.innerHTML = `
              <h5>${event.name}</h5>
              <p>${event.dates.start.localDate}</p>
              <a href="${event.url}" target="_blank">View</a>
            `;
            eventContainer.appendChild(div);
          });
        } else {
          eventContainer.innerHTML = '<p>No events found for this category.</p>';
        }
      } catch (err) {
        console.error(err);
        loadingSpinner.style.display = 'none';
        eventContainer.innerHTML = '<p>Error fetching events.</p>';
      }
    });
  });
});

// Interest functionality (ONLY for authenticated users)
@auth
let selectedInterests = [];
let userInterests = @json(auth()->user()->interests->pluck('id')->toArray() ?? []);

document.addEventListener('DOMContentLoaded', function() {
    console.log('Interest system initialized');
    console.log('User interests:', userInterests);
    
    // Load user's existing interests
    selectedInterests = [...userInterests];
    updateUI();
    
    // Mark existing interests as selected
    userInterests.forEach(interestId => {
        const pill = document.querySelector(`[data-interest-id="${interestId}"]`);
        if (pill) {
            pill.classList.add('selected');
            console.log('Marked interest as selected:', interestId);
        }
    });
    
    updateSelectedCount();
});

function toggleInterest(interestId, interestName) {
    console.log('Toggle interest called:', interestId, interestName);
    const pill = document.querySelector(`[data-interest-id="${interestId}"]`);
    
    if (!pill) {
        console.error('Interest pill not found:', interestId);
        return;
    }
    
    if (selectedInterests.includes(interestId)) {
        // Remove interest
        selectedInterests = selectedInterests.filter(id => id !== interestId);
        pill.classList.remove('selected');
        console.log('Removed interest:', interestId);
    } else {
        // Add interest
        selectedInterests.push(interestId);
        pill.classList.add('selected');
        console.log('Added interest:', interestId);
    }
    
    updateSelectedCount();
    updateUI();
}

function updateSelectedCount() {
    const countElement = document.getElementById('selected-count');
    if (countElement) {
        countElement.textContent = selectedInterests.length;
    }
}

function updateUI() {
    const saveBtn = document.getElementById('save-interests-btn');
    const recBtn = document.getElementById('get-recommendations-btn');
    
    if (saveBtn) saveBtn.disabled = selectedInterests.length === 0;
    if (recBtn) recBtn.disabled = selectedInterests.length === 0;
}

function saveInterests() {
    console.log('Save interests called with:', selectedInterests);
    
    if (selectedInterests.length === 0) {
        alert('Please select at least one interest before saving.');
        return;
    }
    
    const saveBtn = document.getElementById('save-interests-btn');
    const originalText = saveBtn.textContent;
    saveBtn.textContent = 'Saving...';
    saveBtn.disabled = true;
    
    fetch('/interests/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            interests: selectedInterests
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
            toast.innerHTML = `
                <strong>Success!</strong> ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(toast);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 3000);
            
            // Update user interests
            userInterests = [...selectedInterests];
        } else {
            alert('Error saving interests: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Failed to save interests. Please try again.');
    })
    .finally(() => {
        saveBtn.textContent = originalText;
        saveBtn.disabled = selectedInterests.length === 0;
    });
}

function getRecommendations() {
    if (selectedInterests.length === 0) return;
    
    const modal = new bootstrap.Modal(document.getElementById('recommendationsModal'));
    modal.show();
    
    // Reset content
    document.getElementById('recommendations-content').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading recommendations...</span>
            </div>
            <p class="mt-2">Finding events based on your interests...</p>
        </div>
    `;
    
    fetch('/interests/recommended-events')
    .then(response => response.json())
    .then(data => {
        const content = document.getElementById('recommendations-content');
        
        if (data.success && data.events.length > 0) {
            let eventsHTML = '<div class="row">';
            
            data.events.forEach(event => {
                const imageUrl = event.images && event.images.length > 0 ? event.images[0].url : '/api/placeholder/300/200';
                const eventDate = event.dates && event.dates.start && event.dates.start.dateTime 
                    ? new Date(event.dates.start.dateTime).toLocaleDateString() 
                    : 'Date TBA';
                const venueName = event._embedded && event._embedded.venues && event._embedded.venues[0] 
                    ? event._embedded.venues[0].name 
                    : 'Venue TBA';
                
                eventsHTML += `
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="${imageUrl}" class="card-img-top" alt="${event.name}" style="height: 150px; object-fit: cover;">
                                <span class="badge position-absolute top-0 end-0 m-2" style="background-color: ${event.interest_color}">
                                    ${event.interest_category}
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${event.name.substring(0, 50)}${event.name.length > 50 ? '...' : ''}</h6>
                                <p class="card-text small text-muted">
                                    <i class="bi bi-calendar"></i> ${eventDate}<br>
                                    <i class="bi bi-geo-alt"></i> ${venueName}
                                </p>
                                <a href="${event.url}" class="btn btn-sm btn-primary" target="_blank">View Event</a>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            eventsHTML += '</div>';
            content.innerHTML = eventsHTML;
        } else {
            content.innerHTML = `
                <div class="text-center">
                    <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                    <h5>No recommendations found</h5>
                    <p>Try selecting different interests or check back later for new events!</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('recommendations-content').innerHTML = `
            <div class="text-center">
                <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: #dc3545;"></i>
                <h5>Error loading recommendations</h5>
                <p>Please try again later.</p>
            </div>
        `;
    });
}
@endauth

</script>
</x-layout>