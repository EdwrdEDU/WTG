<x-layout>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>


                <li class="breadcrumb-item active" aria-current="page">Event Search</li>
            </ol>
        </nav>

        <!-- Title Section -->
        <div class="filter-page-title-section mt-3 mb-4">
            <h1 class="filter-page-title">Find Events</h1>
            <p class="filter-page-subtitle">Discover events that match your interests</p>
        </div>

        <div class="row">
            <!-- Left Side Categories Panel - More Compact Design -->
            <div class="col-md-3" id="filter-sidebar">
                <!-- Search within filters -->
                <div class="compact-search mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" placeholder="Search filters..." id="filter-search">
                        <button class="btn btn-sm btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Categories accordion -->
                <div class="accordion filter-accordion" id="filterAccordion">
                    <!-- Categories Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategories">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
                                Categories
                            </button>
                        </h2>
                        <div id="collapseCategories" class="accordion-collapse collapse show" aria-labelledby="headingCategories">
                            <div class="accordion-body compact-body">
                                <div class="category-chips">
                                    <div class="category-chip" data-category="music">
                                        <input type="checkbox" id="cat-music" class="visually-hidden">
                                        <label for="cat-music">
                                            <i class="bi bi-music-note-beamed"></i> Music
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="sports">
                                        <input type="checkbox" id="cat-sports" class="visually-hidden">
                                        <label for="cat-sports">
                                            <i class="bi bi-bicycle"></i> Sports
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="arts">
                                        <input type="checkbox" id="cat-arts" class="visually-hidden">
                                        <label for="cat-arts">
                                            <i class="bi bi-palette"></i> Arts
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="food">
                                        <input type="checkbox" id="cat-food" class="visually-hidden">
                                        <label for="cat-food">
                                            <i class="bi bi-cup-hot"></i> Food
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="charity">
                                        <input type="checkbox" id="cat-charity" class="visually-hidden">
                                        <label for="cat-charity">
                                            <i class="bi bi-heart"></i> Charity
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="comedy">
                                        <input type="checkbox" id="cat-comedy" class="visually-hidden">
                                        <label for="cat-comedy">
                                            <i class="bi bi-emoji-laughing"></i> Comedy
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="education">
                                        <input type="checkbox" id="cat-education" class="visually-hidden">
                                        <label for="cat-education">
                                            <i class="bi bi-book"></i> Education
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="film">
                                        <input type="checkbox" id="cat-film" class="visually-hidden">
                                        <label for="cat-film">
                                            <i class="bi bi-film"></i> Film
                                        </label>
                                    </div>
                                    <div class="category-chip" data-category="misc">
                                        <input type="checkbox" id="cat-misc" class="visually-hidden">
                                        <label for="cat-misc">
                                            <i class="bi bi-list-ul"></i> Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDate">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDate" aria-expanded="false" aria-controls="collapseDate">
                                Date
                            </button>
                        </h2>
                        <div id="collapseDate" class="accordion-collapse collapse" aria-labelledby="headingDate">
                            <div class="accordion-body compact-body">
                                <div class="quick-date-options d-flex flex-wrap mb-2">
                                    <button class="quick-date-btn" data-value="today">Today</button>
                                    <button class="quick-date-btn" data-value="tomorrow">Tomorrow</button>
                                    <button class="quick-date-btn" data-value="weekend">Weekend</button>
                                    <button class="quick-date-btn" data-value="week">This Week</button>
                                </div>
                                <div class="date-inputs mt-2">
                                    <div class="d-flex gap-2">
                                        <div class="flex-grow-1">
                                            <label class="small text-muted">From</label>
                                            <input type="date" class="form-control form-control-sm" id="start-date">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="small text-muted">To</label>
                                            <input type="date" class="form-control form-control-sm" id="end-date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPrice">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
                                Price
                            </button>
                        </h2>
                        <div id="collapsePrice" class="accordion-collapse collapse" aria-labelledby="headingPrice">
                            <div class="accordion-body compact-body">
                                <div class="price-options d-flex gap-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="price-free">
                                        <label class="form-check-label" for="price-free">Free</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="price-paid">
                                        <label class="form-check-label" for="price-paid">Paid</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingLocation">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation">
                                Location
                            </button>
                        </h2>
                        <div id="collapseLocation" class="accordion-collapse collapse" aria-labelledby="headingLocation">
                            <div class="accordion-body compact-body">
                                <div class="input-group input-group-sm mb-2">
                                    <input type="text" class="form-control" placeholder="City or venue" id="location-input">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-geo-alt"></i>
                                    </button>
                                </div>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="checkbox" id="online-events">
                                    <label class="form-check-label small" for="online-events">
                                        Include online events
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Filter action buttons -->
                <div class="filter-actions mt-3 d-flex gap-2">
                    <button class="btn btn-primary btn-sm flex-grow-1 apply-filters-btn">Apply Filters</button>
                    <button class="btn btn-outline-secondary btn-sm clear-filters-btn">Clear</button>
                </div>
            </div>

            <!-- Right Side Content -->
            <div class="col-md-9" id="filter-content">
                <!-- Search bar -->
                <div class="search-container mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for events..." id="search-events-input">
                        <button class="btn search-btn" type="button" id="search-button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Filter pills -->
                <div class="filter-pills mb-4" id="filter-pills">
                    <!-- Pills will be added dynamically through JS -->
                    <!-- <span class="filter-pill">Music <i class="bi bi-x-circle"></i></span> -->
                </div>

                <!-- Sort by dropdown -->
                <div class="sort-container mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div id="results-count">105 events found</div>
                        <div class="sort-dropdown">
                            <select class="form-select" id="sort-select">
                                <option selected>Sort by: Recommended</option>
                                <option>Sort by: Date (soonest first)</option>
                                <option>Sort by: Date (latest first)</option>
                                <option>Sort by: Price (low to high)</option>
                                <option>Sort by: Price (high to low)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Results grid -->
                <div class="row" id="search-results">
                    <!-- Event Card 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="card event-card">
                            <div class="position-relative">
                                <img src="/api/placeholder/400/200" class="card-img-top" alt="Event">
                                <span class="featured-badge">Popular</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="event-date">
                                    Fri, May 23 • 8:00 PM
                                </div>
                                <h5 class="event-title">Summer Music Festival 2025</h5>
                                <div class="event-location">
                                    <i class="bi bi-geo-alt"></i>
                                    Central Park, New York
                                </div>
                                <p class="card-text mt-2">$45 - $120</p>
                                <a href="#" class="custom-event-btn">View Event</a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="card event-card">
                            <div class="position-relative">
                                <img src="/api/placeholder/400/200" class="card-img-top" alt="Event">
                            </div>
                            <div class="card-body p-3">
                                <div class="event-date">
                                    Sat, May 24 • 7:30 PM
                                </div>
                                <h5 class="event-title">Broadway Theater Night</h5>
                                <div class="event-location">
                                    <i class="bi bi-geo-alt"></i>
                                    Broadway Theater
                                </div>
                                <p class="card-text mt-2">$75 - $150</p>
                                <a href="#" class="custom-event-btn">View Event</a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="card event-card">
                            <div class="position-relative">
                                <img src="/api/placeholder/400/200" class="card-img-top" alt="Event">
                                <span class="featured-badge">Featured</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="event-date">
                                    Sun, May 25 • 10:00 AM
                                </div>
                                <h5 class="event-title">Charity Fun Run</h5>
                                <div class="event-location">
                                    <i class="bi bi-geo-alt"></i>
                                    Riverside Park
                                </div>
                                <p class="card-text mt-2">$25 Registration</p>
                                <a href="#" class="custom-event-btn">View Event</a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 4 -->
                    <div class="col-md-4 mb-4">
                        <div class="card event-card">
                            <div class="position-relative">
                                <img src="/api/placeholder/400/200" class="card-img-top" alt="Event">
                            </div>
                            <div class="card-body p-3">
                                <div class="event-date">
                                    Mon, May 26 • 6:00 PM
                                </div>
                                <h5 class="event-title">Tech Meetup: AI Revolution</h5>
                                <div class="event-location">
                                    <i class="bi bi-geo-alt"></i>
                                    Tech Hub Downtown
                                </div>
                                <p class="card-text mt-2">Free</p>
                                <a href="#" class="custom-event-btn">View Event</a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 5 -->
                    <div class="col-md-4 mb-4">
                        <div class="card event-card">
                            <div class="position-relative">
                                <img src="/api/placeholder/400/200" class="card-img-top" alt="Event">
                            </div>
                            <div class="card-body p-3">
                                <div class="event-date">
                                    Tue, May 27 • 7:00 PM
                                </div>
                                <h5 class="event-title">Comedy Night</h5>
                                <div class="event-location">
                                    <i class="bi bi-geo-alt"></i>
                                    Laugh Factory
                                </div>
                                <p class="card-text mt-2">$35</p>
                                <a href="#" class="custom-event-btn">View Event</a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Card 6 -->
                    <div class="col-md-4 mb-4">
                        <div class="card event-card">
                            <div class="position-relative">
                                <img src="/api/placeholder/400/200" class="card-img-top" alt="Event">
                                <span class="featured-badge">Last Tickets</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="event-date">
                                    Wed, May 28 • 8:30 PM
                                </div>
                                <h5 class="event-title">Jazz in the Park</h5>
                                <div class="event-location">
                                    <i class="bi bi-geo-alt"></i>
                                    City Park Amphitheater
                                </div>
                                <p class="card-text mt-2">$40</p>
                                <a href="#" class="custom-event-btn">View Event</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="Event results pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Category chip selection
        document.querySelectorAll('.category-chip input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateFilterPills();
            });
        });

        // Quick date buttons
        document.querySelectorAll('.quick-date-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove selected from all buttons
                document.querySelectorAll('.quick-date-btn').forEach(b => b.classList.remove('selected'));
                // Add selected to clicked button
                this.classList.add('selected');
                
                // Set date inputs based on selection
                const today = new Date();
                const startInput = document.getElementById('start-date');
                const endInput = document.getElementById('end-date');
                
                switch(this.dataset.value) {
                    case 'today':
                        startInput.valueAsDate = today;
                        endInput.valueAsDate = today;
                        break;
                    case 'tomorrow':
                        const tomorrow = new Date(today);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        startInput.valueAsDate = tomorrow;
                        endInput.valueAsDate = tomorrow;
                        break;
                    case 'weekend':
                        const friday = new Date(today);
                        const sunday = new Date(today);
                        friday.setDate(friday.getDate() + (5 - friday.getDay()) % 7);
                        sunday.setDate(sunday.getDate() + (7 - sunday.getDay()) % 7);
                        startInput.valueAsDate = friday;
                        endInput.valueAsDate = sunday;
                        break;
                    case 'week':
                        const weekStart = new Date(today);
                        const weekEnd = new Date(today);
                        weekStart.setDate(weekStart.getDate());
                        weekEnd.setDate(weekEnd.getDate() + 7);
                        startInput.valueAsDate = weekStart;
                        endInput.valueAsDate = weekEnd;
                        break;
                }
            });
        });

        function updateFilterPills() {
            const pillsContainer = document.getElementById('filter-pills');
            pillsContainer.innerHTML = '';

            document.querySelectorAll('.category-chip input:checked').forEach(checkbox => {
                const category = checkbox.id.replace('cat-', '');
                const label = checkbox.nextElementSibling.textContent.trim();
                const pill = document.createElement('span');
                pill.className = 'filter-pill';
                pill.innerHTML = `${label} <i class="bi bi-x-circle"></i>`;
                pill.querySelector('i').addEventListener('click', () => {
                    checkbox.checked = false;
                    updateFilterPills();
                });
                pillsContainer.appendChild(pill);
            });
        }

        // Clear all filters
        document.querySelector('.clear-filters-btn').addEventListener('click', function() {
            // Clear category selections
            document.querySelectorAll('.category-chip input').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Clear date selections
            document.querySelectorAll('.quick-date-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            document.getElementById('start-date').value = '';
            document.getElementById('end-date').value = '';
            
            // Clear price options
            document.getElementById('price-free').checked = false;
            document.getElementById('price-paid').checked = false;
            
            // Clear location
            document.getElementById('location-input').value = '';
            document.getElementById('online-events').checked = false;
            
            // Clear search input
            document.getElementById('search-events-input').value = '';
            document.getElementById('filter-search').value = '';
            
            // Update pills
            updateFilterPills();
        });

        // Mobile filter toggle
        const showFilterBtn = document.getElementById('show-filters-mobile');
        const filterSidebar = document.getElementById('filter-sidebar');
        
        if (showFilterBtn) {
            showFilterBtn.addEventListener('click', function() {
                filterSidebar.classList.toggle('show-mobile-filters');
                this.textContent = filterSidebar.classList.contains('show-mobile-filters') ? 'Hide Filters' : 'Show Filters';
            });
        }
    </script>

</x-layout>