<x-layout>
<div class="login-container">
    <div class="login-panel">
        <div class="login-logo">
            <a href="/" class="text-decoration-none">
                <span class="wtg-logo">WTG?</span>
            </a>
        </div>
        <div class="login-welcome">
            <h1>Welcome!</h1>
            <h2>Sign in to your account</h2>
        </div>
        <form action="/account/login" method="POST" class="login-form">
            @csrf
            <div class="form-group mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group mb-3 forgot-password">
                <a href="/forgot-password">Forgot password?</a>
            </div>
            <button type="submit" class="btn login-btn">
                Sign In
            </button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="/account/create">Sign up</a></p>
        </div>
        <div class="terms-notice">
            <p>By signing in, you agree to WTG?'s
                <a href="/terms-of-service">Terms of Service</a> and
                <a href="/privacy-policy">Privacy Policy</a>.
            </p>
        </div>
        <div class="help-link">
            <a href="/help-center">Need help finding your tickets?</a>
        </div>
    </div>
</div>
</x-layout>