# PRIMOSA Deployment Architecture

## Deployment Diagram

### Figure: PRIMOSA System Deployment Architecture

The deployment diagram represents the hardware and software relation needed to host the PRIMOSA system, requiring a host device with the Laravel application and MySQL database installed and running, where client devices establish connection through HTTP/HTTPS protocols to access the system via web browsers, with an optional camera for capturing profile pictures directly within the application.

---

## Detailed Architecture Description

The deployment diagram represents the hardware and software infrastructure required to host and access the PRIMOSA system. The architecture follows a client-server model with the following components:

## Host Machine (Server Side)

The host machine serves as the central server infrastructure that runs the PRIMOSA application. It consists of two primary components working in tandem:

### 1. PRIMOSA System served through PHP

The Laravel 11 application running on PHP 8.2+ serves as the core system, handling all business logic, user authentication, data processing, and request routing. The application is served through a web server (Apache or Nginx) that processes HTTP/HTTPS requests from client devices. The PHP runtime executes the Laravel framework code, processes Livewire components for dynamic interfaces, and generates HTML responses that are sent back to client browsers.

Key responsibilities include:
- Processing user authentication and authorization
- Managing student profiles and academic records
- Coordinating event creation and tracking
- Handling resource uploads and downloads
- Processing form submissions and approvals
- Generating analytics and reports
- Enforcing role-based access control
- Validating all user inputs and requests

### 2. Database Management System (MySQL)

MySQL 8.0+ serves as the relational database management system, storing all persistent data including:
- User accounts with authentication credentials
- Student profiles with academic and personal information
- Event records with scheduling details
- Resource metadata and file paths
- Form submissions with approval statuses
- Analytics logs tracking all system activities
- Role and permission definitions
- Audit trails for accountability

The database communicates directly with the PHP application through secure database connections using Eloquent ORM for data operations. All queries are parameterized to prevent SQL injection attacks, and database transactions ensure data integrity during complex operations.

## Communication Protocol

The host machine and client devices communicate through HTTP/HTTPS protocols over the internet or local network. HTTPS is strongly recommended for production environments to ensure encrypted data transmission, protecting sensitive student information, user credentials, and institutional data during transit.

The bidirectional arrows in the diagram indicate request-response cycles where:
- **Client to Server**: Clients send HTTP requests such as page loads, form submissions, file uploads, or data queries
- **Server to Client**: Server responds with rendered HTML pages, JSON data, file downloads, or confirmation messages

All communication follows the stateless HTTP protocol, with user sessions maintained through secure, HTTP-only cookies that prevent JavaScript access and reduce XSS attack vectors.

## Client Device (User Side)

Client devices represent the end-user hardware used to access the PRIMOSA system. These can be desktop computers, laptops, tablets, or smartphones. The client side consists of two main components:

### 1. Browser

Users access PRIMOSA through modern web browsers such as Google Chrome, Mozilla Firefox, Microsoft Edge, or Safari. The browser renders the HTML, CSS, and JavaScript delivered by the server, providing the user interface for interacting with the system.

Browser responsibilities include:
- Rendering responsive layouts that adapt to screen size
- Displaying data tables on desktop and card views on mobile
- Managing form inputs and client-side validation
- Handling user sessions through cookies
- Executing JavaScript for interactive features
- Processing Livewire component updates
- Managing file uploads and downloads
- Displaying real-time feedback and notifications

No additional software installation is required on client devices, making the system easily accessible from any device with a web browser and internet connection. The responsive design ensures optimal user experience across all device types.

### 2. Camera

The camera component represents the device's built-in or external camera capability. This hardware feature is required for capturing and uploading profile pictures for student profiles and user accounts.

Camera functionality:
- Accessed through the browser's media API (getUserMedia)
- Allows users to take photos directly within the application
- Provides alternative to uploading existing image files
- Enhances user experience with immediate photo capture
- No separate photo-taking applications required
- Optional for basic system operation but recommended for complete profile management

The camera integration respects user privacy by requesting permission before access and only activating when explicitly triggered by the user for profile picture capture.

## System Requirements

### Server Requirements

**Operating System:**
- Windows Server 2016+ or Linux (Ubuntu 20.04+, CentOS 8+ recommended)

**Web Server:**
- Apache 2.4+ with mod_rewrite enabled, or
- Nginx 1.18+ with proper PHP-FPM configuration

**PHP Requirements:**
- Version: 8.2 or higher
- Required Extensions: mbstring, openssl, pdo, pdo_mysql, tokenizer, xml, ctype, json, bcmath, fileinfo, gd
- Configuration: memory_limit ≥ 256MB, upload_max_filesize ≥ 10MB, post_max_size ≥ 10MB

**Database:**
- MySQL 8.0+ or MariaDB 10.3+
- InnoDB storage engine for transaction support
- UTF-8 character encoding (utf8mb4_unicode_ci collation)

**Memory:**
- Minimum: 2GB RAM
- Recommended: 4GB RAM for production environments
- Additional memory for concurrent users and large file operations

**Storage:**
- Minimum: 20GB available disk space
- Additional space for uploaded files and database growth
- SSD recommended for improved performance

**Network:**
- Stable internet connection
- Sufficient bandwidth for concurrent users (minimum 10 Mbps recommended)
- Static IP address or domain name for consistent access

### Client Requirements

**Web Browser:**
- Google Chrome 90+ (recommended)
- Mozilla Firefox 88+
- Microsoft Edge 90+
- Safari 14+
- JavaScript must be enabled
- Cookies must be enabled for session management

**Internet Connectivity:**
- Minimum: 1 Mbps download/upload speed
- Recommended: 5 Mbps for optimal experience
- Stable connection for uninterrupted access

**Screen Resolution:**
- Minimum: 320px width (mobile devices)
- Recommended: 768px+ for tablet experience
- Optimal: 1024px+ for desktop experience

**Camera (Optional):**
- Built-in or external camera device
- Browser permission for camera access
- Minimum resolution: 640x480 (VGA)
- Recommended: 1280x720 (HD) or higher

### Network Requirements

**Connectivity:**
- HTTP/HTTPS connectivity between client and server
- HTTPS strongly recommended for production deployment
- SSL/TLS certificate (Let's Encrypt or commercial CA)

**Firewall Configuration:**
- Port 80 (HTTP) open for initial access and redirects
- Port 443 (HTTPS) open for secure communication
- Port 3306 (MySQL) restricted to localhost or specific IPs
- Proper firewall rules to prevent unauthorized access

**Domain and DNS:**
- Registered domain name (recommended)
- Proper DNS configuration pointing to server IP
- SSL certificate matching domain name

## Security Considerations

The deployment architecture incorporates multiple security layers to protect data and ensure system integrity:

**Authentication Security:**
- Bcrypt password hashing with cost factor of 10
- Secure session management with HTTP-only cookies
- CSRF token validation for all state-changing requests
- Email verification for new accounts
- Password reset functionality with secure tokens

**Authorization Security:**
- Role-based access control (Students, Faculty/Staff, Administrators)
- Granular permissions (canView, canEdit, canDelete, canManageUsers)
- Middleware guards protecting routes
- Permission checks at controller and view levels

**Data Security:**
- SQL injection prevention through parameterized queries
- XSS protection through output escaping
- File upload validation (type, size, content)
- Secure file storage with access controls
- Data encryption in transit (HTTPS) and at rest (database encryption)

**Audit and Logging:**
- Comprehensive activity logging
- User authentication tracking
- Resource access logging
- Form submission and approval tracking
- IP address and user agent recording
- Timestamp tracking for all activities

**Compliance:**
- Philippine Data Privacy Act (RA 10173) compliance
- Secure handling of personal information
- Data retention policies
- User consent mechanisms
- Right to access and deletion support

## Scalability and Performance

The architecture supports scalability and performance optimization through:

**Database Optimization:**
- Indexing on frequently queried fields (student_id, user_id, email)
- Query optimization using Eloquent ORM
- Database connection pooling
- Efficient relationship loading (eager loading)

**Application Performance:**
- Opcode caching (OPcache) for PHP
- Route caching for faster request routing
- Configuration caching for reduced file I/O
- View caching for compiled templates

**Asset Optimization:**
- Vite build process for asset bundling
- CSS and JavaScript minification
- Image optimization for profile pictures
- Browser caching headers for static assets

**Caching Strategies:**
- Application-level caching for frequently accessed data
- Session caching for improved performance
- Query result caching for expensive operations

**Horizontal Scaling:**
- Ability to add multiple application servers
- Load balancer distribution of requests
- Shared session storage (Redis/Memcached)
- Centralized file storage for uploaded files

**Monitoring and Maintenance:**
- Error logging and monitoring
- Performance metrics tracking
- Database query analysis
- Regular backup procedures
- System health checks

## Deployment Benefits

This deployment architecture ensures PRIMOSA is:

**Accessible** - Available from any device with a web browser, no software installation required

**Centralized** - All data managed on the server side, ensuring consistency and single source of truth

**Secure** - Multiple security layers protect sensitive student information and institutional data

**Maintainable** - Updates deployed centrally, all users immediately access the latest version

**Scalable** - Architecture supports growth in users, data, and features

**Cost-Effective** - Web-based approach reduces IT support requirements and client-side infrastructure costs

**Reliable** - Proper backup and recovery procedures ensure data protection and business continuity

The separation of concerns between client presentation and server processing provides a maintainable and scalable foundation for the student affairs management system, supporting the evolving needs of St. Anne College Lucena, Inc.'s Office of Student Affairs.
