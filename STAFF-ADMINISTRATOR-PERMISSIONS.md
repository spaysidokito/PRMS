# Staff/Administrator Permissions and Capabilities

## Overview

This document provides a comprehensive list of all permissions and capabilities available to Faculty/Staff and OSA Staff/Administrators in the PRIMOSA system. These roles have elevated privileges beyond standard student access.

---

## Faculty/Staff Permissions

Faculty/Staff members have all student permissions plus additional capabilities for managing resources and viewing analytics.

### Inherited Student Permissions

Faculty/Staff can perform all actions that students can:

1. **View Resources**
   - Browse all available forms and documents
   - Access SOA (Statement of Account) resources
   - Access GTC (Good to Clear) resources
   - Access POD (Proof of Delivery) resources

2. **Download Forms**
   - Download SOA templates
   - Download GTC templates
   - Download POD templates
   - Download uploaded documents

3. **Preview Documents**
   - Preview SOA templates before downloading
   - Preview GTC templates before downloading
   - Preview POD templates before downloading
   - Preview uploaded files

4. **View Events**
   - Access event calendar
   - View event details
   - View event schedules
   - See upcoming events

5. **Manage Profile**
   - Update personal information
   - Change password
   - Upload/change profile picture
   - Update contact details
   - Enable/disable two-factor authentication

### Additional Faculty/Staff Permissions

#### Resource Management

1. **Upload Resources**
   - Upload new SOA forms and templates
   - Upload new GTC forms and templates
   - Upload new POD forms and templates
   - Upload supporting documents
   - Replace existing documents

2. **Manage Forms**
   - Edit form names and descriptions
   - Delete uploaded forms
   - Organize forms by category
   - Update form metadata
   - Archive old forms

3. **File Operations**
   - Bulk upload multiple files
   - Move files between categories
   - Rename uploaded files
   - Update file descriptions

#### Analytics Access

1. **View Analytics Dashboard**
   - Access `/analytics` route
   - View summary statistics:
     - Total views
     - Total downloads
     - Total previews
     - Total uploads
     - Unique users count

2. **Filter Analytics Data**
   - Filter by form type (All, SOA, GTC, POD)
   - Filter by time period (7, 30, 90, 365 days)
   - Set custom date ranges
   - View filtered results in real-time

3. **View Top Users**
   - See the 10 most active users
   - View access counts per user
   - Identify engagement patterns

4. **View Most Accessed Forms**
   - See the 10 most accessed forms/templates
   - View access counts per form
   - Identify popular resources

5. **View Recent Activity Log**
   - See detailed activity logs
   - View user actions (view, download, preview, upload)
   - See timestamps and IP addresses
   - Navigate paginated results (50 per page)

6. **Export Analytics**
   - Export filtered data to CSV
   - Download comprehensive reports
   - Save analytics for external analysis
   - Generate timestamped export files

#### Task Management

1. **Create Tasks**
   - Create new tasks for team members
   - Set task titles and descriptions
   - Assign due dates
   - Set priority levels
   - Assign tasks to specific users

2. **Manage Tasks**
   - Edit existing tasks
   - Update task status
   - Reassign tasks
   - Delete tasks
   - View task history

#### Event Management

1. **Create Events**
   - Create new events in the calendar
   - Set event titles and descriptions
   - Define event dates and times
   - Set event locations
   - Add event categories/tags

2. **Manage Events**
   - Edit existing events
   - Delete events
   - Update event details
   - Manage event participants
   - Send event notifications

#### Collaboration Features

1. **Resource Sharing**
   - Share resources with specific users
   - Control access to uploaded files
   - Collaborate on document management

2. **Activity Tracking**
   - View own activity history
   - Track resource usage
   - Monitor engagement metrics

---

## OSA Staff/Administrator Permissions

Administrators have all Faculty/Staff permissions plus full system access including user management, system configuration, and comprehensive analytics.

### Inherited Faculty/Staff Permissions

Administrators can perform all actions that Faculty/Staff can:
- All student permissions
- Upload and manage resources
- View and export analytics
- Create and manage tasks
- Create and manage events

### Additional Administrator Permissions

#### User Management

1. **Create Users**
   - Add new student accounts
   - Add new faculty/staff accounts
   - Add new administrator accounts
   - Set initial passwords
   - Send welcome emails

2. **Edit Users**
   - Update user information
   - Change user names and emails
   - Modify contact details
   - Update user profiles
   - Reset user passwords

3. **Delete Users**
   - Remove user accounts
   - Soft delete for data retention
   - Permanently delete users
   - Handle user data cleanup

4. **Manage User Roles**
   - Assign roles (Student, Faculty/Staff, Administrator)
   - Change user roles
   - Promote/demote users
   - Set role-specific permissions

5. **User Account Control**
   - Enable/disable user accounts
   - Lock/unlock accounts
   - Force password resets
   - Manage two-factor authentication
   - View user sessions

6. **Bulk User Operations**
   - Import users from CSV
   - Export user lists
   - Bulk role assignments
   - Mass email notifications

#### System Configuration

1. **System Settings**
   - Configure application settings
   - Update system preferences
   - Manage email configurations
   - Set file upload limits
   - Configure security settings

2. **Database Management**
   - Access phpMyAdmin
   - Run database queries
   - Manage database backups
   - Optimize database tables
   - View database statistics

3. **File System Management**
   - Manage storage directories
   - Configure file storage locations
   - Set file retention policies
   - Manage disk space
   - Clean up old files

4. **Security Configuration**
   - Configure authentication settings
   - Manage SSL certificates
   - Set password policies
   - Configure rate limiting
   - Manage firewall rules

#### Advanced Analytics

1. **Comprehensive Activity Tracking**
   - View all user activities system-wide
   - Track login/logout events
   - Monitor failed login attempts
   - View session history
   - Track administrative actions

2. **System Logs**
   - Access application logs
   - View error logs
   - Monitor performance logs
   - Track security events
   - Export log files

3. **User Behavior Analytics**
   - Analyze user engagement patterns
   - Track feature usage
   - Identify inactive users
   - Monitor resource popularity
   - Generate usage reports

4. **Advanced Reporting**
   - Generate custom reports
   - Create scheduled reports
   - Set up automated email reports
   - Build report templates
   - Export in multiple formats (CSV, PDF)

#### Report Generation

1. **Automated Report Generation**
   - Generate system-wide reports
   - Create user activity reports
   - Compile resource usage reports
   - Generate compliance reports
   - Schedule automated reports

2. **Custom Report Builder**
   - Define custom report criteria
   - Select specific data fields
   - Apply complex filters
   - Create report templates
   - Save report configurations

3. **Document Generation**
   - Generate Word documents using PHPWord
   - Create PDF reports
   - Generate form templates
   - Create bulk documents
   - Customize document templates

#### Maintenance and Monitoring

1. **System Maintenance**
   - Run maintenance tasks
   - Clear application cache
   - Optimize database
   - Clean up temporary files
   - Update system dependencies

2. **Performance Monitoring**
   - View system performance metrics
   - Monitor server resources
   - Track response times
   - Identify bottlenecks
   - Optimize slow queries

3. **Backup Management**
   - Configure backup schedules
   - Perform manual backups
   - Restore from backups
   - Verify backup integrity
   - Manage backup storage

4. **Queue Management**
   - Monitor background jobs
   - View queue status
   - Retry failed jobs
   - Clear stuck jobs
   - Configure queue workers

#### Advanced Features

1. **Email Management**
   - Send system-wide announcements
   - Configure email templates
   - Manage email queues
   - View email logs
   - Test email delivery

2. **Notification Management**
   - Configure notification settings
   - Send custom notifications
   - Manage notification templates
   - View notification history
   - Set notification preferences

3. **API Management**
   - Generate API tokens
   - Manage API access
   - View API usage logs
   - Configure API rate limits
   - Test API endpoints

4. **Integration Management**
   - Configure external integrations
   - Manage webhooks
   - Set up third-party services
   - Monitor integration status
   - Test integrations

---

## Permission Comparison Table

| Feature | Student | Faculty/Staff | Administrator |
|---------|---------|---------------|---------------|
| **Resource Access** |
| View Resources | ✅ | ✅ | ✅ |
| Download Forms | ✅ | ✅ | ✅ |
| Preview Documents | ✅ | ✅ | ✅ |
| Upload Resources | ❌ | ✅ | ✅ |
| Manage Forms | ❌ | ✅ | ✅ |
| Delete Resources | ❌ | ✅ | ✅ |
| **Analytics** |
| View Analytics | ❌ | ✅ | ✅ |
| Export Analytics | ❌ | ✅ | ✅ |
| View All User Activity | ❌ | ❌ | ✅ |
| System-wide Reports | ❌ | ❌ | ✅ |
| **User Management** |
| Manage Own Profile | ✅ | ✅ | ✅ |
| Create Users | ❌ | ❌ | ✅ |
| Edit Users | ❌ | ❌ | ✅ |
| Delete Users | ❌ | ❌ | ✅ |
| Assign Roles | ❌ | ❌ | ✅ |
| **Task Management** |
| View Tasks | ✅ | ✅ | ✅ |
| Create Tasks | ❌ | ✅ | ✅ |
| Assign Tasks | ❌ | ✅ | ✅ |
| Delete Tasks | ❌ | ✅ | ✅ |
| **Event Management** |
| View Events | ✅ | ✅ | ✅ |
| Create Events | ❌ | ✅ | ✅ |
| Edit Events | ❌ | ✅ | ✅ |
| Delete Events | ❌ | ✅ | ✅ |
| **System Administration** |
| System Configuration | ❌ | ❌ | ✅ |
| Database Access | ❌ | ❌ | ✅ |
| View System Logs | ❌ | ❌ | ✅ |
| Backup Management | ❌ | ❌ | ✅ |
| Queue Management | ❌ | ❌ | ✅ |

---

## Authorization Methods

### Code-Level Permission Checks

PRIMOSA uses the following methods to check permissions:

#### `canEdit()` Method
Returns `true` if the user is Faculty/Staff or Administrator.

**Usage:**
```php
if (auth()->user()->canEdit()) {
    // User can upload, edit, and manage resources
    // User can view analytics
    // User can create tasks and events
}
```

**Grants Access To:**
- Resource upload and management
- Analytics dashboard
- Task creation and management
- Event creation and management

#### `canManageUsers()` Method
Returns `true` if the user is Administrator.

**Usage:**
```php
if (auth()->user()->canManageUsers()) {
    // User can manage all users
    // User can configure system settings
    // User has full administrative access
}
```

**Grants Access To:**
- User management (create, edit, delete)
- Role assignment
- System configuration
- Advanced analytics
- System logs and monitoring

---

## Access Control Examples

### Route Protection

**Faculty/Staff Protected Routes:**
```php
// Only Faculty/Staff and Administrators can access
Route::middleware(['auth', 'can:edit'])->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index']);
    Route::post('/resources/upload', [ResourceController::class, 'upload']);
    Route::post('/tasks/create', [TaskController::class, 'create']);
});
```

**Administrator Protected Routes:**
```php
// Only Administrators can access
Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
```

### Blade Template Conditionals

**Show/Hide Based on Permissions:**
```blade
@if(auth()->user()->canEdit())
    <!-- Show upload button, analytics link, etc. -->
    <a href="/analytics">View Analytics</a>
    <button>Upload Resource</button>
@endif

@if(auth()->user()->canManageUsers())
    <!-- Show user management link -->
    <a href="/users">Manage Users</a>
@endif
```

---

## Security Considerations

### Permission Enforcement

1. **Server-Side Validation**
   - All permissions checked on the server
   - Never rely on client-side checks alone
   - Middleware enforces access control

2. **Database-Level Security**
   - Foreign key constraints
   - Row-level security where applicable
   - Audit trails for sensitive operations

3. **Activity Logging**
   - All administrative actions logged
   - User access tracked
   - IP addresses recorded for security

4. **Session Management**
   - Secure session handling
   - Automatic logout after inactivity
   - Session hijacking prevention

---

## Conclusion

Faculty/Staff and Administrators have progressively elevated permissions that enable them to manage resources, view analytics, and administer the PRIMOSA system effectively. The permission system is designed with security in mind, ensuring that users can only access features appropriate to their role while maintaining comprehensive audit trails for accountability.

For technical implementation details, refer to:
- [TOOLS-AND-TECHNOLOGIES.md](TOOLS-AND-TECHNOLOGIES.md) - Technology stack
- [SYSTEM-DIAGRAMS.md](SYSTEM-DIAGRAMS.md) - System architecture and workflows
- [ANALYTICS-DOCUMENTATION.md](ANALYTICS-DOCUMENTATION.md) - Analytics features
- [SECURITY.md](SECURITY.md) - Security implementation
