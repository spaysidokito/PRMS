# Security Enhancements

This document outlines the password and authentication security measures implemented in this application.

## Password Security

### Password Requirements
All passwords must meet the following criteria:
- Minimum 8 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special symbol
- Not found in data breaches (checked against haveibeenpwned.com)

### Implementation
Password rules are defined in `app/Actions/Fortify/PasswordValidationRules.php` and applied to:
- User registration
- Password updates
- Password resets

## Authentication Security

### Rate Limiting
- **Login attempts**: Limited to 5 attempts per minute per email/IP combination
- **Two-factor authentication**: Limited to 5 attempts per minute per session

### Two-Factor Authentication
- Available for all users (optional but recommended)
- Provides an additional layer of security beyond passwords

### Session Security
- Sessions stored in database for better tracking
- Session lifetime: 120 minutes (configurable)
- HTTP-only cookies prevent JavaScript access
- Secure cookies (HTTPS only in production)
- SameSite cookie attribute set to 'lax' for CSRF protection
- Session regeneration on login to prevent session fixation

### Security Headers
The following security headers are automatically added to responses:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`

## Environment Configuration

### Required Environment Variables
Add these to your `.env` file:

```env
# Session Security
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Password Timeout (in seconds)
AUTH_PASSWORD_TIMEOUT=10800
```

### Production Recommendations
1. Set `SESSION_SECURE_COOKIE=true` (requires HTTPS)
2. Use `SESSION_DRIVER=redis` or `database` instead of `file`
3. Enable `SESSION_ENCRYPT=true` for sensitive applications
4. Set `APP_DEBUG=false`
5. Use strong `APP_KEY` (generated via `php artisan key:generate`)

## Best Practices

### For Users
- Enable two-factor authentication
- Use unique passwords not used on other sites
- Change passwords regularly
- Never share passwords

### For Administrators
- Monitor failed login attempts
- Review session logs regularly
- Keep Laravel and dependencies updated
- Use HTTPS in production
- Configure proper mail settings for password resets

## Testing

To test password validation:
```bash
php artisan tinker
>>> use Illuminate\Validation\Rules\Password;
>>> Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()->validate('password', 'TestPass123!');
```

## Additional Security Measures

Consider implementing:
- Account lockout after multiple failed attempts
- Password expiration policies
- Security audit logging
- IP whitelisting for admin accounts
- Regular security audits
