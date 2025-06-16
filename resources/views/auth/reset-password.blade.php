<x-layout>

@section('content')
<div class="login-container">
    <div class="login-panel">
        <div class="login-logo" style="margin-bottom: 5px;">
            <a href="/" class="text-decoration-none">
                <span class="wtg-logo">WTG?</span>
            </a>
        </div>
        <div class="login-welcome" style="margin-bottom: 10px;">
            <h1>Reset Password</h1>
        </div>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.update') }}" class="login-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group mb-4">
                <input 
                    type="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="New Password"
                    required
                >
                @error('password') 
                <div class="invalid-feedback d-block">{{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group mb-4">
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Confirm Password"
                    required
                >
            </div>

            <button type="submit" class="btn login-btn">
                Reset Password
            </button>
        </form>
    </div>
</div>
</x-layout>