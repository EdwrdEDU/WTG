<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>My Saved Events</h1>
            <span class="badge bg-primary fs-6">{{ $savedEvents->total() }} saved</span>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($savedEvents->count() > 0)
            <!-- Filter Tabs -->
            <ul class="nav nav-tabs mb-4" id="savedEventsTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#all-events">All Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#upcoming-events">Upcoming</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#local-events">My Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#external-events">External Events</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- All Events Tab -->
                <div class="tab-pane fade show active" id="all-events">
                    <div class="row">
                        @foreach($savedEvents as $savedEvent)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 saved-event-card" data-saved-id="{{ $savedEvent->id }}">
                                    <div class="position-relative">
                                        <img src="{{ $savedEvent->display_image }}" 
                                             class="card-img-top" 
                                             alt="{{ $savedEvent->title }}" 
                                             style="height: 200px; object-fit: cover;">
                                        
                                        <!-- Event Type Badge -->
                                        @if($savedEvent->is_local_event)
                                            <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                                <i class="bi bi-house-fill"></i> My Event
                                            </span>
                                        @else
                                            <span class="badge bg-info position-absolute top-0 start-0 m-2">
                                                <i class="bi bi-globe"></i> External
                                            </span>
                                        @endif

                                        <!-- Remove Button -->
                                        <button class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-saved-btn"
                                                data-saved-id="{{ $savedEvent->id }}"
                                                title="Remove from saved">
                                            <i class="bi bi-heart-fill"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($savedEvent->title, 60) }}</h5>
                                        
                                        <div class="event-details mb-3">
                                            @if($savedEvent->event_date)
                                                <p class="text-muted mb-1">
                                                    <i class="bi bi-calendar"></i> {{ $savedEvent->formatted_date }}
                                                </p>
                                            @endif
                                            
                                            @if($savedEvent->venue_name)
                                                <p class="text-muted mb-1">
                                                    <i class="bi bi-geo-alt"></i> {{ $savedEvent->venue_name }}
                                                </p>
                                            @endif
                                            
                                            @if($savedEvent->price_info)
                                                <p class="text-muted mb-1">
                                                    <i class="bi bi-tag"></i> {{ $savedEvent->price_info }}
                                                </p>
                                            @endif
                                        </div>

                                        @if($savedEvent->description)
                                            <p class="card-text small">{{ Str::limit($savedEvent->description, 100) }}</p>
                                        @endif

                                        <p class="card-text">
                                            <small class="text-muted">
                                                Saved {{ $savedEvent->created_at->diffForHumans() }}
                                            </small>
                                        </p>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent">
                                        <div class="d-grid gap-2">
                                            @if($savedEvent->display_url)
                                                <a href="{{ $savedEvent->display_url }}" 
                                                   class="btn btn-primary btn-sm"
                                                   @if($savedEvent->is_external_event) target="_blank" @endif>
                                                    View Event
                                                    @if($savedEvent->is_external_event)
                                                        <i class="bi bi-box-arrow-up-right"></i>
                                                    @endif
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upcoming Events Tab -->
                <div class="tab-pane fade" id="upcoming-events">
                    <div class="row">
                        @php $upcomingEvents = $savedEvents->filter(function($event) { return $event->event_date && $event->event_date->isFuture(); }) @endphp
                        @forelse($upcomingEvents as $savedEvent)
                            <!-- Same card structure as above -->
                            <div class="col-md-4 mb-4">
                                <!-- Card content same as above -->
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                                <h4>No upcoming saved events</h4>
                                <p>Your saved events that have dates in the future will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Local Events Tab -->
                <div class="tab-pane fade" id="local-events">
                    <div class="row">
                        @php $localEvents = $savedEvents->filter(function($event) { return $event->is_local_event; }) @endphp
                        @forelse($localEvents as $savedEvent)
                            <!-- Same card structure as above -->
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-house" style="font-size: 3rem; color: #ccc;"></i>
                                <h4>No saved local events</h4>
                                <p>Events created on our platform that you've saved will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- External Events Tab -->
                <div class="tab-pane fade" id="external-events">
                    <div class="row">
                        @php $externalEvents = $savedEvents->filter(function($event) { return $event->is_external_event; }) @endphp
                        @forelse($externalEvents as $savedEvent)
                            <!-- Same card structure as above -->
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-globe" style="font-size: 3rem; color: #ccc;"></i>
                                <h4>No saved external events</h4>
                                <p>Events from external sources that you've saved will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $savedEvents->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bookmark" style="font-size: 4rem; color: #ccc;"></i>
                <h3>No saved events yet</h3>
                <p class="text-muted mb-4">Start exploring events and save the ones you're interested in!</p>
                <div class="d-grid gap-2 d-md-block">
                    <a href="{{ route('homepage') }}" class="btn btn-primary">Explore Events</a>
                    <a href="/search/page" class="btn btn-outline-primary">Search Events</a>
                </div>
            </div>
        @endif
    </div>

    <!-- Success/Error Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="saveToast" class="toast" role="alert">
            <div class="toast-header">
                <strong class="me-auto">WTG?</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                <!-- Message will be inserted here -->
            </div>
        </div>
    </div>

    <style>
    .saved-event-card {
        transition: transform 0.2s ease-in-out;
    }
    
    .saved-event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .remove-saved-btn {
        opacity: 0.8;
        transition: all 0.2s ease;
    }
    
    .remove-saved-btn:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    
    .event-details i {
        width: 16px;
        text-align: center;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle remove saved event
        document.querySelectorAll('.remove-saved-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const savedId = this.getAttribute('data-saved-id');
                removeSavedEvent(savedId);
            });
        });
    });

    function removeSavedEvent(savedId) {
        if (!confirm('Are you sure you want to remove this event from your saved list?')) {
            return;
        }

        fetch(`/saved-events/${savedId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the card from the DOM
                const card = document.querySelector(`[data-saved-id="${savedId}"]`);
                if (card) {
                    card.style.transition = 'opacity 0.3s ease';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        // Check if no events left
                        if (document.querySelectorAll('.saved-event-card').length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
                showToast(data.message, 'success');
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to remove event. Please try again.', 'error');
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('saveToast');
        const toastMessage = document.getElementById('toastMessage');
        
        toastMessage.textContent = message;
        toast.className = `toast ${type === 'success' ? 'bg-success' : 'bg-danger'} text-white`;
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
    </script>
</x-layout>