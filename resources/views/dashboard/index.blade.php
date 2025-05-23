<x-layout>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome back, {{ $user->firstname }}!</h1>
                <p>This is your personal dashboard - only accessible when logged in.</p>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $userEvents->count() }}</h5>
                                <p class="card-text">Events Created</p>
                                <a href="{{ route('my-events') }}" class="btn btn-primary">View My Events</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $savedEventsCount ?? 0 }}</h5>
                                <p class="card-text">Saved Events</p>
                                <a href="{{ route('saved-events') }}" class="btn btn-primary">View Saved</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Profile</h5>
                                <p class="card-text">Manage Settings</p>
                                <a href="{{ route('profile') }}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>