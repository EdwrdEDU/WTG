<x-layout>
<!-- Page Header -->
<div class="events-page-header">
    <div class="container">
        <h1>Edit Your Event</h1>
        <p>Update your event details</p>
    </div>
</div>

<!-- Edit Event Form -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card event-form-card">
                <div class="card-body">
                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Basic Information -->
                        <div class="event-form-section">
                            <h3 class="section-title">Basic Information</h3>
                            
                            <div class="mb-3">
                                <label for="event-title" class="form-label">Event Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="event-title" name="title" value="{{ old('title', $event->title) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-organizer" class="form-label">Organizer</label>
                                <input type="text" class="form-control" id="event-organizer" name="organizer" value="{{ old('organizer', $event->organizer) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-description" class="form-label">Description <span class="required">*</span></label>
                                <textarea class="form-control" id="event-description" name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-category" class="form-label">Category <span class="required">*</span></label>
                                <select class="form-select" id="event-category" name="category_id" required>
                                    <option value="">Select a category</option>
                                    <option value="1" {{ old('category_id', $event->category_id) == 1 ? 'selected' : '' }}>Music</option>
                                    <option value="2" {{ old('category_id', $event->category_id) == 2 ? 'selected' : '' }}>Food & Drink</option>
                                    <option value="3" {{ old('category_id', $event->category_id) == 3 ? 'selected' : '' }}>Arts & Culture</option>
                                    <option value="4" {{ old('category_id', $event->category_id) == 4 ? 'selected' : '' }}>Business & Professional</option>
                                    <option value="5" {{ old('category_id', $event->category_id) == 5 ? 'selected' : '' }}>Community & Causes</option>
                                    <option value="6" {{ old('category_id', $event->category_id) == 6 ? 'selected' : '' }}>Education</option>
                                    <option value="7" {{ old('category_id', $event->category_id) == 7 ? 'selected' : '' }}>Fashion & Beauty</option>
                                    <option value="8" {{ old('category_id', $event->category_id) == 8 ? 'selected' : '' }}>Film & Media</option>
                                    <option value="9" {{ old('category_id', $event->category_id) == 9 ? 'selected' : '' }}>Health & Wellness</option>
                                    <option value="10" {{ old('category_id', $event->category_id) == 10 ? 'selected' : '' }}>Hobbies & Interest</option>
                                    <option value="11" {{ old('category_id', $event->category_id) == 11 ? 'selected' : '' }}>Sports & Fitness</option>
                                    <option value="12" {{ old('category_id', $event->category_id) == 12 ? 'selected' : '' }}>Technology</option>
                                    <option value="13" {{ old('category_id', $event->category_id) == 13 ? 'selected' : '' }}>Travel & Outdoor</option>
                                    <option value="14" {{ old('category_id', $event->category_id) == 14 ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Event Type <span class="required">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type" id="type-in-person" value="in-person" {{ old('event_type', $event->event_type) == 'in-person' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type-in-person">In Person</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type" id="type-online" value="online" {{ old('event_type', $event->event_type) == 'online' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type-online">Online</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type" id="type-hybrid" value="hybrid" {{ old('event_type', $event->event_type) == 'hybrid' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type-hybrid">Hybrid</label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-image" class="form-label">Event Image</label>
                                @if($event->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $event->image) }}" alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                                        <p class="small text-muted">Current image (upload new to replace)</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="event-image" name="image" accept="image/*">
                            </div>
                            
                            <!-- Event Details -->
                            <h3 class="section-title mt-4">Event Details</h3>
                            
                            <div class="mb-3">
                                <label class="form-label">Date and Time <span class="required">*</span></label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label for="start-date" class="form-label small">Start Date</label>
                                        <input type="date" class="form-control" id="start-date" name="start_date" value="{{ old('start_date', $event->start_date) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="start-time" class="form-label small">Start Time</label>
                                        <input type="time" class="form-control" id="start-time" name="start_time" value="{{ old('start_time', $event->start_time) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control mb-2" id="venue-name" name="venue_name" placeholder="Venue Name" value="{{ old('venue_name', $event->venue_name) }}">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ old('address', $event->address) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ticket Information</label>
                                <div class="ticket-item p-3 border rounded mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="ticket_name" placeholder="Ticket Name" value="{{ old('ticket_name', $event->ticket_name) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="ticket_quantity" placeholder="Quantity" min="1" value="{{ old('ticket_quantity', $event->ticket_quantity) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="ticket_price" placeholder="Price (₱)" min="0" step="0.01" value="{{ old('ticket_price', $event->ticket_price) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/my-events" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Event</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Event Update Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="event-tip-list">
                        <li><strong>Keep it updated</strong> - Make sure all information is current</li>
                        <li><strong>Notify attendees</strong> - Let people know about important changes</li>
                        <li><strong>High-quality images</strong> - Update images if you have better ones</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout>