<!-- simplified-help-center.blade.php -->
<x-layout>
    <div class="help-center-container">
        <!-- Header -->
        <div class="help-center-header">
            <h1 class="help-center-title">Help Center</h1>
            <p class="help-center-subtitle">Find answers to common questions about using WTG?</p>
        </div>


<!-- Main Content -->
<div class="help-center-content">
        <!-- Categories Section -->
        <div class="help-center-categories">
            <h2 class="help-center-section-title">Help Categories</h2>
            <div class="help-center-category-grid">
                <a href="#account" class="help-center-category-card">
                    <i class="bi bi-person-circle help-center-category-icon"></i>
                    <h3 class="help-center-category-title">Account & Profile</h3>
                    <p>Manage your account settings</p>
                </a>
                <a href="#events" class="help-center-category-card">
                    <i class="bi bi-calendar-event help-center-category-icon"></i>
                    <h3 class="help-center-category-title">Finding Events</h3>
                    <p>Discover events in your area</p>
                </a>
                <a href="#tickets" class="help-center-category-card">
                    <i class="bi bi-ticket-perforated help-center-category-icon"></i>
                    <h3 class="help-center-category-title">Tickets</h3>
                    <p>Buying and managing tickets</p>
                </a>
                <a href="#organizing" class="help-center-category-card">
                    <i class="bi bi-megaphone help-center-category-icon"></i>
                    <h3 class="help-center-category-title">Organizing</h3>
                    <p>Create and manage events</p>
                </a>
            </div>
        </div>

        <!-- FAQs Section -->
        <div class="help-center-faqs">
            <h2 class="help-center-section-title">FAQs</h2>
            
            <!-- Account FAQs -->
            <div id="account" class="help-center-faq-category">
                <h3 class="help-center-faq-category-title">Account & Profile</h3>
                
                <div class="help-center-accordion">
                    <div class="help-center-accordion-item">
                        <button class="help-center-accordion-button">
                            How do I create an account?
                            <i class="bi bi-chevron-down help-center-accordion-icon"></i>
                        </button>
                        <div class="help-center-accordion-content">
                            <p>Click "Sign Up", enter your email, create a password, and follow the instructions.</p>
                        </div>
                    </div>
                    
                    <div class="help-center-accordion-item">
                        <button class="help-center-accordion-button">
                            How do I reset my password?
                            <i class="bi bi-chevron-down help-center-accordion-icon"></i>
                        </button>
                        <div class="help-center-accordion-content">
                            <p>Click "Log In", select "Forgot Password", enter your email, and follow the reset instructions.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Events FAQs -->
            <div id="events" class="help-center-faq-category">
                <h3 class="help-center-faq-category-title">Finding Events</h3>
                
                <div class="help-center-accordion">
                    <div class="help-center-accordion-item">
                        <button class="help-center-accordion-button">
                            How do I search for events?
                            <i class="bi bi-chevron-down help-center-accordion-icon"></i>
                        </button>
                        <div class="help-center-accordion-content">
                            <p>Use the search bar, enter your location, and filter by date, category, or price.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tickets FAQs -->
            <div id="tickets" class="help-center-faq-category">
                <h3 class="help-center-faq-category-title">Tickets</h3>
                <div class="help-center-accordion">
                    <div class="help-center-accordion-item">
                        <button class="help-center-accordion-button">
                            How do I purchase tickets?
                            <i class="bi bi-chevron-down help-center-accordion-icon"></i>
                        </button>
                        <div class="help-center-accordion-content">
                            <p>Navigate to the event page, click "Get Tickets", select quantity, and complete checkout.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Organizing FAQs -->
            <div id="organizing" class="help-center-faq-category">
                <h3 class="help-center-faq-category-title">Organizing</h3>
                <div class="help-center-accordion">
                    <div class="help-center-accordion-item">
                        <button class="help-center-accordion-button">
                            How do I create an event?
                            <i class="bi bi-chevron-down help-center-accordion-icon"></i>
                        </button>
                        <div class="help-center-accordion-content">
                            <p>Click "Create Events", fill out the form with event details, and click "Publish Event".</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Support -->
        <div class="help-center-support">
            <h2 class="help-center-section-title">Need More Help?</h2>
            <div class="help-center-support-options">
                <a href="/contacts" class="help-center-support-card">
                    <i class="bi bi-chat-dots help-center-support-icon"></i>
                    <h3>Contact Support</h3>
                    <p>Submit a request for help</p>
                </a>
               
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for accordion -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionButtons = document.querySelectorAll('.help-center-accordion-button');
        
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('active');
                const content = this.nextElementSibling;
                content.classList.toggle('active');
            });
        });
    });
</script>
</x-layout>