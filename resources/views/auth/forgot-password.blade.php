<x-layout>

@section('content')
<div class="container">
    <h2>Forgot Password</h2>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('forgot.password.send') }}">
        @csrf
        <div class="mb-3">
            <label for="email">Email address:</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
</div>
</x-layout>
