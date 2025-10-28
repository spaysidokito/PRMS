# Student Access Restrictions

## Overview

Students now have restricted access to the system. They can only view events and resources, but cannot access student management or analytics.

## Access Control Summary

### ✅ Students CAN Access:
- **Dashboard** - Customized view with events and quick links
- **Event Management** - View events only (cannot create/edit/delete)
- **Resource Management** - View and download forms
- **Profile/Settings** - Manage their own profile

### ❌ Students CANNOT Access:
- **Student Management** - Hidden from sidebar and blocked by controller
- **Analytics** - Hidden from sidebar and blocked by controller
- **User Management** - Hidden from sidebar (Admin only)
- **Create/Edit/Delete Events** - View only access
- **Upload Forms** - View and download only

## What Changed

### 1. StudentProfileController Authorization

**Added middleware** to block students from accessing any student management pages:

```php
public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }
        return $next($request);
    });
}
```

**Result:**
- Students get 403 error if they try to access student management
- Only Faculty/Staff and Administrators can access

### 2. Dashboard Customization

**For Faculty/Staff and Administrators:**
- Student statistics (Total, Active, Dropped, Graduated)
- Inactive Students list with "View All" link
- Full event calendar
- Upcoming events

**For Students:**
- Event statistics only (Total Events, Upcoming Events)
- Quick Links section (View All Events, Resources)
- Full event calendar
- Upcoming events

### 3. Sidebar Navigation

**Already protected** with authorization checks:
- Student Management - Only visible to Faculty/Staff and Admins
- Analytics - Only visible to Faculty/Staff and Admins
- User Management - Only visible to Admins

## Testing

### Test as Student

1. **Login as student:**
   - Email: `student@primosa.edu`
   - Password: `Student@123`

2. **Check Dashboard:**
   - ✅ Should see event statistics
   - ✅ Should see quick links
   - ❌ Should NOT see student statistics
   - ❌ Should NOT see inactive students list

3. **Check Sidebar:**
   - ✅ Dashboard
   - ❌ Student Management (hidden)
   - ✅ Event Management
   - ✅ Resource Management
   - ❌ Analytics (hidden)
   - ❌ User Management (hidden)
   - ✅ Settings

4. **Try Direct URL Access:**
   - `/student-profiles` → 403 Forbidden
   - `/student-profiles/create` → 403 Forbidden
   - `/analytics` → 403 Forbidden

### Test as Faculty/Staff

1. **Login as faculty:**
   - Email: `faculty@primosa.edu`
   - Password: `Faculty@123`

2. **Check Dashboard:**
   - ✅ Should see all student statistics
   - ✅ Should see inactive students list
   - ✅ Should see "View All" link

3. **Check Sidebar:**
   - ✅ Dashboard
   - ✅ Student Management
   - ✅ Event Management
   - ✅ Resource Management
   - ✅ Analytics
   - ❌ User Management (Admin only)
   - ✅ Settings

4. **Try Direct URL Access:**
   - `/student-profiles` → ✅ Works
   - `/analytics` → ✅ Works

### Test as Administrator

1. **Login as admin:**
   - Email: `admin@primosa.edu`
   - Password: `Admin@123`

2. **Full access to everything:**
   - ✅ All dashboard features
   - ✅ All sidebar links visible
   - ✅ All URLs accessible

## Authorization Methods

### In Controllers

```php
// Check if user can edit (Faculty/Staff or Admin)
if (!Auth::user()->canEdit()) {
    abort(403);
}

// Check if user can delete (Admin only)
if (!Auth::user()->canDelete()) {
    abort(403);
}

// Check if user can manage users (Admin only)
if (!Auth::user()->canManageUsers()) {
    abort(403);
}
```

### In Blade Templates

```blade
{{-- Show only to Faculty/Staff and Admins --}}
@if(auth()->user()->canEdit())
    <!-- Content here -->
@endif

{{-- Show only to Admins --}}
@if(auth()->user()->canManageUsers())
    <!-- Content here -->
@endif

{{-- Show only to Students --}}
@if(auth()->user()->isStudent())
    <!-- Content here -->
@endif
```

### In Routes

Routes are protected by the `auth` middleware, and controllers have additional authorization checks.

## Error Messages

### 403 Forbidden

When students try to access restricted pages:

**Message:** "Unauthorized. Only Faculty/Staff and Administrators can access Student Management."

**What to do:**
- This is expected behavior
- Students should not access these pages
- Contact administrator if you believe you should have access

## User Roles

### Student
- **Can:** View events, view resources, manage own profile
- **Cannot:** Manage students, view analytics, manage users

### Faculty/Staff
- **Can:** Everything students can + manage students, view analytics
- **Cannot:** Manage users (Admin only)

### Administrator
- **Can:** Everything (full system access)
- **Cannot:** Nothing (no restrictions)

## Security Benefits

1. **Data Privacy** - Students cannot see other students' information
2. **System Integrity** - Students cannot modify system data
3. **Clear Separation** - Each role has appropriate access level
4. **Audit Trail** - Only authorized users can access sensitive data

## Troubleshooting

### Student sees "403 Forbidden"

**This is normal** if they try to access:
- Student Management
- Analytics
- User Management

**Solution:** Students should use the sidebar navigation only.

### Faculty/Staff cannot access Student Management

**Check their role:**
```bash
php artisan tinker
```
```php
$user = User::where('email', 'faculty@example.com')->first();
$user->roles; // Should show 'faculty-staff' role
```

**Fix if needed:**
```php
$role = Role::where('slug', 'faculty-staff')->first();
$user->roles()->attach($role);
```

### Admin cannot access something

**Check their role:**
```php
$user = User::where('email', 'admin@example.com')->first();
$user->roles; // Should show 'admin' role
```

## Summary

**Students now have appropriate restricted access:**
- ✅ Can view events and resources
- ✅ Can manage their own profile
- ❌ Cannot access student management
- ❌ Cannot access analytics
- ❌ Cannot access user management

**Dashboard is customized based on role:**
- Faculty/Staff and Admins see student statistics
- Students see event statistics and quick links

**All access is properly controlled:**
- Sidebar navigation hides restricted links
- Controllers block unauthorized access
- Clear error messages for unauthorized attempts
