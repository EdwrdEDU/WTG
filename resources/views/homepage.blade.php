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

    <!-- Interest Grid -->
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
    <a href="/account/create" class="interest-pill">Yoga</a>
    <a href="/account/create" class="interest-pill">Country</a>
    <a href="/account/create" class="interest-pill">Startups & Small Business</a>
    <a href="/account/create" class="interest-pill">Classical</a>
    <a href="/account/create" class="interest-pill">Mental health</a>
    <a href="/account/create" class="interest-pill">TV</a>
    <a href="/account/create" class="interest-pill">Alternative</a>
    <a href="/account/create" class="interest-pill">Musical</a>
</div>


 <div class="mt-4">
    <a href="/account/create" class="text-decoration-none view-all-link">View all interests</a>
</div>




  <!-- Call to Action -->
  <div class="mt-5 mb-5 text-center p-5" style="background-color: #f8f7fa; border-radius: 8px;">
    <h2>Ready to host your own event?</h2>
    <p class="mb-4">It's easy to get started and reach thousands of potential attendees!</p>
    <a href="/events/create" class="btn btn-lg" style="background-color: var(--primary-color); color: white;">Create Event</a>
  </div>



<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Interest pill selection
    const interestPills = document.querySelectorAll('.interest-pill');
    const selectedInterests = [];

    interestPills.forEach(pill => {
        pill.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent redirection
            const interest = this.textContent.trim();

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                const index = selectedInterests.indexOf(interest);
                if (index > -1) {
                    selectedInterests.splice(index, 1);
                }
            } else {
                this.classList.add('selected');
                selectedInterests.push(interest);
            }

            console.log('Selected interests:', selectedInterests);
        });
    });

    // Carousel navigation (optional: only if used)
    const carousel = document.querySelector('.carousel-inner');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const pages = document.querySelectorAll('.carousel-page');
    let currentPage = 0;
    const totalPages = pages.length;

    function updateCarousel() {
        if (carousel) {
            carousel.style.transform = `translateX(-${currentPage * 100}%)`;
        }
        if (prevBtn) prevBtn.style.visibility = currentPage === 0 ? 'hidden' : 'visible';
        if (nextBtn) nextBtn.style.visibility = currentPage === totalPages - 1 ? 'hidden' : 'visible';
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            if (currentPage > 0) {
                currentPage--;
                updateCarousel();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            if (currentPage < totalPages - 1) {
                currentPage++;
                updateCarousel();
            }
        });
    }

    // View all interests (optional)
    const viewAllBtn = document.querySelector('.view-all'); // You called `viewAllBtn`, but your actual button class might be `.view-all-link`
    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', function (e) {
            e.preventDefault();
            // You can expand all interests or toggle a class, depending on your UI
            document.querySelectorAll('.interest-pill').forEach(pill => pill.classList.add('expanded'));
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
  const API_KEY = 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R'; // Replace with your real Ticketmaster API key
  const eventContainer = document.getElementById('event-results'); // A div to show results
  const loadingSpinner = document.getElementById('loading-spinner'); // Loading spinner element

  // Add event listener to all category cards
  document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('click', async () => {
      const category = card.getAttribute('data-category'); // Get category name
      const url = `https://app.ticketmaster.com/discovery/v2/events.json?classificationName=${encodeURIComponent(category)}&apikey=${API_KEY}`;

      // Show loading spinner
      loadingSpinner.style.display = 'block';
      eventContainer.innerHTML = '';  // Clear any previous results

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


  document.getElementById('category-dropdown').addEventListener('change', function() {
    var category = this.value;
    fetchEvents(category);
  });

   function fetchEvents(category) {
    // Show loading spinner while fetching events
    document.getElementById('loading-spinner').style.display = 'block';
    document.getElementById('event-results').style.display = 'none';  // Hide the event results section initially

    // Make an API request to get the events for the selected category
    fetch(`/events/category/${category}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('event-results').style.display = 'block';

        // Clear previous results
        document.getElementById('event-results').innerHTML = '';

        // If events are found, display them
        if (data.events.length > 0) {
          data.events.forEach(event => {
            const eventCard = `
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card">
                  <img src="${event.imageUrl}" class="card-img-top" alt="${event.name}">
                  <div class="card-body">
                    <h5 class="card-title">${event.name}</h5>
                    <p class="card-text">${event.date}</p>
                    <p class="card-text">${event.venue}</p>
                    <a href="${event.url}" target="_blank" class="btn btn-primary">View Details</a>
                  </div>
                </div>
              </div>
            `;
            document.getElementById('event-results').innerHTML += eventCard;
          });
        } else {
          document.getElementById('event-results').innerHTML = '<div class="alert alert-warning">No events found for this category.</div>';
        }
      })
      .catch(error => {
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('event-results').innerHTML = '<div class="alert alert-danger">Failed to load events. Please try again.</div>';
      });
  }
</script>
</x-layout>