<x-guest-layout>
    <div class="auth-container">
        <div class="auth-sidebar">
            <img src="{{ asset('images/prms-logo.png') }}" alt="PRIMOSA Logo" class="auth-logo" />
            <h1>Create New Password</h1>
            <p>Progressive Resource and Information Management System for the Office of Student Affairs</p>
        </div>
        <div class="auth-main">
            <h2>Reset Password</h2>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label for="email">{{ __('E-mail Address') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="Enter your email address">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('New Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Enter your new password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    <div class="password-requirements" style="margin-top: 8px; font-size: 12px; color: #666;">
                        <div style="margin-bottom: 4px; font-weight: 500;">Password must contain:</div>
                        <div id="req-length" style="margin-left: 8px;">✗ At least 8 characters</div>
                        <div id="req-lowercase" style="margin-left: 8px;">✗ Lowercase letter (a-z)</div>
                        <div id="req-uppercase" style="margin-left: 8px;">✗ Uppercase letter (A-Z)</div>
                        <div id="req-number" style="margin-left: 8px;">✗ Number (0-9)</div>
                        <div id="req-symbol" style="margin-left: 8px;">✗ Symbol (!@#$%^&*)</div>
                    </div>
                    <div class="password-strength" style="margin-top: 8px;">
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
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your new password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-submit-btn">
                    <i class="fas fa-key"></i>
                    {{ __('Reset Password') }}
                </button>
            </form>

            <div class="auth-footer">
                <p>Remember your password? <a href="{{ route('login') }}" class="auth-links">Sign In</a></p>
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

        // Password strength checker with requirements
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');

            let strength = 0;
            let text = 'Very Weak';
            let color = '#ff4444';

            // Check requirements
            const hasLength = password.length >= 8;
            const hasLowercase = /[a-z]/.test(password);
            const hasUppercase = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[^a-zA-Z0-9]/.test(password);

            // Update requirement indicators
            updateRequirement('req-length', hasLength);
            updateRequirement('req-lowercase', hasLowercase);
            updateRequirement('req-uppercase', hasUppercase);
            updateRequirement('req-number', hasNumber);
            updateRequirement('req-symbol', hasSymbol);

            // Calculate strength
            if (hasLength) strength++;
            if (hasLowercase) strength++;
            if (hasUppercase) strength++;
            if (hasNumber) strength++;
            if (hasSymbol) strength++;

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

        function updateRequirement(elementId, isMet) {
            const element = document.getElementById(elementId);
            if (isMet) {
                element.style.color = '#00aa00';
                element.innerHTML = element.innerHTML.replace('✗', '✓');
            } else {
                element.style.color = '#666';
                element.innerHTML = element.innerHTML.replace('✓', '✗');
            }
        }
    </script>
</x-guest-layout>
