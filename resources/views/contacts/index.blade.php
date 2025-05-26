<x-layout>
<div class="contact-form-wrapper">


    <!-- Main Content Section -->
    <div class="contact-form-container">
        <div class="contact-form-header">
            <div class="contact-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <h1 class="contact-form-title">Get in Touch</h1>
            <p class="contact-form-subtitle">We'd love to hear from you</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="alert alert-error">
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="alert-content">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Contact Form -->
        <div class="contact-form-card">
            <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="contact-form-grid">
                    <div class="contact-form-field">
                        <label for="contact_first_name" class="contact-form-label">
                            <span class="label-text">First Name</span>
                            <span class="label-required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" id="contact_first_name" name="first_name" class="contact-form-input" value="{{ old('first_name') }}" required>
                            <div class="input-focus-border"></div>
                        </div>
                    </div>

                    <div class="contact-form-field">
                        <label for="contact_last_name" class="contact-form-label">
                            <span class="label-text">Last Name</span>
                            <span class="label-required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" id="contact_last_name" name="last_name" class="contact-form-input" value="{{ old('last_name') }}" required>
                            <div class="input-focus-border"></div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-field">
                    <label for="contact_email" class="contact-form-label">
                        <span class="label-text">Email Address</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22 6 12 13 2 6"></polyline>
                            </svg>
                        </div>
                        <input type="email" id="contact_email" name="email" class="contact-form-input has-icon" value="{{ old('email') }}" required>
                        <div class="input-focus-border"></div>
                    </div>
                </div>

                <div class="contact-form-field">
                    <label for="contact_phone" class="contact-form-label">
                        <span class="label-text">Phone Number</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <input type="tel" id="contact_phone" name="phone" class="contact-form-input has-icon" value="{{ old('phone') }}" required>
                        <div class="input-focus-border"></div>
                    </div>
                </div>

                <div class="contact-form-field">
                    <label for="contact_concern" class="contact-form-label">
                        <span class="label-text">How can we help?</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <textarea id="contact_concern" name="concern" class="contact-form-textarea" placeholder="Tell us about your inquiry..." required>{{ old('concern') }}</textarea>
                        <div class="input-focus-border"></div>
                    </div>
                </div>

                <div class="contact-form-button-wrapper">
                    <button type="submit" class="contact-form-submit">
                        <span class="button-text">Send Message</span>
                        <div class="button-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </div>
                        <div class="button-ripple"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layout>