<x-layout>
<div class="event-details-wrapper">
    <div class="event-main-content">
        <div class="event-info-section">
            <!-- Hero Image Section -->
            @if($event->image)
                <div class="event-hero-image">
                    <img src="{{ asset('storage/' . $event->image) }}" 
                         class="event-featured-img" 
                         alt="{{ $event->title }}">
                </div>
            @endif
            
            <!-- Event Header -->
            <div class="event-header-block">
                <h1 class="event-main-title">{{ $event->title }}</h1>
                
                @if($event->organizer)
                    <p class="event-organizer-info">Organized by: {{ $event->organizer }}</p>
                @endif
            </div>
            
            <!-- Event Description -->
            <div class="event-description-block">
                <h2 class="event-section-heading">About this event</h2>
                <p class="event-description-text">{{ $event->description }}</p>
            </div>
            
            <!-- Event Details Grid -->
            <div class="event-details-grid">
                <div class="event-datetime-card">
                    <h3 class="event-detail-title">
                        <i class="bi bi-calendar event-icon"></i> Date & Time
                    </h3>
                    <p class="event-detail-info">
                        {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }} 
                        at {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                    </p>
                </div>
                
                <div class="event-location-card">
                    <h3 class="event-detail-title">
                        <i class="bi bi-geo-alt event-icon"></i> Location
                    </h3>
                    @if($event->event_type === 'online')
                        <p class="event-detail-info event-online-badge">Online Event</p>
                    @else
                        <p class="event-detail-info">
                            {{ $event->venue_name ?? 'Venue TBA' }}<br>
                            {{ $event->address ?? 'Address TBA' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Ticket Sidebar -->
        <div class="event-ticket-sidebar">
            <div class="ticket-purchase-card">
                <div class="ticket-card-content">
                    <h2 class="ticket-type-name">{{ $event->ticket_name }}</h2>
                    <div class="ticket-price-display">₱{{ number_format($event->ticket_price, 2) }}</div>
                    <p class="ticket-availability-info">{{ $event->ticket_quantity }} tickets available</p>
                    
                    @if($event->account_id === auth()->id())
                        <!-- Event Owner Controls -->
                        <div class="event-owner-actions">
                            <a href="{{ route('events.edit', $event) }}" 
                               class="btn-event-edit">Edit Event</a>
                            <button class="btn-event-delete" 
                                    onclick="showDeleteConfirmation({{ $event->id }})">
                                Delete Event
                            </button>
                        </div>
                    @else
                        <!-- Customer Actions -->
                        <div class="customer-action-buttons">
                            <button class="btn-purchase-tickets">Get Tickets</button>
                            
                            @auth
                                <button class="btn-save-event" 
                                        data-event-id="{{ $event->id }}" 
                                        data-event-type="local"
                                        title="Save this event to your favorites">
                                    <i class="bi bi-heart save-heart-icon"></i> Save Event
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-login-to-save">
                                    <i class="bi bi-heart save-heart-icon"></i> Login to Save
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="delete-confirmation-modal" id="eventDeleteModal" style="display: none;">
    <div class="modal-backdrop-overlay">
        <div class="modal-content-container">
            <div class="modal-header-section">
                <h3 class="modal-title-text">Confirm Event Deletion</h3>
                <button type="button" class="modal-close-btn" onclick="hideDeleteConfirmation()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body-section">
                <p class="modal-warning-text">
                    Are you sure you want to delete this event? This action cannot be undone and all associated data will be permanently removed.
                </p>
            </div>
            <div class="modal-footer-section">
                <button type="button" class="btn-modal-cancel" onclick="hideDeleteConfirmation()">
                    Cancel
                </button>
                <form id="eventDeleteForm" method="POST" class="delete-form-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modal-delete">Delete Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showDeleteConfirmation(eventId) {
    const deleteForm = document.getElementById('eventDeleteForm');
    const modal = document.getElementById('eventDeleteModal');
    
    deleteForm.action = `/events/${eventId}`;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function hideDeleteConfirmation() {
    const modal = document.getElementById('eventDeleteModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Save event functionality
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.querySelector('.btn-save-event');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            const heartIcon = this.querySelector('.save-heart-icon');
            const buttonText = this.childNodes[1];
            
            // Toggle visual state
            if (this.classList.contains('event-saved')) {
                this.classList.remove('event-saved');
                heartIcon.className = 'bi bi-heart save-heart-icon';
                buttonText.textContent = ' Save Event';
            } else {
                this.classList.add('event-saved');
                heartIcon.className = 'bi bi-heart-fill save-heart-icon';
                buttonText.textContent = ' Event Saved';
            }
        });
    }
});
</script>
</x-layout>