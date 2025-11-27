# CHAPTER IV
# THE DESIGN OF THE SYSTEM

## System/Software Environment and Description

PRIMOSA, the Project and Resource Information Management System for the Office of Student Affairs of St. Anne College Lucena, Inc., is designed to centralize student affairs operations, resource management, and administrative processes within a unified digital platform. The system provides students, faculty, staff, and OSA personnel with an organized environment where student profiles, institutional events, digital resources, and form submissions can be tracked and managed efficiently.

PRIMOSA enables users to manage comprehensive student records including academic information, contact details, and profile pictures. The system facilitates event coordination through creation, tracking, and status monitoring of institutional activities. Resource management capabilities allow staff to upload, organize, and distribute digital forms such as Statement of Account (SOA), Good Moral Certificate (GTC), and Proof of Delivery (POD), with complete access logging for accountability. Students can submit forms through a structured workflow system with approval tracking, while administrators monitor system usage through an analytics dashboard displaying resource access patterns, user activity, and institutional statistics.

The system is built using modern web technologies including Laravel 11 Framework as the backend foundation with PHP 8.2+, providing robust MVC architecture, built-in authentication, and Eloquent ORM for database operations. MySQL 8.0+ serves as the relational database management system, storing user accounts, student profiles, event records, resource metadata, form submissions, and analytics logs. The frontend utilizes HTML5, CSS3, and JavaScript with Tailwind CSS 3.4 for responsive design, ensuring optimal display across desktop, tablet, and mobile devices. Livewire 3 enables dynamic, reactive interfaces without requiring separate JavaScript frameworks, powering real-time components such as student management tables, event listings, and user administration panels. Laravel Jetstream provides comprehensive authentication features including login, registration, password reset, email verification, and profile management with profile picture upload capabilities.

The system implements a three-tier role-based access control structure distinguishing between Students who access personal profiles, submit forms, and view resources; Faculty and Staff who manage student records, coordinate events, review form submissions, and distribute resources; and Administrators who oversee user management, system configuration, and analytics reporting. Security measures include bcrypt password hashing, CSRF protection, SQL injection prevention through parameterized queries, and granular permission controls. File storage utilizes Laravel's storage system with separate public storage for profile pictures and private storage for sensitive documents with access restrictions.

Through these technologies and architectural decisions, PRIMOSA delivers a secure, responsive, and scalable system designed to enhance the daily operations of the Office of Student Affairs and improve service delivery to the academic community at St. Anne College Lucena, Inc.

## System Architecture

PRIMOSA follows a three-tier architecture consisting of the presentation layer, application layer, and data layer, ensuring separation of concerns and maintainability.

### Presentation Layer

The presentation layer encompasses the user interface components that students, faculty, staff, and administrators interact with directly. This layer is built using HTML5 for semantic markup, CSS3 with Tailwind CSS for responsive styling, and JavaScript with Alpine.js for client-side interactivity. The interface adapts to different screen sizes through responsive design principles, displaying table layouts on desktop devices and card-based layouts on mobile devices for optimal usability. Livewire components provide reactive interfaces that update dynamically without full page reloads, enhancing user experience through real-time feedback and seamless interactions.

### Application Layer

The application layer contains the business logic and processing components implemented through the Laravel 11 framework. This layer handles user authentication and authorization through Laravel Jetstream and Sanctum, processes form submissions and validations, manages file uploads and storage operations, executes database queries through Eloquent ORM, implements role-based access control logic, generates analytics and reports, and coordinates workflow processes for form approvals. The MVC architecture separates concerns with Models representing data structures and database interactions, Views rendering the user interface, and Controllers managing request handling and response generation.

### Data Layer

The data layer consists of the MySQL 8.0+ database system storing all persistent data. The database schema includes tables for users and authentication credentials, student profiles with academic and personal information, events with scheduling and status details, resources with metadata and version information, form submissions with approval workflows, access logs for analytics tracking, and role and permission definitions. Database relationships are established through foreign keys ensuring referential integrity, while indexes on frequently queried columns optimize performance. Laravel's migration system manages schema versioning and ensures consistent database structure across development, testing, and production environments.

## Database Design

The database design follows normalization principles up to the third normal form (3NF) to eliminate redundancy and ensure data integrity.

### Core Tables

The users table stores authentication credentials including email, hashed password, and account status, along with timestamps for account creation and last update. The student_profiles table contains comprehensive student information including student ID, first name, middle name, last name, birth date, gender, address, contact number, email, course, year level, section, enrollment status, department or cluster, emergency contact information, medical information, and profile picture path, with a foreign key relationship to the users table.

The events table manages institutional activities with fields for title, description, start date, end date, venue, event type, status (upcoming, ongoing, completed), and creator information. The resources table stores digital form metadata including form type (SOA, GTC, POD), form name, file path, version number, upload date, and uploader information. The form_submissions table tracks student submissions with fields for student ID, form type, submission date, file path, status (pending, approved, rejected), reviewer ID, review date, and comments.

### Supporting Tables

The roles table defines user roles (student, faculty-staff, administrator) with associated permissions. The permissions table specifies granular access rights (canView, canEdit, canDelete, canManageUsers). The role_user pivot table establishes many-to-many relationships between users and roles. The resource_access_logs table records all resource interactions including user ID, resource ID, action type (view, download, preview, upload), timestamp, and IP address for analytics and accountability purposes.

### Relationships

Database relationships are established through foreign key constraints ensuring referential integrity. A user has one student profile, while a student profile belongs to one user. A user can have multiple roles through the role_user pivot table. Events are created by users, establishing a one-to-many relationship. Form submissions belong to students and may be reviewed by staff members. Resource access logs reference both users and resources, tracking all interactions for analytics purposes.

## User Interface Design

The user interface design prioritizes usability, accessibility, and responsive behavior across devices.

### Layout Structure

The system employs a dashboard layout with a collapsible sidebar navigation on the left, a header bar at the top displaying the page title, and a main content area occupying the remaining space. The sidebar contains navigation links organized by user role, with students seeing options for profile, submissions, and documents, while faculty and staff access student management, event management, form submissions, and resources, and administrators additionally access user management and analytics. The sidebar footer displays user information including profile picture or initial avatar, name, and email, along with links to settings and logout functionality. The sidebar can be collapsed to an icon-only view on desktop, expanding to full width on mobile devices through a hamburger menu.

### Responsive Design

The interface implements mobile-first responsive design with breakpoints at 640px (small devices), 768px (tablets), and 1024px (desktops). On mobile devices, data tables transform into card layouts displaying information in a vertical format with clear labels and touch-friendly buttons. Navigation adapts with the sidebar hidden by default and accessible through a hamburger menu icon. Form inputs and buttons are sized appropriately for touch interaction. On desktop devices, tables display in traditional grid format with sortable columns and inline actions. The sidebar remains visible with full navigation labels. Multiple columns are utilized for forms and content layouts to maximize screen space.

### Component Design

Common UI components maintain consistent styling throughout the system. Buttons follow a color-coded scheme with blue for primary actions, yellow for edit operations, red for delete or deactivate actions, and green for approve or activate actions. Forms utilize Tailwind CSS styling with clear labels, validation feedback, and error messages displayed inline. Data tables feature alternating row colors, hover effects, sortable columns, and pagination controls. Cards display summary information with icons, statistics, and action buttons. Modals present confirmation dialogs and detailed forms with backdrop overlays and smooth transitions.

### Accessibility Considerations

The interface incorporates accessibility features including semantic HTML5 elements for proper document structure, ARIA labels for screen reader compatibility, keyboard navigation support for all interactive elements, sufficient color contrast ratios meeting WCAG guidelines, and clear focus indicators for keyboard users. Form inputs include associated labels and error messages, while images contain descriptive alt text.

## Security Design

Security is implemented through multiple layers protecting data confidentiality, integrity, and availability.

### Authentication Security

User authentication employs bcrypt hashing algorithm for password storage with a cost factor of 10, ensuring computational difficulty for brute-force attacks. Laravel Jetstream provides secure login, registration, and password reset flows with email verification requirements. Session management uses secure, HTTP-only cookies preventing JavaScript access and reducing XSS attack vectors. Two-factor authentication support is available for enhanced account security. Password policies enforce minimum length and complexity requirements.

### Authorization Security

Role-based access control restricts system features based on user roles and permissions. Middleware guards protect routes ensuring only authorized users access specific functionalities. Permission checks occur at both the controller and view levels, preventing unauthorized actions. Students can only access their own profiles and submissions, while staff can manage multiple student records within their authorization scope. Administrators have elevated privileges with audit logging of sensitive operations.

### Data Security

SQL injection prevention is achieved through Eloquent ORM's parameterized queries and prepared statements. Cross-Site Request Forgery (CSRF) protection validates all state-changing requests through token verification. Cross-Site Scripting (XSS) prevention sanitizes user inputs and escapes output in views. File upload validation restricts allowed file types, sizes, and performs virus scanning where applicable. Sensitive data such as passwords and personal information are encrypted at rest and in transit through HTTPS.

### Audit and Logging

The system maintains comprehensive audit logs recording user authentication attempts, resource access activities, form submission and approval actions, user management operations, and system configuration changes. Logs include timestamps, user identifiers, IP addresses, and action details for accountability and forensic analysis. Analytics logs track resource usage patterns while maintaining user privacy through aggregated reporting.

## System Features and Functionality

PRIMOSA provides comprehensive features organized by user role and functional area.

### Student Profile Management

Faculty and staff can create new student profiles by entering personal information including name, student ID, birth date, gender, and contact details, along with academic information such as course, year level, section, and department or cluster. Profile pictures can be uploaded and displayed throughout the system. Student records are searchable and filterable by department, course, and year level. Profile editing allows updates to contact information, academic status, and enrollment status. Account activation and deactivation controls student access to the system. Document management associates files with student profiles for organized record keeping.

### Event Management

Authorized users can create institutional events by specifying title, description, start and end dates, venue, and event type. Event status tracking monitors whether events are upcoming, ongoing, or completed. The event listing displays all events with filtering and sorting capabilities. Event details can be edited by authorized personnel, while deletion removes events from the system with confirmation prompts. Students and staff can view event information to stay informed about institutional activities.

### Resource Management

Staff members upload digital forms including SOA, GTC, and POD documents with descriptive names and version information. Resources are organized by form type for easy navigation. Preview functionality allows users to view documents before downloading. Download tracking logs all resource access for analytics purposes. Version control maintains historical versions of updated forms. Access permissions ensure only authorized users can upload or modify resources while students can view and download available forms.

### Form Submission System

Students select the appropriate form type and upload completed documents through the submission interface. Submission status tracking displays whether forms are pending review, approved, or rejected. Staff members review submitted forms, viewing student information and uploaded documents. Approval workflow allows staff to approve submissions with optional comments or reject them with required feedback. Email notifications inform students of submission status changes. Submission history provides a complete record of all student submissions with timestamps and reviewer information.

### User Management

Administrators create user accounts specifying name, email, and role assignment. Role-based access control assigns users to student, faculty-staff, or administrator roles with corresponding permissions. Account activation and deactivation controls user access without deleting records. User listing displays all accounts with filtering by role and status. Profile editing allows administrators to update user information and reset passwords when necessary. Permission management assigns granular access rights to roles controlling feature availability.

### Analytics and Reporting

The analytics dashboard displays summary statistics including total views, downloads, previews, and uploads of resources. Top users by access frequency are identified for engagement analysis. Most accessed forms and resources are highlighted to inform resource allocation decisions. Recent activity timeline shows system usage patterns with filtering by date range, form type, and action type. CSV export functionality generates reports for external analysis and institutional reporting requirements. Real-time statistics display current system status including active users, pending submissions, and upcoming events.

## System Workflow

Key workflows illustrate how users interact with the system to accomplish common tasks.

### Student Registration Workflow

The process begins when an administrator or staff member creates a new user account by entering the student's email address and generating initial credentials. The system sends an email verification link to the student's email address. Upon receiving the email, the student clicks the verification link and sets their password following security requirements. After successful authentication, the student completes their profile by uploading a profile picture and verifying personal information. The staff member then associates the user account with a student profile containing academic details. Once the profile is complete and verified, the student gains full access to system features including form submissions and resource downloads.

### Form Submission and Approval Workflow

A student logs into the system and navigates to the form submission section. The student selects the desired form type from available options such as SOA, GTC, or POD. After completing the form offline, the student uploads the document file through the submission interface. The system validates the file type and size, then stores the submission with a pending status. Staff members receive notification of the new submission and access the review queue. A staff member opens the submission, views the student information and uploaded document, and evaluates the submission for completeness and accuracy. If approved, the staff member marks the submission as approved with optional comments, and the student receives an email notification of approval. If rejected, the staff member provides detailed feedback explaining required corrections, and the student receives notification to resubmit with corrections.

### Resource Access Workflow

A user logs into the system and navigates to the resource management section. The system displays available resources organized by form type based on the user's role and permissions. The user browses or searches for the desired resource using filters for form type and name. Upon selecting a resource, the user can preview the document in the browser to verify it is the correct form. If the user chooses to download, the system logs the access including user ID, resource ID, action type, timestamp, and IP address. The file is then delivered to the user's device for offline use. All access activities are recorded in the analytics system for reporting and accountability purposes.

### Event Creation and Management Workflow

An authorized staff member or administrator navigates to the event management section and initiates event creation. The user enters event details including title, description, start date, end date, venue, and event type. Upon submission, the system validates the information and creates the event record with an initial status of upcoming. The event appears in the event listing visible to all users based on their permissions. As the event date approaches, staff can update the status to ongoing when the event begins. After completion, the status is changed to completed for historical record keeping. Throughout the event lifecycle, authorized users can edit event details or delete events if necessary, with all changes logged for audit purposes.

This comprehensive system design ensures PRIMOSA effectively supports the Office of Student Affairs in managing student records, coordinating events, distributing resources, and processing form submissions while maintaining security, usability, and scalability.
