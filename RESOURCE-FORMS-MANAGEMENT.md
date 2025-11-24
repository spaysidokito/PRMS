# Resource Forms Management Feature

## Overview
Admins and staff can now manage forms within SOA, GTC, and POD sections. This includes adding, editing, and deleting forms, as well as changing form names and template filenames.

## Features Implemented

### 1. Database Structure
- **Table**: `resource_forms`
- **Columns**:
  - `id` - Primary key
  - `category` - Form category (soa, gtc, pod)
  - `subcategory` - Optional subcategory (e.g., "Organization Forms", "Activity Forms")
  - `name` - Display name of the form
  - `template_filename` - Filename of the template document
  - `display_order` - Order for displaying forms
  - `is_active` - Whether the form is active/visible
  - `created_at`, `updated_at` mps

### 2. Management Pages
Three dedicated management pages have been created:

#### SOA Management (`/resources/manage-soa`)
- Manage forms in three subcategories:
  - Organization Forms
  - Activity Forms
  - Documentation Forms

#### GTC Management (`/resources/manage-gtc`)
- Manage forms in three subcategories:
  - Testing & Application Forms
  - Counseling Forms
  - Evaluation & Assessment Forms

#### POD Management (`/resources/manage-pod`)
- Manage POD forms (no subcategories)

### 3. CRUD Operations
Each management page allows:
- **Create**: Add new forms with name, template filename, display order, and active status
- **Read**: View all forms organized by subcategory
- **Update**: Edit form details including name, template filename, order, and status
- **Delete**: Remove forms with confirmation

### 4. Access Control
- Management pages are accessible only to Admin and Faculty/Staff roles
- "Manage Forms" button appears in the header of SOA, GTC, and POD pages for authorized users

### 5. Pre-populated Data
The system comes with pre-seeded forms matching the existing templates:

**SOA Forms (9 forms)**:
- Organization Forms: 3 forms
- Activity Forms: 3 forms
- Documentation Forms: 3 forms

**GTC Forms (9 forms)**:
- Testing & Application Forms: 3 forms
- Counseling Forms: 3 forms
- Evaluation & Assessment Forms: 3 forms

## Routes Added

```php
// Management pages
GET  /resources/manage-soa
GET  /resources/manage-gtc
GET  /resources/manage-pod

// CRUD operations
POST   /resources/forms          (create)
PUT    /resources/forms/{id}     (update)
DELETE /resources/forms/{id}     (delete)
```

## Files Created/Modified

### New Files:
- `resources/views/resources/manage-soa.blade.php`
- `resources/views/resources/manage-gtc.blade.php`
- `resources/views/resources/manage-pod.blade.php`
- `database/migrations/2025_11_24_141244_add_columns_to_resource_forms_table.php`

### Modified Files:
- `app/Models/ResourceForm.php` - Added fillable fields and scopes
- `app/Http/Controllers/ResourceController.php` - Added management methods
- `routes/web.php` - Added management routes
- `database/seeders/ResourceFormsSeeder.php` - Added form data
- `resources/views/resources/soa.blade.php` - Added "Manage Forms" button
- `resources/views/resources/gtc.blade.php` - Added "Manage Forms" button
- `resources/views/resources/pod.blade.php` - Added "Manage Forms" button
- `database/migrations/2025_11_24_135349_create_resource_forms_table.php` - Updated schema

## Usage

### For Admins/Staff:
1. Navigate to SOA, GTC, or POD page
2. Click "Manage Forms" button in the header
3. Use the management interface to:
   - Add new forms by clicking "Add New Form"
   - Edit existing forms by clicking the "Edit" button
   - Delete forms by clicking the "Delete" button
   - Change display order, form names, template filenames, and active status

### Modal Interface:
- Clean modal popup for adding/editing forms
- Fields:
  - Subcategory (dropdown with predefined options)
  - Form Name (text input)
  - Template Filename (text input)
  - Display Order (number input)
  - Active Status (checkbox)

## Next Steps (Optional Enhancements)
- Add drag-and-drop reordering for forms
- Add bulk operations (activate/deactivate multiple forms)
- Add form usage analytics
- Add template file upload functionality
- Add form preview functionality

- Time
