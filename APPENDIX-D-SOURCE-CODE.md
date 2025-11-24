# APPENDIX D

# SOURCE CODE DOCUMENTATION

This appendix contains the key source code files that comprise the PRIMOSA system. The code is organized by component type: Controllers, Models, Migrations, Routes, and Views.

---

## Table of Contents

1. [Controllers](#controllers)
   - ResourceController
   - AnalyticsController
   - EventController
   - FormSubmissionController
   - StudentProfileController
2. [Models](#models)
   - User Model
   - FormAccessLog Model
   - Event Model
   - Role Model
3. [Database Migrations](#database-migrations)
4. [Routes](#routes)
5. [Key Views](#key-views)
6. [Configuration Files](#configuration-files)

---

## 1. CONTROLLERS

Controllers handle HTTP requests and coordinate between models and views following the MVC pattern.

### 1.1 ResourceController.php

**Location:** `app/Http/Controllers/ResourceController.php`

**Purpose:** Manages resource access, document uploads, downloads, and previews for SOA, GTC, and POD forms.

**Key Methods:**
- `soa()`, `gtc()`, `pod()` - Display form pages and log views
- `soaUpload()`, `gtcUpload()` - Handle document uploads with validation
- `soaDownloadFile()`, `gtcDownloadFile()` - Process file downloads
- `soaTemplateDownload()`, `gtcTemplateDownload()` - Download form templates
- `soaTemplatePreview()`, `gtcTemplatePreview()` - Preview templates

**Code:** See full source code in project repository at `app/Http/Controllers/ResourceController.php`


**Key Features:**
- File validation (MIME type: doc/docx, max size: 10MB)
- Automatic activity logging for all resource interactions
- Secure file storage using Laravel's Storage facade
- Error handling for missing files
- Timestamp-based unique filename generation

---

### 1.2 AnalyticsController.php

**Location:** `app/Http/Controllers/AnalyticsController.php`

**Purpose:** Provides analytics dashboard and CSV export functionality for resource usage tracking.

**Key Methods:**
- `index()` - Display analytics dashboard with filters
- `export()` - Export analytics data to CSV format

**Code:** See full source code in project repository at `app/Http/Controllers/AnalyticsController.php`

**Key Features:**
- Role-based access control (Faculty/Staff and Administrators only)
- Dynamic filtering by form type, date range, and time period
- Summary statistics calculation (views, downloads, previews, uploads)
- Top users and most accessed forms reports
- Daily activity aggregation
- CSV streaming for large datasets
- Pagination for recent activity logs (50 records per page)

---

### 1.3 EventController.php

**Location:** `app/Http/Controllers/EventController.php`

**Purpose:** Manages CRUD operations for OSA events.

**Key Methods:**
- `index()` - List all events
- `create()` - Show event creation form
- `store()` - Save new event to database
- `show()` - Display single event details
- `edit()` - Show event edit form
- `update()` - Update existing event
- `destroy()` - Delete event

**Code:** See full source code in project repository at `app/Http/Controllers/EventController.php`

**Key Features:**
- Comprehensive validation rules
- Event categorization (social, academic, training, workshop, seminar, other)
- Status tracking (upcoming, ongoing, completed, cancelled)
- Date validation (end date must be after start date)
- Automatic status assignment (upcoming) for new events
- User tracking (created_by field)

---


### 1.4 FormSubmissionController.php

**Location:** `app/Http/Controllers/FormSubmissionController.php`

**Purpose:** Handles student form submissions and Faculty/Staff review processes.

**Key Methods:**
- `mySubmissions()` - Display student's own submissions
- `create()` - Show form submission form
- `store()` - Save new form submission
- `show()` - View submission details
- `destroy()` - Delete submission
- `index()` - List all submissions (Faculty/Staff view)
- `updateStatus()` - Update submission status
- `print()` - Generate printable version

**Key Features:**
- Role-based access (students see only their submissions)
- File upload support
- Status management (pending, approved, rejected)
- Faculty/Staff review workflow
- Submission tracking and history

---

### 1.5 StudentProfileController.php

**Location:** `app/Http/Controllers/StudentProfileController.php`

**Purpose:** Manages student profile information accessible to Faculty/Staff and Administrators.

**Key Methods:**
- `index()` - List all student profiles
- `create()` - Show profile creation form
- `store()` - Save new student profile
- `show()` - Display student profile details
- `edit()` - Show profile edit form
- `update()` - Update student profile
- `destroy()` - Delete student profile

**Key Features:**
- Access restricted to Faculty/Staff and Administrators
- Student information management
- Profile data validation
- Integration with User model

---

## 2. MODELS

Models represent database tables and contain business logic following the Active Record pattern.

### 2.1 User Model

**Location:** `app/Models/User.php`

**Purpose:** Represents system users with authentication and role management.


**Key Properties:**
```php
protected $fillable = ['name', 'email', 'password'];
protected $hidden = ['password', 'remember_token'];
protected $appends = ['profile_photo_url'];
protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
];
```

**Key Methods:**
- `roles()` - Many-to-many relationship with Role model
- `hasRole($role)` - Check if user has specific role
- `isAdmin()` - Check if user is administrator
- `isFacultyStaff()` - Check if user is faculty/staff
- `isStudent()` - Check if user is student
- `canEdit()` - Check if user can edit resources (Admin or Faculty/Staff)
- `canDelete()` - Check if user can delete resources (Admin only)
- `canManageUsers()` - Check if user can manage users (Admin only)
- `studentProfile()` - One-to-one relationship with StudentProfile

**Traits Used:**
- `HasApiTokens` - Laravel Sanctum API authentication
- `HasFactory` - Model factory support for testing
- `HasProfilePhoto` - Jetstream profile photo management
- `Notifiable` - Notification support
- `TwoFactorAuthenticatable` - Two-factor authentication

---

### 2.2 FormAccessLog Model

**Location:** `app/Models/FormAccessLog.php`

**Purpose:** Tracks all resource access activities for analytics.

**Key Properties:**
```php
protected $table = 'resource_access_logs';
protected $fillable = [
    'user_id', 'form_type', 'form_name', 'action',
    'ip_address', 'user_agent', 'file_path'
];
protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

**Key Methods:**
- `user()` - Belongs-to relationship with User model
- `logAccess($formType, $action, $formName, $filePath)` - Static method to log activity
- `getAnalytics($formType, $startDate, $endDate)` - Retrieve filtered analytics
- `getSummaryStats($formType, $days)` - Calculate summary statistics

**Logged Actions:**
- `view` - Page view
- `download` - File download
- `preview` - File preview
- `upload` - File upload

---


### 2.3 Event Model

**Location:** `app/Models/Event.php`

**Purpose:** Represents OSA events with scheduling and categorization.

**Key Properties:**
```php
protected $fillable = [
    'title', 'description', 'start_date', 'end_date',
    'venue', 'type', 'status', 'created_by'
];
protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
];
```

**Event Types:**
- social
- academic
- training
- workshop
- seminar
- other

**Event Statuses:**
- upcoming
- ongoing
- completed
- cancelled

**Relationships:**
- `creator()` - Belongs-to relationship with User (created_by)

---

### 2.4 Role Model

**Location:** `app/Models/Role.php`

**Purpose:** Defines user roles for role-based access control.

**Key Properties:**
```php
protected $fillable = ['name', 'slug', 'description'];
```

**System Roles:**
- **admin** - Full system access
- **faculty-staff** - Resource management and analytics access
- **student** - Basic resource access

**Relationships:**
- `users()` - Many-to-many relationship with User model

---

## 3. DATABASE MIGRATIONS

Migrations define the database schema and are version-controlled.

### 3.1 Create Resource Access Logs Table

**File:** `database/migrations/xxxx_xx_xx_create_resource_access_logs_table.php`

**Purpose:** Creates table for tracking resource access activities.


**Schema:**
```php
Schema::create('resource_access_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->string('form_type'); // 'soa', 'gtc', 'pod'
    $table->string('form_name')->nullable();
    $table->enum('action', ['view', 'download', 'preview', 'upload']);
    $table->string('ip_address')->nullable();
    $table->text('user_agent')->nullable();
    $table->string('file_path')->nullable();
    $table->timestamps();
    
    // Indexes for performance
    $table->index('form_type');
    $table->index('action');
    $table->index('created_at');
});
```

---

### 3.2 Create Events Table

**File:** `database/migrations/xxxx_xx_xx_create_events_table.php`

**Purpose:** Creates table for storing OSA events.

**Schema:**
```php
Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->dateTime('start_date');
    $table->dateTime('end_date');
    $table->string('venue');
    $table->enum('type', ['social', 'academic', 'training', 'workshop', 'seminar', 'other']);
    $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
    $table->timestamps();
    
    // Indexes
    $table->index('type');
    $table->index('status');
    $table->index('start_date');
});
```

---

### 3.3 Create Roles and Role_User Tables

**File:** `database/migrations/xxxx_xx_xx_create_roles_tables.php`

**Purpose:** Creates tables for role-based access control.

**Schema:**
```php
// Roles table
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});

// Pivot table for many-to-many relationship
Schema::create('role_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('role_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    
    // Unique constraint to prevent duplicate role assignments
    $table->unique(['user_id', 'role_id']);
});
```

---


### 3.4 Create Student Profiles Table

**File:** `database/migrations/xxxx_xx_xx_create_student_profiles_table.php`

**Purpose:** Creates table for storing student profile information.

**Schema:**
```php
Schema::create('student_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('student_number')->unique();
    $table->string('course')->nullable();
    $table->string('year_level')->nullable();
    $table->string('section')->nullable();
    $table->string('contact_number')->nullable();
    $table->text('address')->nullable();
    $table->timestamps();
});
```

---

### 3.5 Create Form Submissions Table

**File:** `database/migrations/xxxx_xx_xx_create_form_submissions_table.php`

**Purpose:** Creates table for student form submissions.

**Schema:**
```php
Schema::create('form_submissions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('form_type'); // 'soa', 'gtc', 'pod'
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('file_path')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->text('remarks')->nullable();
    $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamp('reviewed_at')->nullable();
    $table->timestamps();
    
    // Indexes
    $table->index('form_type');
    $table->index('status');
    $table->index('user_id');
});
```

---

## 4. ROUTES

Routes define the URL structure and map requests to controllers.

### 4.1 Web Routes

**File:** `routes/web.php`

**Key Route Groups:**

**Authentication Routes (Laravel Jetstream):**
```php
// Handled automatically by Jetstream
// /login, /register, /forgot-password, /reset-password
// /two-factor-challenge, /user/profile, /user/profile-information
```

**Dashboard:**
```php
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
```

**Resource Management Routes:**
```php
Route::middleware(['auth'])->group(function () {
    // SOA Routes
    Route::get('/resources/soa', [ResourceController::class, 'soa'])->name('resources.soa');
    Route::post('/resources/soa/upload', [ResourceController::class, 'soaUpload'])->name('resources.soa.upload');
    Route::get('/resources/soa/download', [ResourceController::class, 'soaDownloadFile'])->name('resources.soa.download');
    Route::get('/resources/soa/template/download', [ResourceController::class, 'soaTemplateDownload'])->name('resources.soa.template.download');
    Route::get('/resources/soa/template/preview', [ResourceController::class, 'soaTemplatePreview'])->name('resources.soa.template.preview');
    
    // GTC Routes
    Route::get('/resources/gtc', [ResourceController::class, 'gtc'])->name('resources.gtc');
    Route::post('/resources/gtc/upload', [ResourceController::class, 'gtcUpload'])->name('resources.gtc.upload');
    Route::get('/resources/gtc/download', [ResourceController::class, 'gtcDownloadFile'])->name('resources.gtc.download');
    Route::get('/resources/gtc/template/download', [ResourceController::class, 'gtcTemplateDownload'])->name('resources.gtc.template.download');
    Route::get('/resources/gtc/template/preview', [ResourceController::class, 'gtcTemplatePreview'])->name('resources.gtc.template.preview');
    
    // POD Routes
    Route::get('/resources/pod', [ResourceController::class, 'pod'])->name('resources.pod');
});
```


**Analytics Routes:**
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
});
```

**Event Management Routes:**
```php
Route::middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
});
// This creates the following routes:
// GET    /events              - index
// GET    /events/create       - create
// POST   /events              - store
// GET    /events/{event}      - show
// GET    /events/{event}/edit - edit
// PUT    /events/{event}      - update
// DELETE /events/{event}      - destroy
```

**Form Submission Routes:**
```php
Route::middleware(['auth'])->group(function () {
    // Student routes
    Route::get('/my-submissions', [FormSubmissionController::class, 'mySubmissions'])->name('submissions.my');
    Route::get('/submissions/create', [FormSubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [FormSubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{formSubmission}', [FormSubmissionController::class, 'show'])->name('submissions.show');
    Route::delete('/submissions/{formSubmission}', [FormSubmissionController::class, 'destroy'])->name('submissions.destroy');
    
    // Faculty/Staff routes
    Route::get('/submissions', [FormSubmissionController::class, 'index'])->name('submissions.index');
    Route::post('/submissions/{formSubmission}/status', [FormSubmissionController::class, 'updateStatus'])->name('submissions.updateStatus');
    Route::get('/submissions/{formSubmission}/print', [FormSubmissionController::class, 'print'])->name('submissions.print');
});
```

**Student Profile Routes:**
```php
Route::middleware(['auth'])->group(function () {
    Route::resource('student-profiles', StudentProfileController::class);
});
```

---

## 5. KEY VIEWS

Views are built using Laravel Blade templating engine with Livewire components.

### 5.1 Dashboard View

**File:** `resources/views/dashboard.blade.php`

**Purpose:** Main dashboard after login, displays role-specific content.

**Key Features:**
- Welcome message with user name
- Quick links to main features
- Role-based content display
- Recent activity summary

---

### 5.2 Resource Management Views

**Files:**
- `resources/views/resources/soa.blade.php`
- `resources/views/resources/gtc.blade.php`
- `resources/views/resources/pod.blade.php`

**Purpose:** Display form templates and uploaded documents.

**Key Features:**
- Template download buttons
- Template preview functionality
- Upload form (Faculty/Staff only)
- List of uploaded documents
- Download and preview buttons for uploaded files

---


### 5.3 Analytics Dashboard View

**File:** `resources/views/analytics/index.blade.php`

**Purpose:** Display comprehensive analytics dashboard with filters and reports.

**Key Sections:**
- Summary statistics cards (total views, downloads, previews, uploads, unique users)
- Filter controls (form type, time period, custom date range)
- Top 10 users table
- Top 10 most accessed forms table
- Recent activity log with pagination
- Export to CSV button

**Key Features:**
- Dynamic filtering without page reload
- Responsive design for mobile devices
- Color-coded statistics
- Sortable tables
- Pagination controls

---

### 5.4 Event Management Views

**Files:**
- `resources/views/events/index.blade.php` - List all events
- `resources/views/events/create.blade.php` - Create new event
- `resources/views/events/show.blade.php` - View event details
- `resources/views/events/edit.blade.php` - Edit event

**Purpose:** Manage OSA events with full CRUD functionality.

**Key Features:**
- Event listing with filters
- Event creation form with validation
- Event details display
- Event editing capabilities
- Event deletion with confirmation
- Status badges (upcoming, ongoing, completed, cancelled)
- Type badges (social, academic, training, etc.)

---

### 5.5 Layout Components

**Main Layout:**
- `resources/views/layouts/app.blade.php` - Main application layout

**Navigation:**
- `resources/views/navigation-menu.blade.php` - Sidebar navigation with role-based menu items

**Components:**
- `resources/views/components/` - Reusable UI components

---

## 6. CONFIGURATION FILES

### 6.1 Database Configuration

**File:** `config/database.php`

**Key Settings:**
```php
'default' => env('DB_CONNECTION', 'mysql'),

'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'primosa'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
    ],
],
```

---


### 6.2 Filesystem Configuration

**File:** `config/filesystems.php`

**Key Settings:**
```php
'default' => env('FILESYSTEM_DISK', 'local'),

'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),
    ],
    
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

---

### 6.3 Application Configuration

**File:** `config/app.php`

**Key Settings:**
```php
'name' => env('APP_NAME', 'PRIMOSA'),
'env' => env('APP_ENV', 'production'),
'debug' => (bool) env('APP_DEBUG', false),
'url' => env('APP_URL', 'http://localhost'),
'timezone' => 'Asia/Manila',
'locale' => 'en',
```

---

### 6.4 Jetstream Configuration

**File:** `config/jetstream.php`

**Key Settings:**
```php
'stack' => 'livewire',
'middleware' => ['web'],

'features' => [
    Features::termsAndPrivacyPolicy(),
    Features::profilePhotos(),
    Features::api(),
    Features::teams(['invitations' => true]),
    Features::accountDeletion(),
],
```

---

### 6.5 Environment Configuration

**File:** `.env`

**Key Variables:**
```env
APP_NAME=PRIMOSA
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=primosa
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@primosa.edu"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 7. COMPOSER DEPENDENCIES

**File:** `composer.json`

**Key Dependencies:**
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/jetstream": "^5.3",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.10.1",
        "livewire/livewire": "^3.0",
        "phpoffice/phpword": "^1.3"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pail": "^1.2.2",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.41",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.6",
        "phpunit/phpunit": "^11.5.3"
    }
}
```

---


## 8. NPM DEPENDENCIES

**File:** `package.json`

**Key Dependencies:**
```json
{
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.7",
        "@tailwindcss/typography": "^0.5.10",
        "@tailwindcss/vite": "^4.0.0",
        "autoprefixer": "^10.4.16",
        "axios": "^1.8.2",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^1.2.0",
        "postcss": "^8.4.32",
        "tailwindcss": "^3.4.0",
        "vite": "^6.2.4"
    }
}
```

---

## 9. MIDDLEWARE

### 9.1 Custom Middleware

**CheckRole Middleware (if implemented):**

**File:** `app/Http/Middleware/CheckRole.php`

**Purpose:** Verify user has required role for accessing specific routes.

**Example:**
```php
public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('login');
    }
    
    foreach ($roles as $role) {
        if (auth()->user()->hasRole($role)) {
            return $next($request);
        }
    }
    
    abort(403, 'Unauthorized access.');
}
```

---

## 10. SEEDERS

### 10.1 Role Seeder

**File:** `database/seeders/RoleSeeder.php`

**Purpose:** Populate roles table with default roles.

**Code:**
```php
public function run()
{
    Role::create([
        'name' => 'Administrator',
        'slug' => 'admin',
        'description' => 'Full system access'
    ]);
    
    Role::create([
        'name' => 'Faculty/Staff',
        'slug' => 'faculty-staff',
        'description' => 'Resource management and analytics access'
    ]);
    
    Role::create([
        'name' => 'Student',
        'slug' => 'student',
        'description' => 'Basic resource access'
    ]);
}
```

---

### 10.2 User Seeder

**File:** `database/seeders/UserSeeder.php`

**Purpose:** Create default admin user for initial system access.

**Code:**
```php
public function run()
{
    $admin = User::create([
        'name' => 'System Administrator',
        'email' => 'admin@primosa.edu',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);
    
    $adminRole = Role::where('slug', 'admin')->first();
    $admin->roles()->attach($adminRole);
}
```

---


## 11. LIVEWIRE COMPONENTS

### 11.1 Event List Component

**File:** `app/Livewire/EventList.php`

**Purpose:** Display and filter events list with real-time updates.

**Key Features:**
- Real-time search and filtering
- Pagination
- Status filtering
- Type filtering
- No page refresh required

---

### 11.2 Analytics Dashboard Component

**File:** `app/Livewire/AnalyticsDashboard.php`

**Purpose:** Interactive analytics dashboard with dynamic filtering.

**Key Features:**
- Real-time filter updates
- Dynamic chart rendering
- Export functionality
- Responsive design

---

## 12. VALIDATION RULES

### 12.1 Event Validation

**Location:** `EventController::store()` and `EventController::update()`

**Rules:**
```php
[
    'title' => 'required|min:3',
    'description' => 'required',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after:start_date',
    'venue' => 'required',
    'type' => 'required|in:social,academic,training,workshop,seminar,other',
    'status' => 'required|in:upcoming,ongoing,completed,cancelled', // update only
]
```

---

### 12.2 File Upload Validation

**Location:** `ResourceController::soaUpload()` and `ResourceController::gtcUpload()`

**Rules:**
```php
[
    'forms.*' => 'required|file|mimes:doc,docx|max:10240', // 10MB max
]
```

---

### 12.3 Form Submission Validation

**Location:** `FormSubmissionController::store()`

**Rules:**
```php
[
    'form_type' => 'required|in:soa,gtc,pod',
    'title' => 'required|min:3|max:255',
    'description' => 'nullable|max:1000',
    'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
]
```

---

## 13. HELPER FUNCTIONS

### 13.1 File Size Formatter

**Location:** `ResourceController::formatFileSize()`

**Purpose:** Convert bytes to human-readable format.

**Code:**
```php
private function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
```

---


## 14. SECURITY FEATURES

### 14.1 CSRF Protection

**Implementation:** Automatic via Laravel middleware

**Usage in Forms:**
```blade
<form method="POST" action="{{ route('events.store') }}">
    @csrf
    <!-- form fields -->
</form>
```

---

### 14.2 Password Hashing

**Implementation:** Automatic via User model cast

**Code:**
```php
protected $casts = [
    'password' => 'hashed',
];
```

---

### 14.3 SQL Injection Prevention

**Implementation:** Eloquent ORM and Query Builder use prepared statements

**Example:**
```php
// Safe - uses parameter binding
$user = User::where('email', $email)->first();

// Safe - uses Eloquent
$events = Event::where('type', $type)->get();
```

---

### 14.4 XSS Protection

**Implementation:** Blade templating engine automatically escapes output

**Example:**
```blade
<!-- Escaped automatically -->
<p>{{ $user->name }}</p>

<!-- Raw output (use with caution) -->
<p>{!! $trustedHtml !!}</p>
```

---

### 14.5 File Upload Security

**Implementation:** MIME type validation and file size limits

**Code:**
```php
$request->validate([
    'forms.*' => 'required|file|mimes:doc,docx|max:10240',
]);
```

---

## 15. API ENDPOINTS (Future Enhancement)

### 15.1 Sanctum API Authentication

**Setup:** Laravel Sanctum is installed and configured

**Token Generation:**
```php
$token = $user->createToken('token-name')->plainTextToken;
```

**Protected Routes:**
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/events', [ApiEventController::class, 'index']);
    Route::get('/api/analytics', [ApiAnalyticsController::class, 'index']);
});
```

---

## 16. TESTING

### 16.1 Feature Tests

**Location:** `tests/Feature/`

**Example Test:**
```php
public function test_user_can_view_events()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->get('/events');
    
    $response->assertStatus(200);
}
```

---

### 16.2 Unit Tests

**Location:** `tests/Unit/`

**Example Test:**
```php
public function test_user_has_admin_role()
{
    $user = User::factory()->create();
    $adminRole = Role::where('slug', 'admin')->first();
    $user->roles()->attach($adminRole);
    
    $this->assertTrue($user->isAdmin());
}
```

---


## 17. DEPLOYMENT SCRIPTS

### 17.1 Deployment Checklist

**Pre-Deployment:**
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Generate application key: `php artisan key:generate`
4. Run migrations: `php artisan migrate --force`
5. Seed database: `php artisan db:seed --force`
6. Clear and cache config: `php artisan config:cache`
7. Clear and cache routes: `php artisan route:cache`
8. Clear and cache views: `php artisan view:cache`
9. Optimize autoloader: `composer install --optimize-autoloader --no-dev`
10. Build assets: `npm run build`
11. Link storage: `php artisan storage:link`
12. Set proper file permissions

---

### 17.2 Artisan Commands

**Common Commands:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan optimize

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Create symbolic link for storage
php artisan storage:link

# Run queue worker
php artisan queue:work

# Monitor logs
php artisan pail
```

---

## 18. DIRECTORY STRUCTURE

```
primosa/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AnalyticsController.php
│   │   │   ├── EventController.php
│   │   │   ├── FormSubmissionController.php
│   │   │   ├── ResourceController.php
│   │   │   └── StudentProfileController.php
│   │   └── Middleware/
│   ├── Livewire/
│   │   ├── AnalyticsDashboard.php
│   │   └── EventList.php
│   ├── Models/
│   │   ├── Event.php
│   │   ├── FormAccessLog.php
│   │   ├── FormSubmission.php
│   │   ├── Role.php
│   │   ├── StudentProfile.php
│   │   └── User.php
│   └── Providers/
├── bootstrap/
├── config/
│   ├── app.php
│   ├── database.php
│   ├── filesystems.php
│   └── jetstream.php
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── xxxx_create_users_table.php
│   │   ├── xxxx_create_roles_tables.php
│   │   ├── xxxx_create_events_table.php
│   │   ├── xxxx_create_resource_access_logs_table.php
│   │   ├── xxxx_create_student_profiles_table.php
│   │   └── xxxx_create_form_submissions_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php
│       └── UserSeeder.php
├── public/
│   ├── forms/
│   │   ├── soa/
│   │   ├── gtc/
│   │   └── pod/
│   └── index.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── analytics/
│       │   └── index.blade.php
│       ├── components/
│       ├── events/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       ├── resources/
│       │   ├── soa.blade.php
│       │   ├── gtc.blade.php
│       │   └── pod.blade.php
│       ├── dashboard.blade.php
│       └── navigation-menu.blade.php
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
│   ├── app/
│   │   └── public/
│   │       └── forms/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
├── tailwind.config.js
└── vite.config.js
```

---


## 19. CODE STANDARDS AND CONVENTIONS

### 19.1 PHP Coding Standards

**Standard:** PSR-12 Extended Coding Style

**Key Conventions:**
- Use 4 spaces for indentation (no tabs)
- Opening braces for classes and methods on new line
- Use camelCase for method names
- Use PascalCase for class names
- Use snake_case for database columns
- Maximum line length: 120 characters

**Example:**
```php
class EventController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
        ]);
        
        return redirect()->route('events.index');
    }
}
```

---

### 19.2 Blade Template Conventions

**Key Conventions:**
- Use `@` directives for control structures
- Use `{{ }}` for escaped output
- Use `{!! !!}` for raw output (with caution)
- Component names use kebab-case
- Indent nested structures

**Example:**
```blade
@extends('layouts.app')

@section('content')
    <div class="container">
        @if($events->count() > 0)
            @foreach($events as $event)
                <div class="event-card">
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->description }}</p>
                </div>
            @endforeach
        @else
            <p>No events found.</p>
        @endif
    </div>
@endsection
```

---

### 19.3 JavaScript Conventions

**Standard:** ES6+ with consistent formatting

**Key Conventions:**
- Use `const` and `let` (avoid `var`)
- Use arrow functions where appropriate
- Use template literals for string interpolation
- Use semicolons
- Use 2 spaces for indentation

**Example:**
```javascript
const fetchAnalytics = async (formType, dateRange) => {
    try {
        const response = await axios.get('/analytics', {
            params: { form_type: formType, date_range: dateRange }
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching analytics:', error);
    }
};
```

---

### 19.4 CSS/Tailwind Conventions

**Key Conventions:**
- Use Tailwind utility classes
- Group related utilities
- Use responsive prefixes (sm:, md:, lg:, xl:)
- Extract repeated patterns to components

**Example:**
```html
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Event Title</h2>
        <p class="text-gray-600 leading-relaxed">Event description...</p>
    </div>
</div>
```

---

## 20. PERFORMANCE OPTIMIZATION

### 20.1 Database Query Optimization

**Eager Loading:**
```php
// Avoid N+1 queries
$logs = FormAccessLog::with('user')->get();

// Instead of
$logs = FormAccessLog::all();
foreach ($logs as $log) {
    echo $log->user->name; // Triggers additional query
}
```

**Indexing:**
```php
// Add indexes in migrations
$table->index('form_type');
$table->index('created_at');
$table->index(['user_id', 'form_type']);
```

---

### 20.2 Caching Strategies

**Config Caching:**
```bash
php artisan config:cache
```

**Route Caching:**
```bash
php artisan route:cache
```

**View Caching:**
```bash
php artisan view:cache
```

**Query Result Caching:**
```php
$stats = Cache::remember('analytics-stats-30days', 3600, function () {
    return FormAccessLog::getSummaryStats(null, 30);
});
```

---

### 20.3 Asset Optimization

**Vite Build:**
```bash
npm run build
```

**Features:**
- Automatic code splitting
- CSS minification
- JavaScript minification
- Asset versioning for cache busting

---


## 21. ERROR HANDLING

### 21.1 Exception Handling

**Global Handler:**
**File:** `app/Exceptions/Handler.php`

**Custom Error Pages:**
- `resources/views/errors/403.blade.php` - Forbidden
- `resources/views/errors/404.blade.php` - Not Found
- `resources/views/errors/500.blade.php` - Server Error

**Try-Catch Example:**
```php
public function store(Request $request)
{
    try {
        $event = Event::create($validated);
        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully.');
    } catch (\Exception $e) {
        Log::error('Event creation failed: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Failed to create event. Please try again.')
            ->withInput();
    }
}
```

---

### 21.2 Validation Error Handling

**Automatic Handling:**
```php
// Validation errors automatically redirect back with errors
$request->validate([
    'title' => 'required|min:3',
]);
```

**Display Errors in Blade:**
```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@error('title')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
```

---

## 22. LOGGING

### 22.1 Log Configuration

**File:** `config/logging.php`

**Channels:**
- `stack` - Multiple channels
- `single` - Single file
- `daily` - Daily rotating files
- `slack` - Slack notifications
- `stderr` - Standard error output

**Usage:**
```php
use Illuminate\Support\Facades\Log;

Log::info('User logged in', ['user_id' => $user->id]);
Log::warning('File upload size exceeded', ['size' => $fileSize]);
Log::error('Database connection failed', ['error' => $e->getMessage()]);
```

---

### 22.2 Activity Logging

**Custom Activity Log:**
```php
FormAccessLog::logAccess('soa', 'download', 'template.docx', 'path/to/file');
```

**Logged Information:**
- User ID
- Form type
- Action performed
- IP address
- User agent
- Timestamp

---

## 23. BACKUP AND RECOVERY

### 23.1 Database Backup

**Manual Backup:**
```bash
mysqldump -u username -p database_name > backup.sql
```

**Automated Backup Script:**
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u username -p password primosa > /backups/primosa_$DATE.sql
```

---

### 23.2 File Backup

**Backup Storage Directory:**
```bash
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/forms
```

---

## 24. MAINTENANCE MODE

### 24.1 Enable Maintenance Mode

```bash
php artisan down --message="System maintenance in progress" --retry=60
```

### 24.2 Disable Maintenance Mode

```bash
php artisan up
```

### 24.3 Allow Specific IPs

```bash
php artisan down --allow=127.0.0.1 --allow=192.168.1.1
```

---


## 25. COMPLETE SOURCE CODE LISTINGS

### 25.1 ResourceController.php (Complete)

**Location:** `app/Http/Controllers/ResourceController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\FormAccessLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ResourceController extends Controller
{
    /**
     * Display SOA form
     */
    public function soa(): View
    {
        FormAccessLog::logAccess('soa', 'view');
        return view('resources.soa');
    }

    /**
     * Display GTC form
     */
    public function gtc(): View
    {
        FormAccessLog::logAccess('gtc', 'view');
        return view('resources.gtc');
    }

    /**
     * Display POD form
     */
    public function pod(): View
    {
        FormAccessLog::logAccess('pod', 'view');
        return view('resources.pod');
    }

    /**
     * Upload SOA forms
     */
    public function soaUpload(Request $request)
    {
        $request->validate([
            'forms.*' => 'required|file|mimes:doc,docx|max:10240',
        ]);

        $uploadedFiles = [];
        $uploadPath = 'forms/soa/uploads';

        if ($request->hasFile('forms')) {
            foreach ($request->file('forms') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs($uploadPath, $filename, 'public');
                $uploadedFiles[] = $filename;

                FormAccessLog::logAccess('soa', 'upload', $filename, 
                    $uploadPath . '/' . $filename);
            }
        }

        return redirect()->route('resources.soa')->with('success',
            count($uploadedFiles) . ' form(s) uploaded successfully!');
    }

    /**
     * Download specific SOA form
     */
    public function soaDownloadFile(Request $request)
    {
        $filename = $request->get('file');
        $filePath = 'forms/soa/uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            FormAccessLog::logAccess('soa', 'download', $filename, $filePath);
            return response()->download(storage_path('app/public/' . $filePath));
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    /**
     * Download SOA template
     */
    public function soaTemplateDownload(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/soa/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('soa', 'download', $templateName, 
                'forms/soa/' . $templateName . '.docx');
            return response()->download($templatePath);
        }

        return redirect()->back()->with('error', 'Template not found.');
    }

    /**
     * Preview SOA template
     */
    public function soaTemplatePreview(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/soa/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('soa', 'preview', $templateName, 
                'forms/soa/' . $templateName . '.docx');
            return view('resources.soa-preview', [
                'templateName' => $templateName,
                'templatePath' => $templatePath,
                'originalFileUrl' => asset('forms/soa/' . $templateName . '.docx')
            ]);
        }

        return redirect()->back()->with('error', 'Template not found.');
    }

    /**
     * Upload GTC forms
     */
    public function gtcUpload(Request $request)
    {
        $request->validate([
            'forms.*' => 'required|file|mimes:doc,docx|max:10240',
        ]);

        $uploadedFiles = [];
        $uploadPath = 'forms/gtc/uploads';

        if ($request->hasFile('forms')) {
            foreach ($request->file('forms') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs($uploadPath, $filename, 'public');
                $uploadedFiles[] = $filename;

                FormAccessLog::logAccess('gtc', 'upload', $filename, 
                    $uploadPath . '/' . $filename);
            }
        }

        return redirect()->route('resources.gtc')->with('success',
            count($uploadedFiles) . ' form(s) uploaded successfully!');
    }

    /**
     * Download specific GTC form
     */
    public function gtcDownloadFile(Request $request)
    {
        $filename = $request->get('file');
        $filePath = 'forms/gtc/uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            FormAccessLog::logAccess('gtc', 'download', $filename, $filePath);
            return response()->download(storage_path('app/public/' . $filePath));
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    /**
     * Download GTC template
     */
    public function gtcTemplateDownload(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/gtc/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('gtc', 'download', $templateName, 
                'forms/gtc/' . $templateName . '.docx');
            return response()->download($templatePath);
        }

        return redirect()->back()->with('error', 'Template not found.');
    }

    /**
     * Preview GTC template
     */
    public function gtcTemplatePreview(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/gtc/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('gtc', 'preview', $templateName, 
                'forms/gtc/' . $templateName . '.docx');
            return view('resources.gtc-preview', [
                'templateName' => $templateName,
                'templatePath' => $templatePath,
                'originalFileUrl' => asset('forms/gtc/' . $templateName . '.docx')
            ]);
        }

        return redirect()->back()->with('error', 'Template not found.');
    }

    /**
     * Format file size
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
```

---


### 25.2 AnalyticsController.php (Complete)

**Location:** `app/Http/Controllers/AnalyticsController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\FormAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        // Check if user is Faculty/Staff or Admin
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized access. Only Faculty/Staff and Administrators can view analytics.');
        }

        $formType = $request->get('form_type', 'all');
        $days = $request->get('days', 30);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Get summary statistics
        $stats = FormAccessLog::getSummaryStats(
            $formType === 'all' ? null : $formType, 
            $days
        );

        // Get recent activity
        $query = FormAccessLog::with('user')->orderBy('created_at', 'desc');

        if ($formType !== 'all') {
            $query->where('form_type', $formType);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $recentActivity = $query->paginate(50);

        // Get daily activity chart data
        $dailyActivity = FormAccessLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                'action'
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->when($formType !== 'all', function($q) use ($formType) {
                return $q->where('form_type', $formType);
            })
            ->groupBy('date', 'action')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        // Get top users
        $topUsers = FormAccessLog::select('user_id', DB::raw('COUNT(*) as access_count'))
            ->with('user')
            ->where('created_at', '>=', now()->subDays($days))
            ->when($formType !== 'all', function($q) use ($formType) {
                return $q->where('form_type', $formType);
            })
            ->groupBy('user_id')
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // Get most accessed forms
        $topForms = FormAccessLog::select('form_name', 'form_type', 
                DB::raw('COUNT(*) as access_count'))
            ->whereNotNull('form_name')
            ->where('created_at', '>=', now()->subDays($days))
            ->when($formType !== 'all', function($q) use ($formType) {
                return $q->where('form_type', $formType);
            })
            ->groupBy('form_name', 'form_type')
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        return view('analytics.index', compact(
            'stats',
            'recentActivity',
            'dailyActivity',
            'topUsers',
            'topForms',
            'formType',
            'days',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        // Check if user is Faculty/Staff or Admin
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized access.');
        }

        $formType = $request->get('form_type', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = FormAccessLog::with('user')->orderBy('created_at', 'desc');

        if ($formType !== 'all') {
            $query->where('form_type', $formType);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $logs = $query->get();

        $filename = 'form-analytics-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Date/Time', 'User', 'Email', 'Form Type', 
                'Form Name', 'Action', 'IP Address']);

            // Add data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user ? $log->user->name : 'Guest',
                    $log->user ? $log->user->email : 'N/A',
                    strtoupper($log->form_type),
                    $log->form_name ?? 'N/A',
                    ucfirst($log->action),
                    $log->ip_address ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
```

---

## 26. NOTES FOR DEVELOPERS

### 26.1 Getting Started

1. Clone the repository
2. Copy `.env.example` to `.env`
3. Configure database credentials in `.env`
4. Run `composer install`
5. Run `npm install`
6. Run `php artisan key:generate`
7. Run `php artisan migrate`
8. Run `php artisan db:seed`
9. Run `php artisan storage:link`
10. Run `npm run dev` for development or `npm run build` for production

### 26.2 Development Workflow

1. Create feature branch from `main`
2. Make changes and test locally
3. Run `php artisan test` to ensure tests pass
4. Run `./vendor/bin/pint` to format code
5. Commit changes with descriptive message
6. Push to remote and create pull request
7. After review and approval, merge to `main`

### 26.3 Code Review Checklist

- [ ] Code follows PSR-12 standards
- [ ] All methods have docblocks
- [ ] Validation rules are appropriate
- [ ] Security best practices followed
- [ ] No sensitive data in code
- [ ] Error handling implemented
- [ ] Tests written and passing
- [ ] Database queries optimized
- [ ] No N+1 query problems
- [ ] UI is responsive and accessible

---

## 27. CONCLUSION

This appendix provides comprehensive documentation of the PRIMOSA source code, including controllers, models, migrations, routes, views, and configuration files. The code follows Laravel best practices and modern PHP standards, ensuring maintainability, security, and scalability.

For the complete, up-to-date source code, please refer to the project repository. All code is version-controlled using Git and hosted on GitHub for collaboration and backup purposes.

---

**End of Appendix D**
