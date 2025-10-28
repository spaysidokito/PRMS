# MySQL Restart Instructions

## Problem
There's a ghost constraint referencing a non-existent table `form_access_logs` that's preventing user deletion. This is caused by orphaned MySQL metadata.

## Solution: Restart MySQL

### For XAMPP Users (Windows):

1. **Open XAMPP Control Panel**
2. **Stop MySQL** - Click the "Stop" button next to MySQL
3. **Wait 5 seconds**
4. **Start MySQL** - Click the "Start" button next to MySQL
5. **Test** - Try deleting a user again

### Alternative: Restart via Command Line

```cmd
# Stop MySQL
net stop mysql

# Start MySQL
net start mysql
```

### For Linux/Mac Users:

```bash
# Restart MySQL
sudo systemctl restart mysql
# or
sudo service mysql restart
```

## After Restart

1. Clear Laravel caches:
```bash
php artisan optimize:clear
```

2. Try deleting a user through the web interface

## Why This Happens

MySQL sometimes keeps metadata about tables in memory even after they're dropped, especially if:
- Tables were created and dropped multiple times
- There were migration errors
- MySQL wasn't shut down cleanly

Restarting MySQL clears this cached metadata.

## If Problem Persists

If restarting MySQL doesn't fix it, we may need to manually clean the MySQL data directory:

1. Stop MySQL
2. Navigate to: `C:\xampp\mysql\data\sprms\` (for XAMPP)
3. Delete any files named `form_access_logs.*`
4. Start MySQL
5. Run: `php artisan migrate:status`

## Prevention

To avoid this in the future:
- Always use proper migrations
- Don't manually drop tables while the app is running
- Use `php artisan migrate:rollback` instead of manual SQL
