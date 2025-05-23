<x-layout>
<div class="profile-settings-wrapper">
    <div class="profile-customization-header">
        <h1 class="profile-settings-main-title">Profile Settings</h1>
        <p class="profile-settings-description">Customize your profile information</p>
    </div>

    <div class="profile-customization-content">
        <div class="user-profile-settings-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-update-form">
                @csrf
                @method('PUT')

                <!-- Profile Picture Section -->
                <div class="avatar-customization-section">
                    <h3 class="avatar-section-heading">Profile Picture</h3>
                    <div class="user-avatar-upload-area">
                        <div class="current-avatar-preview-container">
                            <img src="{{ auth()->user()->profile_image ?? asset('images/default-avatar.png') }}" 
                                 alt="Profile Picture" id="user-avatar-display-image" class="current-user-avatar">
                        </div>
                        <div class="avatar-upload-controls">
                            <input type="file" id="user-profile-image-input" name="profile_image" accept="image/*" class="hidden-file-upload-input">
                            <label for="user-profile-image-input" class="change-avatar-button">
                                <i class="fas fa-camera"></i>
                                Change Photo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="personal-info-customization-section">
                    <h3 class="personal-details-heading">Personal Information</h3>
                    <div class="user-details-form-grid">
                        <div class="firstname-input-group">
                            <label for="user-first-name-field" class="firstname-label">First Name</label>
                            <input type="text" id="user-first-name-field" name="first_name" 
                                   value="{{ old('first_name', auth()->user()->first_name) }}" 
                                   class="firstname-text-input" required>
                        </div>
                        
                        <div class="lastname-input-group">
                            <label for="user-last-name-field" class="lastname-label">Last Name</label>
                            <input type="text" id="user-last-name-field" name="last_name" 
                                   value="{{ old('last_name', auth()->user()->last_name) }}" 
                                   class="lastname-text-input" required>
                        </div>
                        
                        <div class="email-input-group full-width-input">
                            <label for="user-email-address-field" class="email-address-label">Email Address</label>
                            <input type="email" id="user-email-address-field" name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   class="email-address-input" required>
                        </div>
                        
                        <div class="country-input-group">
                            <label for="user-country-field" class="user-country-label">Country</label>
                            <input type="text" id="user-country-field" name="country" 
                                   value="{{ old('country', auth()->user()->country) }}" 
                                   class="user-country-input" placeholder="e.g. United States">
                        </div>
                    </div>
                </div>

                <!-- Bio Section -->
                <div class="user-bio-customization-section">
                    <h3 class="bio-section-heading">About</h3>
                    <div class="bio-textarea-group">
                        <label for="user-biography-textarea" class="biography-label">Bio</label>
                        <textarea id="user-biography-textarea" name="bio" class="user-biography-input" rows="4" 
                                  placeholder="Tell us a little about yourself...">{{ old('bio', auth()->user()->bio) }}</textarea>
                        <small class="bio-character-counter">0/500 characters</small>
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

<script>
// Preview profile image
document.getElementById('user-profile-image-input').addEventListener('change', function(e) {
    const selectedFile = e.target.files[0];
    if (selectedFile) {
        const imageReader = new FileReader();
        imageReader.onload = function(e) {
            document.getElementById('user-avatar-display-image').src = e.target.result;
        };
        imageReader.readAsDataURL(selectedFile);
    }
});

// Character counter for bio
document.getElementById('user-biography-textarea').addEventListener('input', function() {
    const currentCharCount = this.value.length;
    const maxCharLimit = 500;
    document.querySelector('.bio-character-counter').textContent = `${currentCharCount}/${maxCharLimit} characters`;
    
    if (currentCharCount > maxCharLimit) {
        this.value = this.value.substring(0, maxCharLimit);
        document.querySelector('.bio-character-counter').textContent = `${maxCharLimit}/${maxCharLimit} characters`;
    }
});

// Initialize character count
document.addEventListener('DOMContentLoaded', function() {
    const biographyTextarea = document.getElementById('user-biography-textarea');
    const initialCharCount = biographyTextarea.value.length;
    document.querySelector('.bio-character-counter').textContent = `${initialCharCount}/500 characters`;
});
</script>
</x-layout>