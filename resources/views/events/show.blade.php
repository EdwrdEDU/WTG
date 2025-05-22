<x-layout>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Event Image -->
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid rounded mb-4" alt="{{ $event->title }}">
            @endif
            
            <!-- Event Details -->
            <h1>{{ $event->title }}</h1>
            
            @if($event->organizer)
                <p class="text-muted">Organized by: {{ $event->organizer }}</p>
            @endif
            
            <div class="mb-4">
                <h5>About this event</h5>
                <p>{{ $event->description }}</p>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6><i class="bi bi-calendar"></i> Date & Time</h6>
                    <p>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                </div>
                <div class="col-md-6">
                    <h6><i class="bi bi-geo-alt"></i> Location</h6>
                    @if($event->event_type === 'online')
                        <p>Online Event</p>
                    @else
                        <p>{{ $event->venue_name ?? 'Venue TBA' }}<br>
                        {{ $event->address ?? 'Address TBA' }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Ticket Info -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->ticket_name }}</h5>
                    <h3 class="text-primary">₱{{ number_format($event->ticket_price, 2) }}</h3>
                    <p class="text-muted">{{ $event->ticket_quantity }} tickets available</p>
                    
                    @if($event->account_id === auth()->id())
                        <!-- Owner actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Edit Event</a>
                            <button class="btn btn-danger" onclick="confirmDelete({{ $event->id }})">Delete Event</button>
                        </div>
                    @else
                        <!-- Visitor actions -->
                        <div class="d-grid">
                            <button class="btn btn-primary">Get Tickets</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this event? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(eventId) {
    const form = document.getElementById('deleteForm');
    form.action = `/events/${eventId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
</x-layout>