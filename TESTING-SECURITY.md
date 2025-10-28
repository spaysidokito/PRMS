# Testing Security Enhancements

## Quick Test Guide

### 1. Test Password Validation

Try registering a new user with different passwords to verify the validation rules:

**Should FAIL:**
- `password123` - Missing uppercase and symbols
- `PASSWORD123!` - Missing lowercase
- `Password123` - Missing symbols
- `Pass!@#` - Too short (less than 8 characters)
- `password` - Missing uppercase, numbers, and symbols

**Should PASS:**
- `StrongP@ss123`
- `MySecure#Pass1`
- `Test@1234Pass`

### 2. Test Rate Limiting

**Login Rate Limiting:**
1. Go to `/login`
2. Try to login with wrong credentials 6 times quickly
3. On the 6th attempt, you should see a "Too Many Attempts" error
4. Wait 1 minute and try again

**Test via Browser Console:**
```javascript
// Open browser console on login page
for(let i = 0; i < 6; i++) {
    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            email: 'test@example.com',
            password: 'wrongpassword'
        })
    }).then(r => console.log(`Attempt ${i+1}:`, r.status));
}
```

### 3. Test Password Requirements Display

1. Go to `/register`
2. Start typing in the password field
3. You should see:
   - Real-time requirement checklist (✗ changes to ✓ when met)
   - Password strength indicator (Very Weak → Strong)
   - Color changes based on strength

### 4. Test Session Security

**Check Security Headers:**
Open browser DevTools → Network tab → Reload page → Click any request → Check Response Headers:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`

**Check Cookie Settings:**
DevTools → Application tab → Cookies → Check your session cookie:
- `HttpOnly` should be checked ✓
- `Secure` should be checked in production ✓
- `SameSite` should be "Lax" ✓

### 5. Test Two-Factor Authentication (Optional)

1. Login to your account
2. Go to Profile → Two Factor Authentication
3. Enable 2FA
4. Logout and login again
5. You should be prompted for 2FA code

## Manual Testing Checklist

- [ ] Weak passwords are rejected during registration
- [ ] Strong passwords are accepted
- [ ] Password confirmation must match
- [ ] Rate limiting blocks after 5 failed login attempts
- [ ] Password requirements are displayed in real-time
- [ ] Password strength indicator works correctly
- [ ] Security headers are present in responses
- [ ] Session cookies have proper security flags
- [ ] Two-factor authentication works (if enabled)

## Automated Testing

Run the password validation test:
```bash
php artisan tinker
```

Then paste:
```php
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

$rules = ['password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed']];

// Test weak password
$validator = Validator::make(['password' => 'weak', 'password_confirmation' => 'weak'], $rules);
echo $validator->fails() ? "✓ Weak password rejected\n" : "✗ Weak password accepted\n";

// Test strong password
$validator = Validator::make(['password' => 'StrongP@ss123', 'password_confirmation' => 'StrongP@ss123'], $rules);
echo $validator->passes() ? "✓ Strong password accepted\n" : "✗ Strong password rejected\n";
```

## Production Checklist

Before deploying to production:

- [ ] Set `SESSION_SECURE_COOKIE=true` in `.env` (requires HTTPS)
- [ ] Set `APP_DEBUG=false`
- [ ] Verify HTTPS is enabled
- [ ] Test all security features in production environment
- [ ] Configure proper email settings for password resets
- [ ] Review and adjust rate limiting if needed
- [ ] Enable application logging for security events

## Troubleshooting

**Issue: Password validation not working**
```bash
php artisan config:clear
php artisan cache:clear
```

**Issue: Rate limiting not working**
```bash
php artisan cache:clear
# Check that cache driver is configured (not 'array')
```

**Issue: Security headers not appearing**
```bash
# Verify middleware is registered in bootstrap/app.php
php artisan route:list
```

**Issue: Session security not working**
```bash
# Clear sessions
php artisan session:table  # if using database sessions
php artisan migrate
```

