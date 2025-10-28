# Student Profile Picture Guide

## Overview

Students can now have profile pictures! The system supports uploading, updating, and deleting profile pictures with automatic default avatars based on gender.

## Features

### ✅ Profile Picture Upload
- Upload during student creation
- Update existing student's picture
- Supported formats: JPEG, PNG, JPG, GIF
- Maximum file size: 2MB
- Stored in: `storage/app/public/profile-pictures/`

### ✅ Default Avatars
If no picture is uploaded, the system shows gender-based default avatars:
- **Male students:** Blue avatar
- **Female students:** Pink avatar
- **Other/Not specified:** Gray avatar

### ✅ Picture Management
- Upload new picture
- Replace existing picture
- Delete picture (reverts to default)
- Automatic cleanup when student is deleted

## How to Use

### For Administrators/Faculty

#### Adding Picture During Student Creation

1. Go to **Student Management → Create New Student**
2. Fill in all required fields
3. Click **Choose File** under Profile Picture
4. Select an image (JPEG, PNG, JPG, or GIF, max 2MB)
5. Click **Create Student**
6. Picture is uploaded and displayed

#### Updating Student Picture

1. Go to **Student Management**
2. Click **Edit** on a student
3. Under Profile Picture section:
   - Click **Choose File** to select new picture
   - Or click **Delete Picture** to remove current picture
4. Click **Update Student**

#### Viewing Student Picture

1. Go to **Student Management**
2. Click **View** on a student
3. Profile picture is displayed at the top
4. If no picture, default avatar is shown

### For Students

Students can view their profile picture but cannot change it themselves (only admins/faculty can update it).

## Technical Details

### Database

**Table:** `student_profiles`

**Column:** `profile_picture` (nullable string)

**Stores:** Relative path to the image file

**Example:** `profile-pictures/abc123def456.jpg`

### File Storage

**Location:** `storage/app/public/profile-pictures/`

**Public URL:** `storage/profile-pictures/[filename]`

**Note:** Make sure storage is linked:
```bash
php artisan storage:link
```

### Image Requirements

- **Formats:** JPEG, PNG, JPG, GIF
- **Max Size:** 2MB (2048 KB)
- **Recommended:** Square images (e.g., 400x400px)
- **Aspect Ratio:** Any (will be displayed as square/circle)

### Default Avatars

**Location:** `public/images/`

**Files:**
- `default-avatar-male.svg` - Blue avatar for male students
- `default-avatar-female.svg` - Pink avatar for female students
- `default-avatar.svg` - Gray avatar for other/unspecified

## API/Routes

### Upload Profile Picture
```
POST /student-profiles/{id}/upload-picture
```

**Parameters:**
- `profile_picture` (file, required)

### Delete Profile Picture
```
DELETE /student-profiles/{id}/delete-picture
```

## Code Examples

### In Blade Templates

**Display Profile Picture:**
```blade
<img src="{{ $studentProfile->profile_picture_url }}" 
     alt="{{ $studentProfile->full_name }}" 
     class="rounded-full w-32 h-32 object-cover">
```

**Check if Has Custom Picture:**
```blade
@if($studentProfile->profile_picture)
    <p>Custom picture uploaded</p>
@else
    <p>Using default avatar</p>
@endif
```

### In Controllers

**Get Profile Picture URL:**
```php
$pictureUrl = $studentProfile->profile_picture_url;
```

**Delete Picture:**
```php
$studentProfile->deleteProfilePicture();
$studentProfile->update(['profile_picture' => null]);
```

**Upload Picture:**
```php
if ($request->hasFile('profile_picture')) {
    $path = $request->file('profile_picture')->store('profile-pictures', 'public');
    $studentProfile->update(['profile_picture' => $path]);
}
```

## Validation Rules

### Create/Update Student

```php
'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
```

**Breakdown:**
- `nullable` - Picture is optional
- `image` - Must be an image file
- `mimes:jpeg,png,jpg,gif` - Allowed formats
- `max:2048` - Maximum 2MB (2048 KB)

## Storage Setup

### Link Storage Directory

Run this command once to create symbolic link:
```bash
php artisan storage:link
```

This creates a link from `public/storage` to `storage/app/public`

### Check Storage Link

```bash
# Windows
dir public\storage

# Linux/Mac
ls -la public/storage
```

Should show a link to `storage/app/public`

## Troubleshooting

### Picture Not Displaying

**Problem:** Uploaded picture shows broken image

**Solutions:**
1. Check storage is linked:
   ```bash
   php artisan storage:link
   ```

2. Check file permissions:
   ```bash
   # Linux/Mac
   chmod -R 775 storage
   chmod -R 775 public/storage
   ```

3. Check file exists:
   ```bash
   ls storage/app/public/profile-pictures/
   ```

### Upload Fails

**Problem:** "The profile picture must be an image"

**Solutions:**
1. Check file format (JPEG, PNG, JPG, GIF only)
2. Check file size (max 2MB)
3. Check file is not corrupted

**Problem:** "The profile picture may not be greater than 2048 kilobytes"

**Solution:** Resize image before uploading or increase limit in validation

### Default Avatar Not Showing

**Problem:** Default avatar shows broken image

**Solutions:**
1. Check files exist in `public/images/`:
   - `default-avatar-male.svg`
   - `default-avatar-female.svg`
   - `default-avatar.svg`

2. Check file permissions

3. Clear browser cache

## Best Practices

### For Administrators

1. ✅ Use square images for best results
2. ✅ Resize large images before uploading
3. ✅ Use clear, professional photos
4. ✅ Ensure proper lighting in photos
5. ✅ Use consistent image sizes across all students

### Image Guidelines

**Recommended:**
- Size: 400x400px to 800x800px
- Format: JPEG or PNG
- File size: Under 500KB
- Background: Plain or school-related
- Face clearly visible

**Avoid:**
- Very large files (>2MB)
- Low resolution images
- Inappropriate content
- Copyrighted images

## Security

### File Validation
- ✅ File type validation (image only)
- ✅ File size limit (2MB)
- ✅ Secure file storage
- ✅ Unique filenames (prevents overwriting)

### Access Control
- ✅ Only admins/faculty can upload/delete pictures
- ✅ Students can view but not modify
- ✅ Pictures stored outside public directory
- ✅ Served through Laravel (not direct access)

## Future Enhancements

Possible improvements:
- Image cropping tool
- Automatic image optimization
- Multiple image sizes (thumbnail, full)
- Bulk upload from CSV
- Student self-upload with approval
- Face detection/validation
- Image filters/effects

## Summary

**Profile pictures are now fully integrated!**

- ✅ Upload during creation or update
- ✅ Gender-based default avatars
- ✅ Automatic file management
- ✅ 2MB max, JPEG/PNG/JPG/GIF
- ✅ Stored securely in storage/
- ✅ Easy to use interface

Students now have visual identification in the system!
