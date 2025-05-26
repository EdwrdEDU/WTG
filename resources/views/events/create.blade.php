<x-layout>
<!-- Page Header -->
<div class="events-page-header">
    <div class="container">
        <h1>Create Your Event</h1>
        <p>Share your event with the community</p>
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
                            <div class="alert alert-danger simple-alert">
                                <h6>Please fix the following errors:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Simple Step Navigation -->
                        <div class="step-nav mb-4">
                            <div class="step-item active" data-step="1">
                                <span class="step-number">1</span>
                                <span class="step-text">Basic Info</span>
                            </div>
                            <div class="step-item" data-step="2">
                                <span class="step-number">2</span>
                                <span class="step-text">Details</span>
                            </div>
                            <div class="step-item" data-step="3">
                                <span class="step-number">3</span>
                                <span class="step-text">Review</span>
                            </div>
                        </div>
                        
                        <!-- Step 1: Basic Info -->
                        <div class="form-section active" id="step-1">
                            <h3 class="section-title">Basic Information</h3>
                            
                            <div class="form-group mb-3">
                                <label for="event-title" class="form-label">Event Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="event-title" name="title" 
                                       placeholder="Enter your event title" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="event-organizer" class="form-label">Organizer</label>
                                <input type="text" class="form-control" id="event-organizer" name="organizer"
                                       placeholder="Your name or organization">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="event-description" class="form-label">Description <span class="required">*</span></label>
                                <textarea class="form-control" id="event-description" name="description" 
                                          rows="4" placeholder="Describe your event" required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
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
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Event Type <span class="required">*</span></label>
                                        <div class="event-type-options">
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
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="event-image" class="form-label">Event Image <span class="required">*</span></label>
                                <input type="file" class="form-control" id="event-image" name="image" accept="image/*" required>
                                <small class="form-text text-muted">Upload a clear image that represents your event</small>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary next-btn" data-next="2">
                                    Next: Event Details
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2: Event Details -->
                        <div class="form-section" id="step-2">
                            <h3 class="section-title">Event Details</h3>
                            
                            <div class="form-group mb-3">
                                <label class="form-label">Date and Time <span class="required">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="start-date" class="form-label small">Date</label>
                                        <input type="date" class="form-control" id="start-date" name="start_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="start-time" class="form-label small">Time</label>
                                        <input type="time" class="form-control" id="start-time" name="start_time" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label">Location <span class="required">*</span></label>
                                <input type="text" class="form-control mb-2" id="venue-name" name="venue_name" 
                                       placeholder="Venue Name">
                                <input type="text" class="form-control" id="address" name="address" 
                                       placeholder="Full Address">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label">Ticket Information</label>
                                <div class="ticket-info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-2" name="ticket_name" 
                                                   placeholder="Ticket Name (e.g. General Admission)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control mb-2" name="ticket_quantity" 
                                                   placeholder="Quantity" min="1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">₱</span>
                                                <input type="number" class="form-control" name="ticket_price" 
                                                       placeholder="0.00" min="0" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary prev-btn" data-prev="1">
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next-btn" data-next="3">
                                    Next: Review
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 3: Review -->
                        <div class="form-section" id="step-3">
                            <h3 class="section-title">Review & Publish</h3>
                            
                            <div class="review-section mb-4">
                                <p class="text-muted">Please review your event details before publishing.</p>
                            </div>
                            
                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="agree_terms" required>
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and 
                                        <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary prev-btn" data-prev="2">
                                    Previous
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Publish Event
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Simple Sidebar -->
        <div class="col-lg-4">
            <div class="card sidebar-card">
                <div class="card-header">
                    <h5 class="mb-0">Tips for Success</h5>
                </div>
                <div class="card-body">
                    <div class="tip-item">
                        <strong>Clear Title:</strong> Make your event title descriptive and engaging
                    </div>
                    <div class="tip-item">
                        <strong>Good Image:</strong> Use a high-quality image that represents your event
                    </div>
                    <div class="tip-item">
                        <strong>Complete Details:</strong> Include all important information attendees need
                    </div>
                    <div class="tip-item">
                        <strong>Plan Ahead:</strong> Give people enough time to discover and attend
                    </div>
                </div>
            </div>
            
            <div class="card sidebar-card">
                <div class="card-body">
                    <h6>Need Help?</h6>
                    <p class="mb-0">Check our <a href="#" class="text-primary">Event Guide</a> or <a href="#" class="text-primary">Contact Support</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nextButtons = document.querySelectorAll('.next-btn');
    const prevButtons = document.querySelectorAll('.prev-btn');
    const stepItems = document.querySelectorAll('.step-item');
    const formSections = document.querySelectorAll('.form-section');
    
    // Next button functionality
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextStep = parseInt(this.getAttribute('data-next'));
            showStep(nextStep);
        });
    });
    
    // Previous button functionality
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const prevStep = parseInt(this.getAttribute('data-prev'));
            showStep(prevStep);
        });
    });
    
    function showStep(stepNumber) {
        // Hide all sections
        formSections.forEach(section => {
            section.classList.remove('active');
        });
        
        // Show target section
        document.getElementById('step-' + stepNumber).classList.add('active');
        
        // Update step navigation
        stepItems.forEach((item, index) => {
            item.classList.remove('active', 'completed');
            if (index + 1 < stepNumber) {
                item.classList.add('completed');
            } else if (index + 1 === stepNumber) {
                item.classList.add('active');
            }
        });
    }
    
    // Form validation
    const form = document.querySelector('form');
    const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    requiredInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>
</x-layout>