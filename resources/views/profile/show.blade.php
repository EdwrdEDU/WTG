<x-layout>
    <profile-wrapper>
        <profile-header>
            <profile-title>My Profile</profile-title>
           <!--  <profile-subtitle>Your Personal Information</profile-subtitle> -->
        </profile-header>
        
<<<<<<< HEAD
        <profile-card>
            <profile-card-header>
                <profile-section-title>Profile Information</profile-section-title>
            </profile-card-header>
            
            <profile-card-body>
                <profile-info-item>
                    <profile-label>Name:</profile-label>
                    <profile-value>{{ $user->firstname }} {{ $user->lastname }}</profile-value>
                </profile-info-item>
=======
        <div class="card">
            <div class="card-body">
                <h5>Profile Information</h5>
                <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                <p><strong>Date of Birth:</strong> {{ optional($user->date_of_birth)->format('M d, Y') ?? 'N/A' }}</p>
                <p><strong>Member since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
>>>>>>> bfd1d845bc44535ade2654b281679ae42f78690f
                
                <profile-info-item>
                    <profile-label>Email:</profile-label>
                    <profile-value>{{ $user->email }}</profile-value>
                </profile-info-item>
                
                <profile-info-item>
                    <profile-label>Member since:</profile-label>
                    <profile-value>{{ $user->created_at->format('M d, Y') }}</profile-value>
                </profile-info-item>
                
                <profile-actions>
                    <a href="{{ route('settings') }}" class="profile-button">Edit Profile</a>
                    <a href="{{ route('dashboard') }}" class="profile-button-secondary">Back to Dashboard</a>
                </profile-actions>
            </profile-card-body>
        </profile-card>
    </profile-wrapper>
</x-layout>