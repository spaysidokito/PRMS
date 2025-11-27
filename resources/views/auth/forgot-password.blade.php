<x-guest-layout>
    <div class="auth-container">
        <div class="auth-sidebar">
            <img src="{{ asset('images/prms-logo.png') }}" alt="PRIMOSA Logo" class="auth-logo" />
            <h1>Reset Your Password</h1>
            <p>Progressive Resource and Information Management System for the Office of Student Affairs</p>
        </div>
        <div class="auth-main">
            <h2>Forgot Password</h2>

            <div class="mb-4 text-sm text-gray-600" style="text-align: center; margin-bottom: 30px;">
                Enter your email address and we'll send you a 6-digit verification code to reset your password.
            </div>

            <!-- Step 1: Enter Email -->
            <form id="email-form" style="display: block;">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('E-mail Address') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" required autofocus placeholder="Enter your email address">
                    </div>
                </div>

                <button type="submit" class="auth-submit-btn" id="send-code-btn">
                    <i class="fas fa-paper-plane"></i>
                    <span id="send-btn-text">Send Verification Code</span>
                </button>
            </form>

            <!-- Step 2: Enter Code and New Password -->
            <form id="reset-form" style="display: none;">
                @csrf
                <input type="hidden" id="reset-email">

                <div class="form-group">
                    <label for="code">{{ __('6-Digit Verification Code') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-key input-icon"></i>
                        <input id="code" type="text" name="code" maxlength="6" pattern="[0-9]{6}" required placeholder="Enter 6-digit code">
                    </div>
                    <p style="font-size: 12px; color: #666; margin-top: 5px;">Check your email for the verification code</p>
                </div>

                <div class="form-group">
                    <label for="new-password">{{ __('New Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="new-password" type="password" name="password" required placeholder="Enter new password">
                        <button type="button" class="password-toggle" onclick="togglePassword('new-password')">
                            <i class="fas fa-eye" id="new-password-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirmation">{{ __('Confirm Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password-confirmation" type="password" name="password_confirmation" required placeholder="Confirm new password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password-confirmation')">
                            <i class="fas fa-eye" id="password-confirmation-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-submit-btn" id="reset-btn">
                    <i class="fas fa-key"></i>
                    <span id="reset-btn-text">Reset Password</span>
                </button>

                <button type="button" class="auth-submit-btn" onclick="backToEmail()" style="background: #6c757d; margin-top: 10px;">
                    <i class="fas fa-arrow-left"></i>
                    Back to Email
                </button>
            </form>

            <div id="success-message" style="display: none; margin-top: 20px; padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; text-align: center;"></div>
            <div id="error-message" style="display: none; margin-top: 20px; padding: 15px; background: #f8d7da; color: #721c24; border-radius: 8px; text-align: center;"></div>

            <div class="auth-footer">
                <p>Remember your password? <a href="{{ route('login') }}" class="auth-links">Sign In</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script>
        emailjs.init('{{ env('EMAILJS_PUBLIC_KEY') }}');

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

        function backToEmail() {
            document.getElementById('email-form').style.display = 'block';
            document.getElementById('reset-form').style.display = 'none';
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('error-message').style.display = 'none';

            // Reset button states
            document.getElementById('send-code-btn').disabled = false;
            document.getElementById('send-btn-text').textContent = 'Send Verification Code';
            document.getElementById('reset-btn').disabled = false;
            document.getElementById('reset-btn-text').textContent = 'Reset Password';

            // Clear form fields
            document.getElementById('code').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('password-confirmation').value = '';
        }

        // Step 1: Send verification code
        document.getElementById('email-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('send-code-btn');
            const btnText = document.getElementById('send-btn-text');
            const email = document.getElementById('email').value;
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');

            btn.disabled = true;
            btnText.textContent = 'Sending...';
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';

            try {
                const response = await fetch('/api/password/send-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (data.success) {
                    // Send email via EmailJS
                    await emailjs.send(
                        '{{ env('EMAILJS_SERVICE_ID') }}',
                        '{{ env('EMAILJS_TEMPLATE_ID') }}',
                        {
                            to_email: data.to_email,
                            user_name: data.user_name,
                            reset_code: data.reset_code,
                            from_name: 'PRIMOSA'
                        }
                    );

                    // Show reset form
                    document.getElementById('reset-email').value = email;
                    document.getElementById('email-form').style.display = 'none';
                    document.getElementById('reset-form').style.display = 'block';
                    successMsg.textContent = 'Verification code sent! Check your email.';
                    successMsg.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMsg.textContent = 'Failed to send code. Please try again.';
                errorMsg.style.display = 'block';
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Send Verification Code';
            }
        });

        // Step 2: Verify code and reset password
        document.getElementById('reset-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('reset-btn');
            const btnText = document.getElementById('reset-btn-text');
            const email = document.getElementById('reset-email').value;
            const code = document.getElementById('code').value;
            const password = document.getElementById('new-password').value;
            const passwordConfirmation = document.getElementById('password-confirmation').value;
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');

            btn.disabled = true;
            btnText.textContent = 'Resetting...';
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';

            try {
                const response = await fetch('/api/password/verify-reset', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        email: email,
                        code: code,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                });

                const data = await response.json();

                if (data.success) {
                    successMsg.textContent = 'Password reset successfully! Redirecting to login...';
                    successMsg.style.display = 'block';
                    setTimeout(() => {
                        window.location.href = '{{ route('login') }}';
                    }, 2000);
                } else {
                    errorMsg.textContent = data.message || 'Invalid code or password.';
                    errorMsg.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMsg.textContent = 'Failed to reset password. Please try again.';
                errorMsg.style.display = 'block';
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Reset Password';
            }
        });
    </script>
</x-guest-layout>
