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
    <a href="/create-events" class="btn btn-lg" style="background-color: var(--primary-color); color: white;">Create Event</a>
  </div>

</x-layout>