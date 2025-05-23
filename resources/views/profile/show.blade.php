<x-layout>
    <div class="container mt-4">
        <h1>My Profile</h1>
        <p>This section is only accessible when logged in.</p>
        
        <div class="card">
            <div class="card-body">
                <h5>Profile Information</h5>
                <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                <p><strong>Date of Birth:</strong> {{ optional($user->date_of_birth)->format('M d, Y') ?? 'N/A' }}</p>
                <p><strong>Member since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</x-layout>