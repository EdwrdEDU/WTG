<x-layout>
    <!-- WTG Search Page Breadcrumb -->
    <nav aria-label="breadcrumb" class="wtg-search-breadcrumb mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event Search</li>
        </ol>
    </nav>

    <!-- WTG Search Title Section -->
    <section class="wtg-search-title-section mt-3 mb-4">
        <h1 class="wtg-search-main-title">Find Events</h1>
        <p class="wtg-search-subtitle">Discover events that match your interests</p>
    </section>

    <div class="row">
        <!-- WTG Left Side Filters Panel -->
        <aside class="col-md-3" id="wtg-filter-sidebar">
            <div class="wtg-filters-container">
                <form action="{{ route('events.search') }}" method="GET" id="wtg-search-filters-form">
                    <!-- WTG Search within filters -->
                    <div class="wtg-compact-search mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm wtg-search-input" 
                                   name="event" placeholder="Event name or keyword" value="{{ $query ?? '' }}">
                            <input type="text" class="form-control form-control-sm wtg-location-input" 
                                   name="location" placeholder="City or venue" value="{{ $location ?? '' }}">
                        </div>
                    </div>
                    
                    <!-- WTG Date Section -->
                    <div class="wtg-filter-section mb-3">
                        <h5 class="wtg-filter-title">Date</h5>
                        <div class="wtg-date-inputs">
                            <div class="d-flex gap-2 mb-2">
                                <div class="flex-grow-1">
                                    <label class="small text-muted">From</label>
                                    <input type="date" class="form-control form-control-sm wtg-date-from" 
                                           id="wtg-start-date" name="start_date">
                                </div>
                                <div class="flex-grow-1">
                                    <label class="small text-muted">To</label>
                                    <input type="date" class="form-control form-control-sm wtg-date-to" 
                                           id="wtg-end-date" name="end_date">
                                </div>
                            </div>
                            <div class="wtg-quick-date-options d-flex flex-wrap">
                                <button type="button" class="wtg-quick-date-btn" data-value="today">Today</button>
                                <button type="button" class="wtg-quick-date-btn" data-value="tomorrow">Tomorrow</button>
                                <button type="button" class="wtg-quick-date-btn" data-value="weekend">Weekend</button>
                                <button type="button" class="wtg-quick-date-btn" data-value="week">This Week</button>
                            </div>
                        </div>
                    </div>

                    <!-- WTG Category Section -->
                    <div class="wtg-filter-section mb-3">
                        <h5 class="wtg-filter-title">Category</h5>
                        <select class="form-select form-select-sm wtg-category-select" name="category">
                            <option value="">All Categories</option>
                            <option value="Music">Music</option>
                            <option value="Sports">Sports</option>
                            <option value="Arts & Theatre">Arts & Theatre</option>
                            <option value="Family">Family</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Film">Film</option>
                            <option value="Miscellaneous">Other</option>
                        </select>
                    </div>
                    
                    <!-- WTG Price Section -->
                    <div class="wtg-filter-section mb-3">
                        <h5 class="wtg-filter-title">Price Range</h5>
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <input type="number" class="form-control form-control-sm wtg-price-min" 
                                       name="price_min" placeholder="Min $" min="0">
                            </div>
                            <div class="flex-grow-1">
                                <input type="number" class="form-control form-control-sm wtg-price-max" 
                                       name="price_max" placeholder="Max $" min="0">
                            </div>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input wtg-free-events-check" type="checkbox" 
                                   id="wtg-free-events" name="free_events" value="1">
                            <label class="form-check-label small" for="wtg-free-events">
                                Free events only
                            </label>
                        </div>
                    </div>
                    
                    <!-- WTG Event Type Section -->
                    <div class="wtg-filter-section mb-3">
                        <h5 class="wtg-filter-title">Event Type</h5>
                        <div class="form-check">
                            <input class="form-check-input wtg-local-events-check" type="checkbox" 
                                   id="wtg-local-events" name="local_events" value="1" checked>
                            <label class="form-check-label small" for="wtg-local-events">
                                Local events (from our users)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input wtg-external-events-check" type="checkbox" 
                                   id="wtg-external-events" name="external_events" value="1" checked>
                            <label class="form-check-label small" for="wtg-external-events">
                                External events (from Ticketmaster)
                            </label>
                        </div>
                    </div>
                    
                    <!-- WTG Filter action buttons -->
                    <div class="wtg-filter-actions mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 wtg-apply-filters-btn">
                            Apply Filters
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-sm wtg-clear-filters-btn">
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- WTG Right Side Content -->
        <main class="col-md-9" id="wtg-filter-content">
            <!-- WTG Search bar -->
            <div class="wtg-search-container mb-4">
                <form action="{{ route('events.search') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" class="form-control wtg-main-search-input" 
                               placeholder="Search for events..." name="event" value="{{ $query ?? '' }}">
                        <input type="text" class="form-control wtg-main-location-input" 
                               placeholder="City or venue" name="location" value="{{ $location ?? '' }}">
                        <button class="btn wtg-search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- WTG Results summary -->
            @if(isset($searchInfo))
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center wtg-results-header">
                    <div id="wtg-results-count" class="wtg-results-count">
                        @if($searchInfo['totalResults'] > 0)
                            Found {{ $searchInfo['totalResults'] }} events
                            @if($searchInfo['query'] || $searchInfo['location'])
                                for 
                                @if($searchInfo['query'])
                                    "{{ $searchInfo['query'] }}"
                                @endif
                                @if($searchInfo['query'] && $searchInfo['location'])
                                    in
                                @endif
                                @if($searchInfo['location'])
                                    "{{ $searchInfo['location'] }}"
                                @endif
                            @endif
                        @else
                            No events found
                        @endif
                    </div>
                    <div class="wtg-sort-dropdown">
                        <select class="form-select wtg-sort-select" id="wtg-sort-select">
                            <option selected>Sort by: Date (soonest first)</option>
                            <option>Sort by: Date (latest first)</option>
                            <option>Sort by: Price (low to high)</option>
                            <option>Sort by: Price (high to low)</option>
                        </select>
                    </div>
                </div>
                
                @if($searchInfo['totalResults'] > 0)
                    <div class="mt-2 small text-muted wtg-results-breakdown">
                        Showing {{ $searchInfo['localResults'] }} local events and {{ $searchInfo['externalResults'] }} external events
                    </div>
                @endif
            </div>
            @endif

            <!-- WTG Results grid -->
            <div class="row wtg-search-results" id="wtg-search-results">
                @if(isset($searchResults) && $searchResults->count() > 0)
                    @foreach($searchResults as $event)
                        <div class="col-md-4 mb-4 wtg-event-col">
                            <article class="card wtg-event-card h-100">
                                <div class="position-relative wtg-event-image-container">
                                    <img src="{{ $event['images'][0]['url'] ?? '/images/default-image.jpg' }}" 
                                         class="card-img-top wtg-event-image" alt="{{ $event['name'] }}" 
                                         style="height: 200px; object-fit: cover;">
                                    
                                    <!-- WTG Event source badge -->
                                    @if($event['event_type'] == 'local')
                                        <span class="badge bg-success position-absolute wtg-event-badge" 
                                              style="top: 10px; left: 10px;">Local</span>
                                    @else
                                        <span class="badge bg-info position-absolute wtg-event-badge" 
                                              style="top: 10px; left: 10px;">External</span>
                                    @endif
                                    
                                    <!-- WTG Save button -->
                                    @auth
                                        @if($event['event_type'] == 'local')
                                            <button class="btn btn-outline-danger save-event-btn position-absolute wtg-save-btn" 
                                                    style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);"
                                                    data-event-id="{{ $event['local_event_id'] }}" 
                                                    title="Save Event">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        @else
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
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-danger position-absolute wtg-login-save-btn" 
                                           style="top: 10px; right: 10px; background: rgba(255,255,255,0.9);"
                                           title="Login to save">
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                                <div class="card-body p-3 wtg-event-details">
                                    <div class="wtg-event-date text-muted small mb-2">
                                        <i class="bi bi-calendar"></i> 
                                        @if(isset($event['dates']['start']['dateTime']))
                                            {{ \Carbon\Carbon::parse($event['dates']['start']['dateTime'])->format('D, M j • g:i A') }}
                                        @else
                                            Date TBA
                                        @endif
                                    </div>
                                    <h5 class="card-title wtg-event-title">{{ $event['name'] }}</h5>
                                    <div class="wtg-event-location text-muted small mb-2">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $event['_embedded']['venues'][0]['name'] ?? 'Location not available' }}
                                    </div>
                                    <div class="wtg-event-price mb-2">
                                        <strong>
                                            @if(isset($event['priceRanges']))
                                                @if($event['priceRanges'][0]['min'] == $event['priceRanges'][0]['max'])
                                                    ${{ $event['priceRanges'][0]['min'] }}
                                                @else
                                                    ${{ $event['priceRanges'][0]['min'] }} - ${{ $event['priceRanges'][0]['max'] }}
                                                @endif
                                                {{ $event['priceRanges'][0]['currency'] }}
                                            @else
                                                Price TBA
                                            @endif
                                        </strong>
                                    </div>
                                    
                                    @if($event['event_type'] == 'local')
                                        <div class="text-muted small mb-3 wtg-event-creator">
                                            <i class="bi bi-person"></i> Created by {{ $event['creator'] ?? 'Anonymous' }}
                                        </div>
                                    @endif
                                    
                                    <a href="{{ $event['url'] ?? '#' }}" 
                                       target="{{ $event['event_type'] == 'external' ? '_blank' : '_self' }}" 
                                       class="btn btn-primary btn-sm w-100 wtg-view-event-btn">
                                        View Event 
                                        @if($event['event_type'] == 'external') 
                                            <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        @endif
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5 wtg-no-results">
                            <i class="bi bi-search wtg-no-results-icon" style="font-size: 3rem; color: #ccc;"></i>
                            <h4 class="mt-3 wtg-no-results-title">No events found</h4>
                            <p class="wtg-no-results-text">Try adjusting your search criteria or browse our featured events.</p>
                            <a href="{{ route('homepage') }}" class="btn btn-primary mt-3 wtg-explore-btn">
                                Explore Featured Events
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- WTG Pagination -->
            @if(isset($searchResults) && $searchResults->count() > 12)
                <nav aria-label="Event results pagination" class="mt-4 wtg-pagination-nav">
                    <ul class="pagination justify-content-center wtg-pagination">
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
            @endif
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // WTG Quick date buttons functionality
            document.querySelectorAll('.wtg-quick-date-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove selected from all buttons
                    document.querySelectorAll('.wtg-quick-date-btn').forEach(b => b.classList.remove('wtg-selected'));
                    // Add selected to clicked button
                    this.classList.add('wtg-selected');
                    
                    // Set date inputs based on selection
                    const today = new Date();
                    const startInput = document.getElementById('wtg-start-date');
                    const endInput = document.getElementById('wtg-end-date');
                    
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
                            weekEnd.setDate(weekEnd.getDate() + 7);
                            startInput.valueAsDate = weekStart;
                            endInput.valueAsDate = weekEnd;
                            break;
                    }
                });
            });
            
            // WTG Free events checkbox functionality
            document.getElementById('wtg-free-events')?.addEventListener('change', function() {
                const minPrice = document.querySelector('.wtg-price-min');
                const maxPrice = document.querySelector('.wtg-price-max');
                
                if (this.checked) {
                    minPrice.value = '0';
                    maxPrice.value = '0';
                    minPrice.disabled = true;
                    maxPrice.disabled = true;
                } else {
                    minPrice.disabled = false;
                    maxPrice.disabled = false;
                }
            });
            
            // WTG Sort functionality
            document.getElementById('wtg-sort-select')?.addEventListener('change', function() {
                const sortValue = this.value;
                const resultsContainer = document.getElementById('wtg-search-results');
                const eventCards = Array.from(resultsContainer.querySelectorAll('.wtg-event-col'));
                
                // Sort the cards based on selection
                eventCards.sort((a, b) => {
                    if (sortValue.includes('Date (soonest first)')) {
                        const dateA = getWtgEventDate(a);
                        const dateB = getWtgEventDate(b);
                        return dateA - dateB;
                    } else if (sortValue.includes('Date (latest first)')) {
                        const dateA = getWtgEventDate(a);
                        const dateB = getWtgEventDate(b);
                        return dateB - dateA;
                    } else if (sortValue.includes('Price (low to high)')) {
                        const priceA = getWtgEventPrice(a);
                        const priceB = getWtgEventPrice(b);
                        return priceA - priceB;
                    } else if (sortValue.includes('Price (high to low)')) {
                        const priceA = getWtgEventPrice(a);
                        const priceB = getWtgEventPrice(b);
                        return priceB - priceA;
                    }
                    return 0;
                });
                
                // Remove all cards
                eventCards.forEach(card => card.remove());
                
                // Add sorted cards back
                eventCards.forEach(card => {
                    resultsContainer.appendChild(card);
                });
            });
            
            // WTG Helper function to get event date
            function getWtgEventDate(cardElement) {
                const dateText = cardElement.querySelector('.wtg-event-date').textContent.trim();
                if (dateText === 'Date TBA') {
                    return Number.MAX_SAFE_INTEGER; // Put TBA dates at the end
                }
                return new Date(dateText.replace('• ', '')).getTime();
            }
            
            // WTG Helper function to get event price
            function getWtgEventPrice(cardElement) {
                const priceText = cardElement.querySelector('.wtg-event-price').textContent.trim();
                if (priceText === 'Price TBA') {
                    return Number.MAX_SAFE_INTEGER; // Put TBA prices at the end
                }
                // Extract the first number from the price text
                const priceMatch = priceText.match(/\$(\d+\.?\d*)/);
                return priceMatch ? parseFloat(priceMatch[1]) : Number.MAX_SAFE_INTEGER;
            }
            
            // Initialize save buttons if the function exists
            if (typeof initializeSaveButtons === 'function') {
                initializeSaveButtons();
            }
        });
    </script>

</x-layout>
