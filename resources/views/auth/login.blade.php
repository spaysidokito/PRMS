<x-guest-layout>
    <div class="auth-container">
        <div class="auth-sidebar">
            <img src="{{ asset('images/logo.png') }}" alt="PRIMOSA Logo" class="auth-logo" />
            <h1>Welcome Back to PRIMOSA</h1>
            <p>Progressive Resource and Information Management System for the Office of Student Affairs</p>
        </div>
        <div class="auth-main">
            <h2>Sign In</h2>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('E-mail Address') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email address">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="login-actions">
                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">{{ __('Remember me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-links">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="auth-submit-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    {{ __('Log in') }}
                </button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="{{ route('register') }}" class="auth-links">Register</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(inputId + '-eye');

            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
