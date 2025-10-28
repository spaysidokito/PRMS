# User Management Guide

## Available User Accounts

### Administrator Accounts
| Name | Email | Password | Permissions |
|------|-------|----------|-------------|
| Jennifer Magbanlac | jennifermagbanlac@gmail.com | (your password) | Full system access |
| System Administrator | admin@primosa.edu | Admin@123 | Full system access |

### Faculty/Staff Accounts
| Name | Email | Password | Permissions |
|------|-------|----------|-------------|
| Dr. Maria Santos | faculty@primosa.edu | Faculty@123 | Student management, Analytics |
| John Dela Cruz | staff@primosa.edu | Staff@123 | Student management, Analytics |

### Student Account
| Name | Email | Password | Permissions |
|------|-------|----------|-------------|
| Juan Dela Cruz | student@primosa.edu | Student@123 | Limited access |

## User Roles & Permissions

### Administrator (admin)
**Can do everything:**
- ✅ Manage all users
- ✅ Manage student profiles
- ✅ Manage events
- ✅ Manage resources
- ✅ View analytics
- ✅ Delete records
- ✅ Full system access

**Methods:**
- `$user->isAdmin()` - Returns true
- `$user->canEdit()` - Returns true
- `$user->canDelete()` - Returns true
- `$user->canManageUsers()` - Returns true

### Faculty/Staff (faculty-staff)
**Can manage content:**
- ✅ Manage student profiles
- ✅ Manage events
- ✅ Manage resources
- ✅ View analytics
- ✅ Edit records
- ❌ Cannot delete users
- ❌ Cannot manage user accounts

**Methods:**
- `$user->isFacultyStaff()` - Returns true
- `$user->canEdit()` - Returns true
- `$user->canDelete()` - Returns false
- `$user->canManageUsers()` - Returns false

### Student (student)
**Limited access:**
- ✅ View events
- ✅ View resources
- ✅ View own profile
- ❌ Cannot manage anything
- ❌ Cannot view analytics
- ❌ Cannot edit records

**Methods:**
- `$user->isStudent()` - Returns true
- `$user->canEdit()` - Returns false
- `$user->canDelete()` - Returns false
- `$user->canManageUsers()` - Returns false

## How to Create New Users

### Method 1: Using the Script (Recommended)

Run the user creation script:
```bash
php create-admin-users.php
```

This will create all default users if they don't exist.

### Method 2: Manually via Tinker

```bash
php artisan tinker
```

Then:

```php
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

// Create user
$user = User::create([
    'name' => 'New User Name',
    'email' => 'user@example.com',
    'password' => Hash::make('Password@123'),
    'email_verified_at' => now(),
]);

// Assign role
$role = Role::where('slug', 'admin')->first(); // or 'faculty-staff' or 'student'
$user->roles()->attach($role);
```

### Method 3: Via Database Seeder

Create a seeder:
```bash
php artisan make:seeder UsersSeeder
```

Then run:
```bash
php artisan db:seed --class=UsersSeeder
```

## How to Assign Roles to Existing Users

### Using the Script

Edit `assign-user-role.php` and change the email address, then run:
```bash
php assign-user-role.php
```

### Using Tinker

```bash
php artisan tinker
```

```php
use App\Models\User;
use App\Models\Role;

// Get user
$user = User::where('email', 'user@example.com')->first();

// Get role
$adminRole = Role::where('slug', 'admin')->first();
$facultyRole = Role::where('slug', 'faculty-staff')->first();
$studentRole = Role::where('slug', 'student')->first();

// Assign role
$user->roles()->attach($adminRole);

// Remove role
$user->roles()->detach($adminRole);

// Sync roles (replace all roles)
$user->roles()->sync([$adminRole->id]);
```

## How to Check User Roles

### In Blade Templates

```blade
@if(auth()->user()->isAdmin())
    <!-- Admin only content -->
@endif

@if(auth()->user()->canEdit())
    <!-- Faculty/Staff and Admin content -->
@endif

@if(auth()->user()->isStudent())
    <!-- Student only content -->
@endif
```

### In Controllers

```php
if (auth()->user()->isAdmin()) {
    // Admin logic
}

if (auth()->user()->canEdit()) {
    // Faculty/Staff and Admin logic
}

if (!auth()->user()->canManageUsers()) {
    abort(403, 'Unauthorized');
}
```

### In Routes

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        // Admin only route
    });
});
```

## Password Requirements

All passwords must meet these requirements:
- Minimum 8 characters
- At least one uppercase letter (A-Z)
- At least one lowercase letter (a-z)
- At least one number (0-9)
- At least one symbol (!@#$%^&*)
- Not found in known data breaches

## Default Passwords

**⚠️ IMPORTANT: Change these passwords after first login!**

- Admin: `Admin@123`
- Faculty: `Faculty@123`
- Staff: `Staff@123`
- Student: `Student@123`

## Changing Passwords

Users can change their passwords by:
1. Login to the system
2. Go to Profile (top right menu)
3. Click "Update Password"
4. Enter current password and new password
5. Click "Save"

## Testing Different User Types

1. **Test as Admin:**
   - Login: admin@primosa.edu / Admin@123
   - Should see: All menus, Analytics, User Management

2. **Test as Faculty/Staff:**
   - Login: faculty@primosa.edu / Faculty@123
   - Should see: Student Management, Analytics
   - Should NOT see: User Management

3. **Test as Student:**
   - Login: student@primosa.edu / Student@123
   - Should see: Limited menus
   - Should NOT see: Student Management, Analytics, User Management

## Troubleshooting

### User has no roles
```bash
php assign-user-role.php
```

### User can't access certain features
Check their role:
```bash
php artisan tinker
```
```php
$user = User::where('email', 'user@example.com')->first();
$user->roles; // Should show their roles
```

### Need to remove a role
```bash
php artisan tinker
```
```php
$user = User::where('email', 'user@example.com')->first();
$role = Role::where('slug', 'admin')->first();
$user->roles()->detach($role);
```

## Security Best Practices

1. ✅ Change default passwords immediately
2. ✅ Use strong passwords (8+ chars, mixed case, numbers, symbols)
3. ✅ Enable two-factor authentication (available in Profile)
4. ✅ Regularly review user access
5. ✅ Remove inactive users
6. ✅ Don't share admin credentials
7. ✅ Use role-based access control
8. ✅ Monitor analytics for unusual activity

