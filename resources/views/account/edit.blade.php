<x-layout>
<div class="profile-settings-wrapper">
    <div class="profile-customization-header">
        <h1 class="profile-settings-main-title">Profile Settings</h1>
        <p class="profile-settings-description">Customize your profile information</p>
    </div>

    <div class="profile-customization-content">
        <div class="user-profile-settings-card">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('account.edit') }}" method="POST" enctype="multipart/form-data" class="profile-update-form">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div class="personal-info-customization-section">
                    <h3 class="personal-details-heading">Personal Information</h3>
                    <div class="user-details-form-grid">
                        <div class="firstname-input-group">
                            <label for="user-first-name-field" class="firstname-label">First Name</label>
                            <input type="text" id="user-first-name-field" name="firstname" 
                                   value="{{ old('firstname', auth()->user()->firstname) }}" 
                                   class="firstname-text-input" required>
                        </div>
                        
                        <div class="lastname-input-group">
                            <label for="user-last-name-field" class="lastname-label">Last Name</label>
                            <input type="text" id="user-last-name-field" name="lastname" 
                                   value="{{ old('lastname', auth()->user()->lastname) }}" 
                                   class="lastname-text-input" required>
                        </div>
                        
                        <div class="email-input-group full-width-input">
                            <label for="user-email-address-field" class="email-address-label">Email Address</label>
                            <input type="email" id="user-email-address-field" name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   class="email-address-input" required>
                        </div>
                        
                        <div class="phone-input-group">
                            <label for="user-phone-field" class="user-phone-label">Phone</label>
                            <input type="tel" id="user-phone-field" name="phone" 
                                   value="{{ old('phone', auth()->user()->phone) }}" 
                                   class="user-phone-input" placeholder="e.g. +1 (555) 123-4567">
                        </div>
                        
                        <div class="date-of-birth-input-group">
                            <label for="user-date-of-birth-field" class="user-date-of-birth-label">Date of Birth</label>
                            <input type="date" id="user-date-of-birth-field" name="date_of_birth" 
                                   value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" 
                                   class="user-date-of-birth-input">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="profile-settings-action-buttons">
                    <button type="button" class="cancel-profile-changes-btn" onclick="history.back()">Cancel</button>
                    <button type="submit" class="save-profile-changes-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layout>