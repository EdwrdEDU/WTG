<x-layout>
<!-- Page Header -->
<div class="wtg-event-header-section">
    <div class="wtg-main-container">
        <h1>Edit Your Event</h1>
        <p>Update your event details</p>
    </div>
</div>

<!-- Edit Event Form -->
<div class="wtg-main-container wtg-content-spacing">
    <div class="wtg-layout-row">
        <div class="wtg-primary-column">
            <div class="wtg-form-card wtg-event-edit-card">
                <div class="wtg-card-content">
                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        @if ($errors->any())
                            <div class="wtg-error-alert">
                                <ul class="wtg-error-list">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Basic Information -->
                        <div class="wtg-form-section">
                            <h3 class="wtg-section-heading">Basic Information</h3>
                            
                            <div class="wtg-input-group">
                                <label for="event-title" class="wtg-field-label">Event Title <span class="wtg-required-mark">*</span></label>
                                <input type="text" class="wtg-text-input" id="event-title" name="title" value="{{ old('title', $event->title) }}" required>
                            </div>
                            
                            <div class="wtg-input-group">
                                <label for="event-organizer" class="wtg-field-label">Organizer</label>
                                <input type="text" class="wtg-text-input" id="event-organizer" name="organizer" value="{{ old('organizer', $event->organizer) }}">
                            </div>
                            
                            <div class="wtg-input-group">
                                <label for="event-description" class="wtg-field-label">Description <span class="wtg-required-mark">*</span></label>
                                <textarea class="wtg-textarea-input" id="event-description" name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
                            </div>
                            
                            <div class="wtg-input-group">
                                <label for="event-category" class="wtg-field-label">Category <span class="wtg-required-mark">*</span></label>
                                <select class="wtg-select-input" id="event-category" name="category_id" required>
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
                            
                            <div class="wtg-input-group">
                                <label class="wtg-field-label">Event Type <span class="wtg-required-mark">*</span></label>
                                <div class="wtg-radio-option">
                                    <input class="wtg-radio-input" type="radio" name="event_type" id="type-in-person" value="in-person" {{ old('event_type', $event->event_type) == 'in-person' ? 'checked' : '' }}>
                                    <label class="wtg-radio-label" for="type-in-person">In Person</label>
                                </div>
                                <div class="wtg-radio-option">
                                    <input class="wtg-radio-input" type="radio" name="event_type" id="type-online" value="online" {{ old('event_type', $event->event_type) == 'online' ? 'checked' : '' }}>
                                    <label class="wtg-radio-label" for="type-online">Online</label>
                                </div>
                                <div class="wtg-radio-option">
                                    <input class="wtg-radio-input" type="radio" name="event_type" id="type-hybrid" value="hybrid" {{ old('event_type', $event->event_type) == 'hybrid' ? 'checked' : '' }}>
                                    <label class="wtg-radio-label" for="type-hybrid">Hybrid</label>
                                </div>
                            </div>
                            
                            <div class="wtg-input-group">
                                <label for="event-image" class="wtg-field-label">Event Image</label>
                                @if($event->image)
                                    <div class="wtg-current-image-preview">
                                        <img src="{{ asset('storage/' . $event->image) }}" alt="Current image" class="wtg-preview-image">
                                        <p class="wtg-image-caption">Current image (upload new to replace)</p>
                                    </div>
                                @endif
                                <input type="file" class="wtg-file-input" id="event-image" name="image" accept="image/*">
                            </div>
                            
                            <!-- Event Details -->
                            <h3 class="wtg-section-heading wtg-section-spacing">Event Details</h3>
                            
                            <div class="wtg-input-group">
                                <label class="wtg-field-label">Date and Time <span class="wtg-required-mark">*</span></label>
                                <div class="wtg-date-time-row">
                                    <div class="wtg-date-column">
                                        <label for="start-date" class="wtg-field-sublabel">Start Date</label>
                                        <input type="date" class="wtg-text-input" id="start-date" name="start_date" value="{{ old('start_date', $event->start_date) }}" required>
                                    </div>
                                    <div class="wtg-time-column">
                                        <label for="start-time" class="wtg-field-sublabel">Start Time</label>
                                        <input type="time" class="wtg-text-input" id="start-time" name="start_time" value="{{ old('start_time', $event->start_time) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="wtg-input-group">
                                <label class="wtg-field-label">Location</label>
                                <input type="text" class="wtg-text-input wtg-location-input" id="venue-name" name="venue_name" placeholder="Venue Name" value="{{ old('venue_name', $event->venue_name) }}">
                                <input type="text" class="wtg-text-input" id="address" name="address" placeholder="Address" value="{{ old('address', $event->address) }}">
                            </div>
                            
                            <div class="wtg-input-group">
                                <label class="wtg-field-label">Ticket Information</label>
                                <div class="wtg-ticket-container">
                                    <div class="wtg-ticket-row">
                                        <div class="wtg-ticket-name-col">
                                            <input type="text" class="wtg-text-input" name="ticket_name" placeholder="Ticket Name" value="{{ old('ticket_name', $event->ticket_name) }}">
                                        </div>
                                        <div class="wtg-ticket-qty-col">
                                            <input type="number" class="wtg-text-input" name="ticket_quantity" placeholder="Quantity" min="1" value="{{ old('ticket_quantity', $event->ticket_quantity) }}">
                                        </div>
                                        <div class="wtg-ticket-price-col">
                                            <input type="number" class="wtg-text-input" name="ticket_price" placeholder="Price (₱)" min="0" step="0.01" value="{{ old('ticket_price', $event->ticket_price) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="wtg-button-actions">
                                <a href="/my-events" class="wtg-cancel-btn">Cancel</a>
                                <button type="submit" class="wtg-submit-btn">Update Event</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="wtg-sidebar-column">
            <div class="wtg-tips-card">
                <div class="wtg-card-header">
                    <h5 class="wtg-card-title">Event Update Tips</h5>
                </div>
                <div class="wtg-card-content">
                    <ul class="wtg-tips-list">
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