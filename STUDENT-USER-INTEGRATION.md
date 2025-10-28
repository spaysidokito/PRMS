# Student Profile & User Account Integration

## Overview

When you create a student profile in the Student Management tab, the system now automatically:
1. ✅ Creates a user account for the student
2. ✅ Assigns the "Student" role
3. ✅ Links the profile to the user account
4. ✅ Generates a default password

## How It Works

### Creating a New Student

When you add a new student through **Student Management → Create**:

1. **Student Profile Created** with all their information
2. **User Account Created** automatically with:
   - Name: Full name from profile
   - Email: Same as student profile email
   - Password: `Student@[StudentID]`
   - Role: Student
   - Email verified: Yes

3. **Both are linked** so they appear in:
   - Student Management (profile data)
   - User Management (login account)

### Default Password Format

**Pattern:** `Student@[StudentID]`

**Examples:**
- Student ID: `2024001` → Password: `Student@2024001`
- Student ID: `S12345` → Password: `Student@S12345`

### Updating a Student

When you update a student profile:
- ✅ Profile information is updated
- ✅ User account name and email are synced automatically
- ✅ Password remains unchanged (student must change it themselves)

### Deleting a Student

When you delete a student profile:
- ✅ User account is also deleted
- ✅ All related data is cleaned up
- ⚠️ This action cannot be undone

## Student Login Process

1. Student goes to login page
2. Enters their email and default password
3. System logs them in
4. **Recommended:** Student should change password immediately

## Checking Student Accounts

### Via Student Management
- Go to **Student Management**
- All students listed here have user accounts
- Click "View" to see profile details

### Via User Management (Admin Only)
- Go to **User Management**
- Filter by role: "Student"
- See all student user accounts

## Password Management

### Students Can Change Their Password

1. Login with default password
2. Go to **Profile** (top right menu)
3. Click **Update Password**
4. Enter current password and new password
5. New password must meet requirements:
   - 8+ characters
   - Uppercase and lowercase letters
   - Numbers
   - Symbols

### Admin Can Reset Student Password

If a student forgets their password:

1. **Option 1: Via Database**
```bash
php artisan tinker
```
```php
$user = User::where('email', 'student@example.com')->first();
$user->password = Hash::make('NewPassword@123');
$user->save();
```

2. **Option 2: Delete and Recreate**
- Delete the student profile (deletes user too)
- Create new profile (creates new user with default password)

## Existing Students

If you had students created before this update:

Run this command to link them:
```bash
php link-existing-students.php
```

This will:
- Find all student profiles without user accounts
- Create user accounts for them
- Link them together
- Assign student role

## Validation Rules

### Email Must Be Unique
- Cannot create two students with same email
- Cannot create student with email that exists in users table

### Student ID Must Be Unique
- Each student must have unique student ID
- Used to generate default password

## Troubleshooting

### Student Can't Login

**Check:**
1. Is the email correct?
2. Is the password correct? (Student@[StudentID])
3. Does the user account exist in User Management?

**Fix:**
```bash
php link-existing-students.php
```

### Student Profile Exists But No User Account

**Fix:**
```bash
php link-existing-students.php
```

### Duplicate Email Error

**Cause:** Email already exists in users table

**Fix:**
1. Check User Management for existing user
2. Either delete the existing user or use different email

### Student Has No Role

**Fix:**
```bash
php artisan tinker
```
```php
$user = User::where('email', 'student@example.com')->first();
$role = Role::where('slug', 'student')->first();
$user->roles()->attach($role);
```

## Best Practices

### For Administrators

1. ✅ Always use Student Management to create students
2. ✅ Inform students of their default password
3. ✅ Encourage students to change password on first login
4. ✅ Keep student emails unique and valid
5. ✅ Use proper student ID format

### For Students

1. ✅ Change default password immediately
2. ✅ Use strong password (8+ chars, mixed case, numbers, symbols)
3. ✅ Don't share your password
4. ✅ Enable two-factor authentication (optional)

## Security Features

### Automatic Account Creation
- ✅ Secure default passwords
- ✅ Email verification enabled
- ✅ Student role assigned automatically

### Data Integrity
- ✅ Profile and user are linked
- ✅ Cascade delete (delete profile = delete user)
- ✅ Email uniqueness enforced

### Access Control
- ✅ Students can only access student features
- ✅ Cannot access admin or faculty features
- ✅ Cannot view analytics

## Summary

**Before:** Creating a student profile did NOT create a user account

**Now:** Creating a student profile AUTOMATICALLY creates a user account

**Benefits:**
- ✅ Students can login immediately
- ✅ No manual user creation needed
- ✅ Consistent data between profile and user
- ✅ Easier management
- ✅ Better security

**Default Password:** `Student@[StudentID]`

**Students appear in:**
- Student Management (profile)
- User Management (account)
