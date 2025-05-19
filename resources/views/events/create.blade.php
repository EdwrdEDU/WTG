<x-layout>
<!-- Page Header -->
<div class="events-page-header">
    <div class="container">
        <h1>Create Your Event</h1>
        <p>Share your passion with the community</p>
    </div>
</div>




<!-- Create Event Form -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card event-form-card">
                <div class="card-body">
                    <form action="/events" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Form Navigation -->
                        <div class="event-form-nav mb-4">
                            <div class="nav-item active">
                                <span class="nav-number">1</span>
                                <span class="nav-text">Basic Info</span>
                            </div>
                            <div class="nav-item">
                                <span class="nav-number">2</span>
                                <span class="nav-text">Details</span>
                            </div>
                            <div class="nav-item">
                                <span class="nav-number">3</span>
                                <span class="nav-text">Publish</span>
                            </div>
                        </div>
                        
                        <!-- Basic Info Section -->
                        <div class="event-form-section" id="basic-info">
                            <h3 class="section-title">Basic Information</h3>
                            
                            <div class="mb-3">
                                <label for="event-title" class="form-label">Event Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="event-title" name="title" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-organizer" class="form-label">Organizer</label>
                                <input type="text" class="form-control" id="event-organizer" name="organizer">
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-description" class="form-label">Description <span class="required">*</span></label>
                                <textarea class="form-control" id="event-description" name="description" rows="4" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-category" class="form-label">Category <span class="required">*</span></label>
                                <select class="form-select" id="event-category" name="category_id" required>
                                    <option value="" selected disabled>Select a category</option>
                                    <option value="1">Music</option>
                                    <option value="2">Food & Drink</option>
                                    <option value="3">Arts & Culture</option>
                                    <option value="4">Business & Professional</option>
                                    <option value="5">Community & Causes</option>
                                    <option value="6">Education</option>
                                    <option value="7">Fashion & Beauty</option>
                                    <option value="8">Film & Media</option>
                                    <option value="9">Health & Wellness</option>
                                    <option value="10">Hobbies & Interest</option>
                                    <option value="11">Sports & Fitness</option>
                                    <option value="12">Technology</option>
                                    <option value="13">Travel & Outdoor</option>
                                    <option value="14">Other</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Event Type <span class="required">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type" id="type-in-person" value="in-person" checked>
                                    <label class="form-check-label" for="type-in-person">In Person</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type" id="type-online" value="online">
                                    <label class="form-check-label" for="type-online">Online</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type" id="type-hybrid" value="hybrid">
                                    <label class="form-check-label" for="type-hybrid">Hybrid</label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event-image" class="form-label">Event Image <span class="required">*</span></label>
                                <input type="file" class="form-control" id="event-image" name="image" accept="image/*" required>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary event-next-btn" data-next="details">Continue to Details</button>
                            </div>
                        </div>
                        
                        <!-- Details Section -->
                        <div class="event-form-section d-none" id="details">
                            <h3 class="section-title">Event Details</h3>
                            
                            <div class="mb-3">
                                <label class="form-label">Date and Time <span class="required">*</span></label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label for="start-date" class="form-label small">Start Date</label>
                                        <input type="date" class="form-control" id="start-date" name="start_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="start-time" class="form-label small">Start Time</label>
                                        <input type="time" class="form-control" id="start-time" name="start_time" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Location <span class="required">*</span></label>
                                <input type="text" class="form-control mb-2" id="venue-name" name="venue_name" placeholder="Venue Name">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ticket Information</label>
                                <div class="ticket-item p-3 border rounded mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="tickets_name" placeholder="Ticket Name (e.g. General Admission)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="tickets_quantity" placeholder="Quantity" min="1">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="tickets_price" placeholder="Price (₱)" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary event-prev-btn" data-prev="basic-info">Back</button>
                                <button type="button" class="btn btn-primary event-next-btn" data-next="publish">Continue to Publish</button>
                            </div>
                        </div>
                        
                        <!-- Publish Section -->
                        <div class="event-form-section d-none" id="publish">
                            <h3 class="section-title">Ready to Publish?</h3>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="agree_terms" required>
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to the <a href="#" class="text-primary">Terms and Conditions</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="publish-cta text-center p-4 mb-3 bg-light rounded">
                                <h4>Ready to Share Your Event?</h4>
                                <p>Once published, your event will be live on WTG? for everyone to see</p>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary event-prev-btn" data-prev="details">Back</button>
                                <button type="submit" class="btn btn-success">Publish Event</button>
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
                    <h5 class="mb-0">Event Creation Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="event-tip-list">
                        <li><strong>Be descriptive</strong> - Make your event title clear and appealing</li>
                        <li><strong>Add quality images</strong> - Events with high-quality images get more views</li>
                        <li><strong>Be detailed</strong> - Include all important information about your event</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Next button functionality
    const nextButtons = document.querySelectorAll('.event-next-btn');
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextSection = this.getAttribute('data-next');
            const currentSection = this.closest('.event-form-section');
            
            currentSection.classList.add('d-none');
            document.getElementById(nextSection).classList.remove('d-none');
            
            // Update navigation
            updateNavigation(nextSection);
        });
    });
    
    // Previous button functionality
    const prevButtons = document.querySelectorAll('.event-prev-btn');
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const prevSection = this.getAttribute('data-prev');
            const currentSection = this.closest('.event-form-section');
            
            currentSection.classList.add('d-none');
            document.getElementById(prevSection).classList.remove('d-none');
            
            // Update navigation
            updateNavigation(prevSection);
        });
    });
    
    function updateNavigation(activeSection) {
        const navItems = document.querySelectorAll('.event-form-nav .nav-item');
        navItems.forEach(item => item.classList.remove('active'));
        
        if (activeSection === 'basic-info') {
            navItems[0].classList.add('active');
        } else if (activeSection === 'details') {
            navItems[1].classList.add('active');
        } else if (activeSection === 'publish') {
            navItems[2].classList.add('active');
        }
    }
});
</script>
</x-layout>
