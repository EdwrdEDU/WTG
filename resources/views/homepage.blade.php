<!-- homepage.blade.php -->
<x-layout>
<div class="page-container">
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
  <a href="{{ url('/search/page') }}" class="location-btn">
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
                    
                    <!-- Add save button for logged-in users -->
                    @auth
                        <button class="btn btn-outline-danger save-external-event-btn position-absolute wtg-save-btn" 
                                style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);" 
                                data-event-id="{{ $event['id'] }}" 
                                data-event-name="{{ $event['name'] }}"
                                data-event-url="{{ $event['url'] ?? '' }}"
                                data-event-image="{{ $event['images'][0]['url'] ?? '' }}"
                                data-event-date="{{ $event['dates']['start']['dateTime'] ?? '' }}"
                                data-venue-name="{{ $event['_embedded']['venues'][0]['name'] ?? '' }}"
                                data-venue-address="{{ $event['_embedded']['venues'][0]['address']['line1'] ?? '' }}"
                                data-price-info="{{ isset($event['priceRanges']) ? $event['priceRanges'][0]['min'] . '-' . $event['priceRanges'][0]['max'] . ' ' . $event['priceRanges'][0]['currency'] : 'Free' }}"
                                title="Save Event">
                            <i class="bi bi-heart"></i>
                        </button>
                    @endauth
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
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ $event['url'] ?? '#' }}" target="_blank" class="event-link">View Event</a>
                        
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-heart"></i> Save
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No featured events available at this time.</p>
    @endforelse
  </div>


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


  <div id="event-results" class="mt-3">
  <!-- Dynamic event cards will be displayed here -->
  </div>

  <div id="loading-spinner" style="display: none;" class="text-center py-4">
  <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
    <span class="visually-hidden">Loading events...</span>
  </div>
  <p class="mt-2 text-muted">Loading events...</p>
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
                    
                    <!-- Add save button here for logged-in users -->
                    @auth
                        <button class="btn btn-outline-danger save-external-event-btn position-absolute wtg-save-btn" 
                                style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);"
                                data-event-id="{{ $event['id'] }}" 
                                data-event-name="{{ $event['name'] }}"
                                data-event-url="{{ $event['url'] ?? '' }}"
                                data-event-image="{{ $event['images'][0]['url'] ?? '' }}"
                                data-event-date="{{ $event['dates']['start']['dateTime'] ?? '' }}"
                                data-venue-name="{{ $event['_embedded']['venues'][0]['name'] ?? '' }}"
                                data-venue-address="{{ $event['_embedded']['venues'][0]['address']['line1'] ?? '' }}"
                                data-price-info="{{ isset($event['priceRanges']) ? $event['priceRanges'][0]['min'] . '-' . $event['priceRanges'][0]['max'] . ' ' . $event['priceRanges'][0]['currency'] : 'Free' }}"
                                title="Save Event">
                            <i class="bi bi-heart"></i>
                        </button>
                    @endauth
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
                    
                    <!-- Update the button area -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ $event['url'] ?? '#' }}" class="custom-event-btn" target="_blank">View Event</a>
                        
                        @guest
                            <!-- Show login prompt for guests -->
                            <a href="{{ route('login') }}" class="btn btn-outline-danger save-external-event-btn position-absolute wtg-save-btn" 
                                style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);" >
                                <i class="bi bi-heart"></i>
                            </a>
                        @endguest
                    </div>
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
<div class="modal fade" id="recommendationsModal" tabindex="-1" aria-labelledby="recommendationsModalLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 90vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recommendationsModalLabel">
                    <i class="bi bi-stars me-2"></i>Recommended Events for You
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="recommendations-content" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="/search/page" class="btn btn-primary">Search More Events</a>
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
</div>
</div>








<!-- JavaScript -->
<script>
// Category cards functionality with improvements
document.addEventListener("DOMContentLoaded", () => {
  const API_KEY = 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R';
  const eventContainer = document.getElementById('event-results');
  const loadingSpinner = document.getElementById('loading-spinner');
  
  // Track current category to avoid duplicate requests
  let currentCategory = null;
  
  // Add event listener to all category cards
  document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('click', async () => {
      const category = card.getAttribute('data-category');
      
      // Skip if already showing this category
      if (category === currentCategory && eventContainer.innerHTML !== '') {
        eventContainer.scrollIntoView({ behavior: 'smooth' });
        return;
      }
      
      currentCategory = category;
      
      // Reset all cards to normal state first
      document.querySelectorAll('.category-card').forEach(c => {
        c.classList.remove('active-category');
      });
      
      // Add loading state to clicked card
      card.classList.add('active-category');
      
      // Show loading spinner
      loadingSpinner.style.display = 'block';
      eventContainer.innerHTML = '';
      
      // Scroll to results section
      eventContainer.scrollIntoView({ behavior: 'smooth' });
      
      try {
        await fetchAndDisplayEvents(category);
      } catch (error) {
        console.error('Error fetching events:', error);
        eventContainer.innerHTML = `
          <div class="alert alert-danger">
            <div class="text-center py-4">
              <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
              <h4 class="mt-2">Error loading events</h4>
              <p>We couldn't load events for ${category}. Please try again later.</p>
              <button class="btn btn-outline-secondary mt-2" onclick="clearCategoryResults()">
                <i class="bi bi-arrow-left"></i> Back to All Events
              </button>
            </div>
          </div>
        `;
      } finally {
        // Hide loading spinner
        loadingSpinner.style.display = 'none';
      }
    });
  });
  
  async function fetchAndDisplayEvents(category) {
    // Build the API URL with proper parameters
    const url = `https://app.ticketmaster.com/discovery/v2/events.json?classificationName=${encodeURIComponent(category)}&apikey=${API_KEY}&countryCode=US&size=12&sort=date,asc`;
    
    console.log('Fetching events for category:', category);
    
    try {
      const response = await fetch(url);
      
      if (!response.ok) {
        throw new Error(`API responded with status: ${response.status}`);
      }
      
      const data = await response.json();
      console.log('API Response:', data);
      
      // Add section title
      const sectionTitle = `
        <div class="mb-4">
          <div class="d-flex justify-content-between align-items-center">
            <h2 class="section-title mb-0">${category} Events</h2>
            <button class="btn btn-outline-secondary" onclick="clearCategoryResults()">
              <i class="bi bi-arrow-left"></i> Back to All Events
            </button>
          </div>
          <hr>
        </div>
      `;
      
      if (data._embedded && data._embedded.events && data._embedded.events.length > 0) {
        let eventsHTML = sectionTitle + '<div class="row">';
        
        data._embedded.events.forEach(event => {
          eventsHTML += createEventCard(event);
        });
        
        eventsHTML += '</div>';
        eventContainer.innerHTML = eventsHTML;
        
        // NO LONGER CALLING initializeSaveButtons() here!
        // Event delegation in layout.blade.php handles all buttons automatically
        console.log('New events loaded - event delegation will handle save buttons');
        
      } else {
        eventContainer.innerHTML = `
          ${sectionTitle}
          <div class="text-center py-5">
            <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
            <h4 class="mt-3">No ${category.toLowerCase()} events found</h4>
            <p>Try browsing other categories or check back later for new events!</p>
          </div>
        `;
      }
    } catch (error) {
      console.error('Fetch error:', error);
      throw error;
    }
  }
  
  function createEventCard(event) {
    const imageUrl = event.images && event.images.length > 0 ? event.images[0].url : '/images/default-image.jpg';
    const eventName = event.name || 'Event Name Not Available';
    const eventUrl = event.url || '#';
    const venueName = event._embedded && event._embedded.venues && event._embedded.venues[0] 
      ? event._embedded.venues[0].name 
      : 'Venue TBA';
    
    let eventDate = 'Date TBA';
    if (event.dates && event.dates.start) {
      if (event.dates.start.dateTime) {
        const date = new Date(event.dates.start.dateTime);
        eventDate = date.toLocaleDateString('en-US', { 
          weekday: 'short', 
          month: 'short', 
          day: 'numeric',
          hour: 'numeric',
          minute: '2-digit'
        });
      } else if (event.dates.start.localDate) {
        const date = new Date(event.dates.start.localDate);
        eventDate = date.toLocaleDateString('en-US', { 
          weekday: 'short', 
          month: 'short', 
          day: 'numeric'
        });
      }
    }
    
    let priceInfo = 'Price TBA';
    if (event.priceRanges && event.priceRanges.length > 0) {
      const price = event.priceRanges[0];
      if (price.min === price.max) {
        priceInfo = `$${price.min}`;
      } else {
        priceInfo = `$${price.min} - $${price.max}`;
      }
    }
    
    // Check if user is logged in for save button
    const isLoggedIn = document.querySelector('.navbar .dropdown-toggle') !== null;
    
    let saveButtonHTML = '';
    if (isLoggedIn) {
      saveButtonHTML = `
        <button class="btn btn-outline-danger save-external-event-btn position-absolute" 
                style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);"
                data-event-id="${event.id}" 
                data-event-name="${eventName.replace(/"/g, '&quot;')}"
                data-event-url="${eventUrl}"
                data-event-image="${imageUrl}"
                data-event-date="${event.dates && event.dates.start && event.dates.start.dateTime ? event.dates.start.dateTime : ''}"
                data-venue-name="${venueName.replace(/"/g, '&quot;')}"
                data-venue-address="${event._embedded && event._embedded.venues && event._embedded.venues[0] && event._embedded.venues[0].address ? event._embedded.venues[0].address.line1 || '' : ''}"
                data-price-info="${priceInfo}"
                title="Save Event">
            <i class="bi bi-heart"></i>
        </button>
      `;
    } else {
      saveButtonHTML = `
        <a href="/account/login" class="btn btn-outline-danger position-absolute" 
           style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);"
           title="Login to save">
          <i class="bi bi-heart"></i>
        </a>
      `;
    }
    
    return `
      <div class="col-md-4 col-lg-3 mb-4">
        <div class="card event-card h-100">
          <div class="position-relative">
            <img src="${imageUrl}" class="card-img-top" alt="${eventName}" style="height: 200px; object-fit: cover;">
            ${saveButtonHTML}
          </div>
          <div class="card-body d-flex flex-column">
            <div class="event-date text-muted small mb-2">
              <i class="bi bi-calendar"></i> ${eventDate}
            </div>
            <h5 class="card-title">${eventName.length > 40 ? eventName.substring(0, 40) + '...' : eventName}</h5>
            <div class="event-location text-muted small mb-2">
              <i class="bi bi-geo-alt"></i> ${venueName}
            </div>
            <div class="event-price mb-3">
              <strong>${priceInfo}</strong>
            </div>
            <div class="mt-auto">
              <a href="${eventUrl}" target="_blank" class="btn btn-primary btn-sm w-100">
                View Event <i class="bi bi-box-arrow-up-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    `;
  }
  
  // Function to clear category results and return to original view
  window.clearCategoryResults = function() {
    eventContainer.innerHTML = '';
    currentCategory = null;
    
    // Reset all category cards
    document.querySelectorAll('.category-card').forEach(card => {
      card.classList.remove('active-category');
    });
    
    // Scroll back to events section
    document.getElementById('events').scrollIntoView({ behavior: 'smooth' });
  };
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
      if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
      }
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

// Replace the getRecommendations function in homepage.blade.php with this fixed version
function getRecommendations() {
    if (selectedInterests.length === 0) return;
    
    // Ensure any existing modal is properly closed first
    const existingModal = bootstrap.Modal.getInstance(document.getElementById('recommendationsModal'));
    if (existingModal) {
        existingModal.dispose();
    }
    
    // Create new modal instance
    const modal = new bootstrap.Modal(document.getElementById('recommendationsModal'), {
        backdrop: true,
        keyboard: true,
        focus: true
    });
    
    // Reset content before showing
    document.getElementById('recommendations-content').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading recommendations...</span>
            </div>
            <p class="mt-3 text-muted">Finding events based on your interests...</p>
            <small class="text-muted">This may take a few seconds</small>
        </div>
    `;
    
    // Show modal
    modal.show();
    
    // Ensure body doesn't scroll when modal is open
    document.body.style.overflow = 'hidden';
    
    // Add event listener to restore body scroll when modal closes
    document.getElementById('recommendationsModal').addEventListener('hidden.bs.modal', function () {
        document.body.style.overflow = 'auto';
    });
    
    fetch('/interests/recommended-events')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const content = document.getElementById('recommendations-content');
        
        if (data.success && data.events.length > 0) {
            // Remove duplicates based on event name and venue
            const uniqueEvents = data.events.filter((event, index, self) => 
                index === self.findIndex(e => 
                    e.name === event.name && 
                    (e._embedded?.venues?.[0]?.name === event._embedded?.venues?.[0]?.name)
                )
            ).slice(0, 12); // Limit to 12 events for better performance
            
            let eventsHTML = `
                <div class="mb-3">
                    <h6 class="text-muted">Found ${uniqueEvents.length} recommended events based on your interests</h6>
                </div>
                <div class="row g-3">
            `;
            
            uniqueEvents.forEach(event => {
                const imageUrl = event.images && event.images.length > 0 ? event.images[0].url : '/images/default-image.jpg';
                const eventDate = event.dates && event.dates.start && event.dates.start.dateTime 
                    ? new Date(event.dates.start.dateTime).toLocaleDateString('en-US', { 
                        weekday: 'short', 
                        month: 'short', 
                        day: 'numeric',
                        hour: 'numeric',
                        minute: '2-digit'
                    }) 
                    : 'Date TBA';
                const venueName = event._embedded && event._embedded.venues && event._embedded.venues[0] 
                    ? event._embedded.venues[0].name 
                    : 'Venue TBA';
                
                const priceInfo = event.priceRanges && event.priceRanges.length > 0
                    ? `$${event.priceRanges[0].min}${event.priceRanges[0].min !== event.priceRanges[0].max ? ' - $' + event.priceRanges[0].max : ''}`
                    : 'Price TBA';
                
                eventsHTML += `
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease;">
                            <div class="position-relative">
                                <img src="${imageUrl}" 
                                     class="card-img-top" 
                                     alt="${event.name}" 
                                     style="height: 160px; object-fit: cover;"
                                     onerror="this.src='/images/default-image.jpg'">
                                <span class="badge position-absolute top-0 end-0 m-2" 
                                      style="background-color: ${event.interest_color || '#6366f1'}; font-size: 0.75em;">
                                    ${event.interest_category}
                                </span>
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2" style="line-height: 1.3; font-size: 0.95rem;">
                                    ${event.name.length > 50 ? event.name.substring(0, 50) + '...' : event.name}
                                </h6>
                                
                                <div class="text-muted small mb-3 flex-grow-1">
                                    <div class="mb-1">
                                        <i class="bi bi-calendar me-1 text-primary"></i> 
                                        <span>${eventDate}</span>
                                    </div>
                                    <div class="mb-1">
                                        <i class="bi bi-geo-alt me-1 text-primary"></i> 
                                        <span>${venueName.length > 30 ? venueName.substring(0, 30) + '...' : venueName}</span>
                                    </div>
                                    <div class="mb-0">
                                        <i class="bi bi-tag me-1 text-primary"></i> 
                                        <span class="fw-semibold">${priceInfo}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-auto d-grid">
                                    <a href="${event.url}" 
                                       class="btn btn-primary btn-sm" 
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        View Event <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            eventsHTML += '</div>';
            content.innerHTML = eventsHTML;
            
        } else {
            content.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">No recommendations found</h5>
                    <p class="text-muted mb-4">Try selecting different interests or check back later for new events!</p>
                    <button class="btn btn-outline-primary" data-bs-dismiss="modal">
                        Close and Select Different Interests
                    </button>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error fetching recommendations:', error);
        document.getElementById('recommendations-content').innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-danger">Error Loading Recommendations</h5>
                <p class="text-muted mb-4">There was a problem fetching your recommendations. Please try again.</p>
                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-outline-primary" onclick="getRecommendations()">
                        <i class="bi bi-arrow-clockwise me-1"></i> Try Again
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        `;
    });
}
@endauth

/**
 * Category Tabs Functionality
 * This script makes the category tabs in the Events Section work
 * by fetching events from Ticketmaster API based on the selected category
 */
document.addEventListener('DOMContentLoaded', function() {
  // Configuration
  const API_KEY = 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R';
  
  // Get DOM elements
  const categoryTabs = document.querySelectorAll('.category-tabs .nav-link');
  const eventsSection = document.getElementById('events');
  
  // Add event listeners to all category tabs
  categoryTabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Update active tab
      categoryTabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      
      // Get category from tab text
      const category = this.textContent.trim();
      
      // Show loading indicator
      const eventsContainer = createOrGetEventsContainer();
      eventsContainer.innerHTML = `
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading events...</span>
          </div>
          <p class="mt-3">Loading ${category === 'All' ? 'events' : category + ' events'}...</p>
        </div>
      `;
      
      // Fetch events based on category
      fetchCategoryEvents(category, eventsContainer);
    });
  });
  
  /**
   * Create or get the events container below the tabs
   */
  function createOrGetEventsContainer() {
    // Check if the container already exists
    let eventsContainer = document.getElementById('category-events-container');
    
    // If not, create it
    if (!eventsContainer) {
      eventsContainer = document.createElement('div');
      eventsContainer.id = 'category-events-container';
      eventsContainer.className = 'mt-4';
      
      // Add it after the category tabs
      const categoryTabs = document.querySelector('.category-tabs');
      if (categoryTabs && categoryTabs.parentNode) {
        categoryTabs.parentNode.insertBefore(eventsContainer, categoryTabs.nextSibling);
      } else if (eventsSection) {
        eventsSection.appendChild(eventsContainer);
      }
    }
    
    return eventsContainer;
  }
  
  /**
   * Fetch events from Ticketmaster API based on category
   */
  function fetchCategoryEvents(category, container) {
    // Build API URL based on category
    let url = `https://app.ticketmaster.com/discovery/v2/events.json?apikey=${API_KEY}&countryCode=US&size=12`;
    
    // Add specific parameters based on category
    if (category === 'All') {
      // Just get popular events
      url += '&sort=relevance,desc';
    } else if (category === 'Today') {
      // Get today's date in format YYYY-MM-DD
      const today = new Date().toISOString().split('T')[0];
      url += `&startDateTime=${today}T00:00:00Z&endDateTime=${today}T23:59:59Z`;
    } else if (category === 'This weekend') {
      // Calculate the next weekend (Friday, Saturday, Sunday)
      const today = new Date();
      const friday = new Date(today);
      friday.setDate(today.getDate() + (5 - today.getDay()) % 7);
      
      const sunday = new Date(friday);
      sunday.setDate(friday.getDate() + 2);
      
      url += `&startDateTime=${friday.toISOString().split('T')[0]}T00:00:00Z&endDateTime=${sunday.toISOString().split('T')[0]}T23:59:59Z`;
    } else if (category === 'Online') {
      url += `&includeVirtual=true`;
    } else if (category === 'Free') {
      url += `&priceRanges.min=0&priceRanges.max=0`;
    } else if (category === 'For you') {
      // Default to popular events for "For you" if no personalization exists
      url += '&sort=relevance,desc';
    } else {
      // For standard categories like Music, Food & Drink, etc.
      url += `&keyword=${encodeURIComponent(category)}`;
    }
    
    console.log('Fetching events for category:', category);
    console.log('API URL:', url);
    
    // Fetch events from API
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error(`API responded with status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        // Create section title
        const sectionTitle = `
          <div class="mb-4">
            <h2 class="section-title">${category === 'All' ? 'Popular Events' : category + ' Events'}</h2>
          </div>
        `;
        
        // Check if events were found
        if (data._embedded && data._embedded.events && data._embedded.events.length > 0) {
          // Create event cards
          let eventsHTML = sectionTitle + '<div class="row">';
          
          data._embedded.events.forEach(event => {
            eventsHTML += createEventCard(event);
          });
          
          eventsHTML += '</div>';
          
          // Update the container
          container.innerHTML = eventsHTML;
          
          // NO LONGER CALLING initializeSaveButtons() here!
          // Event delegation in layout.blade.php handles all buttons automatically
          console.log('Category tab events loaded - event delegation will handle save buttons');
          
        } else {
          // No events found
          container.innerHTML = `
            ${sectionTitle}
            <div class="text-center py-5">
              <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
              <h4 class="mt-3">No ${category === 'All' ? '' : category.toLowerCase() + ' '}events found</h4>
              <p>Try browsing other categories or check back later for new events!</p>
            </div>
          `;
        }
      })
      .catch(error => {
        console.error('Error fetching events:', error);
        
        // Show error message
        container.innerHTML = `
          <div class="alert alert-danger">
            <div class="text-center py-4">
              <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
              <h4 class="mt-2">Error loading events</h4>
              <p>We couldn't load events for ${category}. Please try again later.</p>
            </div>
          </div>
        `;
      });
  }
  
  /**
   * Create an event card HTML
   */
  function createEventCard(event) {
    // Get event image
    const imageUrl = event.images && event.images.length > 0 
      ? event.images[0].url 
      : '/images/default-image.jpg';
    
    // Get event name
    const eventName = event.name || 'Event Name Not Available';
    
    // Get event URL
    const eventUrl = event.url || '#';
    
    // Get venue name
    const venueName = event._embedded && event._embedded.venues && event._embedded.venues[0] 
      ? event._embedded.venues[0].name 
      : 'Venue TBA';
    
    // Format event date
    let eventDate = 'Date TBA';
    if (event.dates && event.dates.start) {
      if (event.dates.start.dateTime) {
        const date = new Date(event.dates.start.dateTime);
        eventDate = date.toLocaleDateString('en-US', { 
          weekday: 'short', 
          month: 'short', 
          day: 'numeric',
          hour: 'numeric',
          minute: '2-digit'
        });
      } else if (event.dates.start.localDate) {
        const date = new Date(event.dates.start.localDate);
        eventDate = date.toLocaleDateString('en-US', { 
          weekday: 'short', 
          month: 'short', 
          day: 'numeric'
        });
      }
    }
    
    // Format price info
    let priceInfo = 'Price TBA';
    if (event.priceRanges && event.priceRanges.length > 0) {
      const price = event.priceRanges[0];
      if (price.min === price.max) {
        priceInfo = `${price.min}`;
      } else {
        priceInfo = `${price.min} - ${price.max}`;
      }
    }
    
    // Check if user is logged in
    const isLoggedIn = document.querySelector('.navbar .dropdown-toggle') !== null;
    
    // Create save button HTML
    let saveButtonHTML = '';
    if (isLoggedIn) {
      saveButtonHTML = `
        <button class="btn btn-outline-danger save-external-event-btn position-absolute wtg-save-btn" 
                style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);"
                style="top: 10px; right: 10px; "
                data-event-id="${event.id}" 
                data-event-name="${eventName.replace(/"/g, '&quot;')}"
                data-event-url="${eventUrl}"
                data-event-image="${imageUrl}"
                data-event-date="${event.dates && event.dates.start && event.dates.start.dateTime ? event.dates.start.dateTime : ''}"
                data-venue-name="${venueName.replace(/"/g, '&quot;')}"
                data-venue-address="${event._embedded && event._embedded.venues && event._embedded.venues[0] && event._embedded.venues[0].address ? event._embedded.venues[0].address.line1 || '' : ''}"
                data-price-info="${priceInfo}"
                title="Save Event">
            <i class="bi bi-heart"></i>
        </button>
      `;
    } else {
      saveButtonHTML = `
        <a href="/account/login" class="btn btn-outline-danger save-external-event-btn position-absolute wtg-save-btn" 
          style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);" " 
          style="top: 10px; right: 10px;"
          title="Login to save">
          <i class="bi bi-heart"></i>
        </a>
      `;
    }
    
    // Create and return the event card HTML
    return `
      <div class="col-md-4 col-lg-3 mb-4">
        <div class="card event-card h-100">
          <div class="position-relative">
            <img src="${imageUrl}" class="card-img-top" alt="${eventName}" style="height: 200px; object-fit: cover;">
            ${saveButtonHTML}
          </div>
          <div class="card-body d-flex flex-column">
            <div class="event-date text-muted small mb-2">
              <i class="bi bi-calendar"></i> ${eventDate}
            </div>
            <h5 class="card-title">${eventName.length > 40 ? eventName.substring(0, 40) + '...' : eventName}</h5>
            <div class="event-location text-muted small mb-2">
              <i class="bi bi-geo-alt"></i> ${venueName}
            </div>
            <div class="event-price mb-3">
              <strong>${priceInfo}</strong>
            </div>
            <div class="mt-auto">
              <a href="${eventUrl}" target="_blank" class="btn btn-primary btn-sm w-100">
                View Event <i class="bi bi-box-arrow-up-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    `;
  }
  
  // Trigger click on the active tab to load initial events
  const activeTab = document.querySelector('.category-tabs .nav-link.active');
  if (activeTab) {
    activeTab.click();
  }
});

</script>
</x-layout>