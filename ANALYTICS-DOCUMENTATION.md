# Resource Analytics Documentation

## Overview

The Resource Analytics system tracks all user interactions with forms and files in the Resource Management section. This feature is only accessible to Faculty/Staff and Administrators.

## Features

### Tracked Actions

-   **View**: When a user visits a form page (SOA, GTC, POD)
-   **Download**: When a user downloads a template or uploaded file
-   **Preview**: When a user previews a template or file
-   **Upload**: When a user uploads a new form

### Analytics Dashboard

Access the analytics dashboard at: `/analytics`

**Available to:**

-   Faculty/Staff (canEdit() permission)
-   Administrators (canManageUsers() permission)

### Dashboard Features

1. **Summary Statistics**

    - Total Views
    - Total Downloads
    - Total Previews
    - Total Uploads
    - Unique Users

2. **Filters**

    - Form Type (All, SOA, GTC, POD)
    - Time Period (7, 30, 90, 365 days)
    - Custom Date Range (Start Date - End Date)

3. **Top Users**

    - Shows the 10 most active users
    - Displays total access count per user

4. **Most Accessed Forms**

    - Shows the 10 most accessed forms/templates
    - Displays form type and access count

5. **Recent Activity Log**

    - Detailed log of all recent activities
    - Shows: Date/Time, User, Form Type, Form Name, Action, IP Address
    - Paginated (50 records per page)

6. **Export Functionality**
    - Export analytics data to CSV
    - Includes all filtered data
    - Filename format: `form-analytics-YYYY-MM-DD-HHMMSS.csv`

## Technical Implementation

### Database Table: `resource_access_logs`

```sql
- id (bigint, primary key)
- user_id (bigint, nullable, foreign key to users)
- form_type (string: 'soa', 'gtc', 'pod')
- form_name (string, nullable)
- action (enum: 'view', 'download', 'preview', 'upload')
- ip_address (string, nullable)
- user_agent (text, nullable)
- file_path (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Model: `FormAccessLog`

**Location:** `app/Models/FormAccessLog.php`

**Key Methods:**

-   `logAccess($formType, $action, $formName, $filePath)` - Log a new access event
-   `getAnalytics($formType, $startDate, $endDate)` - Get filtered analytics data
-   `getSummaryStats($formType, $days)` - Get summary statistics

### Controller: `AnalyticsController`

**Location:** `app/Http/Controllers/AnalyticsController.php`

**Routes:**

-   `GET /analytics` - Display analytics dashboard
-   `GET /analytics/export` - Export analytics to CSV

### Automatic Tracking

All resource access is automatically tracked in `ResourceController`:

**Tracked Methods:**

-   `soa()`, `gtc()`, `pod()` - Page views
-   `soaTemplateDownload()`, `gtcTemplateDownload()` - Template downloads
-   `soaTemplatePreview()`, `gtcTemplatePreview()` - Template previews
-   `soaDownloadFile()`, `gtcDownloadFile()` - Uploaded file downloads
-   `soaUpload()`, `gtcUpload()` - File uploads

## Usage Examples

### Viewing Analytics

1. Login as Faculty/Staff or Administrator
2. Click "Analytics" in the sidebar navigation
3. View summary statistics and recent activity
4. Use filters to narrow down data

### Filtering Data

```
Form Type: SOA
Time Period: Last 30 Days
```

Or use custom date range:

```
Start Date: 2025-01-01
End Date: 2025-01-31
```

### Exporting Data

1. Apply desired filters
2. Click "Export CSV" button
3. CSV file will download with all filtered data

### Programmatic Access

```php
use App\Models\FormAccessLog;

// Log an access
FormAccessLog::logAccess('soa', 'download', 'template-name.docx', 'path/to/file');

// Get analytics for last 30 days
$stats = FormAccessLog::getSummaryStats('soa', 30);

// Get detailed logs
$logs = FormAccessLog::getAnalytics('gtc', '2025-01-01', '2025-01-31');
```

## Security

### Access Control

Analytics are protected by the `canEdit()` method which checks if the user has:

-   Faculty/Staff role
-   Administrator role

Students cannot access analytics.

### Data Privacy

-   IP addresses are logged for security purposes
-   User agents are stored to identify access patterns
-   All data is associated with authenticated users
-   Guest access is not tracked (requires login)

## Navigation

Analytics link appears in the sidebar navigation between "Resource Management" and "User Management" (if applicable).

**Visibility:**

-   ✅ Administrators
-   ✅ Faculty/Staff
-   ❌ Students

## CSV Export Format

```csv
Date/Time,User,Email,Form Type,Form Name,Action,IP Address
2025-10-28 10:30:00,John Doe,john@example.com,SOA,template.docx,download,192.168.1.1
2025-10-28 10:25:00,Jane Smith,jane@example.com,GTC,form.docx,preview,192.168.1.2
```

## Future Enhancements

Potential improvements:

-   Real-time analytics dashboard
-   Charts and graphs for visual representation
-   Email reports for administrators
-   Download statistics by time of day
-   User behavior patterns
-   Form popularity trends
-   Automated alerts for unusual activity

## Troubleshooting

### Analytics not showing data

-   Ensure you're logged in as Faculty/Staff or Administrator
-   Check that the migration has been run: `php artisan migrate`
-   Verify that tracking is working by accessing a form

### Export not working

-   Check file permissions on storage directory
-   Verify user has `canEdit()` permission
-   Check browser console for errors

### Missing data in logs

-   Ensure `FormAccessLog::logAccess()` is called in all relevant methods
-   Check database connection
-   Verify table exists: `resource_access_logs`

## Support

For issues or questions, contact the system administrator.
