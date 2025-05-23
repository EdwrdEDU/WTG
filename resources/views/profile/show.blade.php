<x-layout>
 <profile-wrapper>
<profile-header>
<profile-title>My Profile</profile-title>
<!-- <profile-subtitle>Your Personal Information</profile-subtitle> -->
</profile-header>
<profile-card>
<profile-card-header>
<profile-section-title>Profile Information</profile-section-title>
</profile-card-header>
<profile-card-body>
<profile-info-item>
<profile-label>Name:</profile-label>
<profile-value>{{ $user->firstname }} {{ $user->lastname }}</profile-value>
</profile-info-item>
<profile-info-item>
<profile-label>Email:</profile-label>
<profile-value>{{ $user->email }}</profile-value>
</profile-info-item>
<profile-info-item>
<profile-label>Phone:</profile-label>
<profile-value>{{ $user->phone ?? 'N/A' }}</profile-value>
</profile-info-item>
<profile-info-item>
<profile-label>Date of Birth:</profile-label>
<profile-value>{{ optional($user->date_of_birth)->format('M d, Y') ?? 'N/A' }}</profile-value>
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