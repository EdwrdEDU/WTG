<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>My Events</h1>
            <a href="{{ route('events.create') }}" class="btn btn-primary">Create New Event</a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($events->count() > 0)
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <p class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                    <br>
                                    <i class="bi bi-geo-alt"></i> {{ $event->venue_name ?? 'Online Event' }}
                                    <br>
                                    <i class="bi bi-ticket"></i> ₱{{ number_format($event->ticket_price, 2) }}
                                </p>
                                <div class="btn-group w-100">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-info">View</a>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $event->id }})">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{ $events->links() }}
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                <h3>No events yet</h3>
                <p>You haven't created any events yet. Start by creating your first event!</p>
                <a href="{{ route('events.create') }}" class="btn btn-primary">Create Your First Event</a>
            </div>
        @endif
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