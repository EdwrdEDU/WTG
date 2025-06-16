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
            <h1>Forgot Password</h1>
        </div>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('forgot.password.send') }}" class="login-form">
            @csrf
            <div class="form-group mb-4">
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    class="form-control @error('email') is-invalid @enderror" 
                    placeholder="Email"
                    required
                    autofocus
                >
                @error('email') 
                <div class="invalid-feedback d-block">{{ $message }}</div> 
                @enderror
            </div>
            <button type="submit" class="btn login-btn">
                Send Reset Link
            </button>
        </form>
    </div>
</div>
</x-layout>
