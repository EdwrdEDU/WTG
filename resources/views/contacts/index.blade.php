<x-layout>
<div class="contact-form-wrapper">
    <!-- Main Content Section -->
    <div class="contact-form-container">
        <div class="contact-form-header">
            <h1 class="contact-form-title">Get in Touch</h1>
            <p class="contact-form-subtitle">We'd love to hear from you</p>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form-card">
            <form class="contact-form" >
                @csrf
                <div class="contact-form-grid">
                    <div class="contact-form-field">
                        <label for="contact_first_name" class="contact-form-label">First Name</label>
                        <input type="text" id="contact_first_name" name="first_name" class="contact-form-input" required>
                    </div>
                    <div class="contact-form-field">
                        <label for="contact_last_name" class="contact-form-label">Last Name</label>
                        <input type="text" id="contact_last_name" name="last_name" class="contact-form-input" required>
                    </div>
                </div>
                <div class="contact-form-field">
                    <label for="contact_email" class="contact-form-label">Email Address</label>
                    <input type="email" id="contact_email" name="email" class="contact-form-input" required>
                </div>
                <div class="contact-form-field">
                    <label for="contact_phone" class="contact-form-label">Phone Number</label>
                    <input type="tel" id="contact_phone" name="phone" class="contact-form-input" required>
                </div>
                <div class="contact-form-field">
                    <label for="contact_concern" class="contact-form-label">How can we help?</label>
                    <textarea id="contact_concern" name="concern" class="contact-form-textarea" required></textarea>
                </div>
                <div class="contact-form-button-wrapper">
                    <button type="submit" class="contact-form-submit">
                        <span>Send Message</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layout>
