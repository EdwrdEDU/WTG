<x-layout>
    <div class="container mt-4">
        <h1>Saved Events</h1>
        <p>Events you've bookmarked - only accessible when logged in.</p>
        
        <div class="text-center py-5">
            <i class="bi bi-bookmark" style="font-size: 3rem; color: #ccc;"></i>
            <h3>No saved events yet</h3>
            <p>Start exploring events and save the ones you're interested in!</p>
            <a href="{{ route('homepage') }}" class="btn btn-primary">Explore Events</a>
        </div>
    </div>
</x-layout>