<x-layout>
    <div class="page-background"></div>
    <div class="account-container">
        <div class="container-inner">
            <div class="header-section">
                <div class="header-left">
                    <div class="wtg-branding">WTG?</div>
                    <h2 class="text-banner">Sign-Up</h2>
                    <p class="subtitle">Create your account</p>
                </div>
            </div>
            <form action="{{ route('account.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="account-item">
                        <label for="firstname">First Name</label>
                        <input class="input-field" type="text" id="first_name" name="firstname" required>
                    </div>
                    <div class="account-item">
                        <label for="lastname">Last Name</label>
                        <input class="input-field" type="text" id="last_name" name="lastname" required>
                    </div>
                </div>
                <div class="account-item">
                    <label for="email">Email</label>
                    <input class="input-field" type="email" id="email" name="email" required>
                </div>
                <div class="form-row">
                    <div class="account-item">
                        <label for="password">Password</label>
                        <input class="input-field" type="password" id="password" name="password" required>
                    </div>
                    <div class="account-item">
                        <label for="password_confirmation">Confirm Password</label>
                        <input class="input-field" type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="create-button">
                    <button type="submit">Create Account</button>
                </div>
            </form>
            <div class="form-footer">
                <div class="footer-section">
                    <p class="already">Already have an account? <a href="/login" class="text-blue-600">Login here</a>.</p>
                </div>
            </div>
            <div class="terms-note">
                By signing up, you agree to WTG?'s <a href="/terms">Terms of Service</a> and
                <a href="/privacy">Privacy Policy</a>.
            </div>
            <div class="help-link">
                <a href="/help">Need help finding your tickets?</a>
            </div>
        </div>
    </div>
</x-layout>