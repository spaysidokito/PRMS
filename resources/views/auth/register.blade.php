<x-guest-layout>
    <div class="auth-container">
        <div class="auth-sidebar">
            <img src="{{ asset('images/logo.png') }}" alt="PRIMOSA Logo" class="auth-logo" />
            <h1>Join PRIMOSA</h1>
            <p>Progressive Resource and Information Management System for the Office of Student Affairs</p>
        </div>
        <div class="auth-main">
            <h2>Create Account</h2>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Full Name') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">{{ __('E-mail Address') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                        <span class="strength-text" id="strength-text">Password strength</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-submit-btn">
                    <i class="fas fa-user-plus"></i>
                    {{ __('Create Account') }}
                </button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="{{ route('login') }}" class="auth-links">Sign In</a></p>
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

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');

            let strength = 0;
            let text = 'Very Weak';
            let color = '#ff4444';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch(strength) {
                case 0:
                case 1:
                    text = 'Very Weak';
                    color = '#ff4444';
                    break;
                case 2:
                    text = 'Weak';
                    color = '#ff8800';
                    break;
                case 3:
                    text = 'Fair';
                    color = '#ffaa00';
                    break;
                case 4:
                    text = 'Good';
                    color = '#00aa00';
                    break;
                case 5:
                    text = 'Strong';
                    color = '#008800';
                    break;
            }

            strengthFill.style.width = (strength * 20) + '%';
            strengthFill.style.backgroundColor = color;
            strengthText.textContent = text;
            strengthText.style.color = color;
        });
    </script>
</x-guest-layout>
