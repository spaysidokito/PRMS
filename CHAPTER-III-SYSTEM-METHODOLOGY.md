# CHAPTER III
# SYSTEM/SOFTWARE PROJECT METHODOLOGY

Managing student affairs operations has become increasingly complex in academic institutions, particularly at St. Anne College Lucena, Inc. OSA staff juggle multiple responsibilities including event coordination, student records management, and compliance reporting - often using disjointed systems that create workflow inefficiencies. This fragmentation leads to delayed services, communication gaps, and difficulty tracking institutional data.

While various management systems exist, most fail to address the specific needs of Philippine student affairs offices. Personnel frequently combine generic tools like spreadsheets, messaging apps, and paper forms - a practice that consumes valuable time and risks data inconsistency. PRIMOSA is designed to integrate these critical functions into a unified platform tailored for OSA's operational requirements.

This project proposes the development of PRIMOSA, a web-based Project and Resource Information Management System for the Office of Student Affairs, to address these challenges. The system aims to integrate essential functionalities into a unified platform that facilitates efficient student profile management, event coordination, resource distribution, form submission workflows, and data-driven decision-making. Designed specifically for St. Anne College Lucena, Inc., PRIMOSA seeks to enhance the management of student records, administrative tasks, and institutional resources.

## System/Software Development Method Used

The Agile methodology is the approach implemented for the System Development Life Cycle (SDLC) of the PRIMOSA project. Agile is an iterative and flexible software development model that emphasizes continuous collaboration with stakeholders, rapid delivery of functional components, and responsiveness to changing requirements. Instead of following a strict linear sequence, Agile breaks down development into smaller, manageable increments called sprints, allowing regular feedback, adaptation, and improvement at every stage.

Agile was selected for PRIMOSA because it is particularly well-suited for academic systems, where stakeholder needs—such as those of students, faculty, and administrative staff—may evolve throughout the project. The methodology promotes early and continuous delivery of valuable features, ensuring that the system grows based on actual user input rather than assumptions. By involving stakeholders in frequent review sessions, the development team can promptly identify necessary refinements and adjustments, helping ensure that PRIMOSA remains aligned with the goals of the Office of Student Affairs at St. Anne College Lucena, Inc.

Through Agile, the project follows a cycle of planning, development, testing, and feedback for each sprint, enabling the system to improve iteratively while maintaining momentum toward full deployment. This flexible and user-focused approach maximizes the relevance, quality, and usability of PRIMOSA upon completion.

## Planning Phase

The project began by identifying the current challenges faced by the Office of Student Affairs at St. Anne College Lucena, Inc. in managing student records, coordinating events, distributing resources, and processing form submissions. Existing systems were evaluated and determined inadequate for their specific needs, often requiring multiple platforms and resulting in inefficiencies, information silos, and administrative overhead. The PRIMOSA project was proposed to unify these fragmented systems into a comprehensive platform designed to streamline student affairs operations, enhance collaboration between staff and students, and improve institutional efficiency.

## Requirements Analysis

During this phase, detailed insights were gathered from students, faculty, and administrative staff through surveys and interviews to understand their challenges in student affairs management. Current applications were assessed to identify their limitations, and essential features were outlined for the new system. Requirements were prioritized based on complexity and institutional impact, with sprint objectives aligned to project goals. This process ensured that the system's foundation addresses actual user needs while remaining adaptable through Agile development practices.

### Objectives of the System

PRIMOSA aims to provide educational stakeholders with a centralized platform for managing student affairs operations efficiently. The system features comprehensive student profile management with profile pictures, academic information including student ID, course, year level, and department/cluster, along with contact details and document management capabilities. Event management functionality enables the creation, tracking, and management of institutional events with status monitoring for upcoming, ongoing, and completed events, including venue information and date tracking. Resource management provides digital forms such as SOA, GTC, and POD with upload, preview, download, and version control capabilities, complemented by access logging for analytics purposes. The form submission system facilitates student form submissions with approval workflows, status tracking for pending, approved, and rejected submissions, and reviewer assignment features. User management implements role-based access control for students, faculty/staff, and administrators with account activation and deactivation capabilities. Analytics and reporting features include resource access tracking, user activity monitoring, data visualization, and CSV export functionality for institutional reporting. Document management ensures secure storage and retrieval of student documents with organized categorization. The system is designed with a responsive interface accessible across desktop, tablet, and mobile devices, reducing administrative burden and improving institutional decision-making through data-driven insights.

## Analysis and Design Phase

Following requirement gathering, the features needed for the system were analyzed. Additional consultations with faculty and administrative staff guided decisions on how the system can best serve its users. The system's architecture was structured through visual diagrams including use case diagrams and activity diagrams to illustrate workflows and interactions. This ensured all functionalities were properly mapped before development began, establishing a solid foundation for implementation.

### Models

The Unified Modeling Language (UML), a standardized visual modeling language, was utilized to design and represent the structure and behavior of the PRIMOSA system.

#### Use Case Diagram
The use case diagram illustrates the main actors and their interactions with the PRIMOSA system. The three primary actors are Students, Faculty/Staff, and Administrators, each with distinct access levels and capabilities. The diagram encompasses seven core use cases: Student Management, which includes viewing, creating, editing, and deactivating student profiles; Event Management for creating, viewing, editing, and deleting institutional events; Resource Management covering the upload, viewing, downloading, and previewing of forms; Form Submissions that allow students to submit forms and staff to review and approve or reject them; User Management for creating, editing, and activating or deactivating user accounts; Analytics for viewing statistics, exporting reports, and tracking system activity; and Profile Management enabling users to update their profiles, change passwords, and upload profile photos.

#### Activity Diagram
The activity diagram maps the workflows for key processes within the system. The student registration flow begins with account creation, proceeds to profile setup, continues with document upload, and concludes with verification. The form submission process follows a sequence of form selection, filling in details, uploading the required file, submitting the form, undergoing review, and receiving either approval or rejection. The event creation workflow involves entering event details, assigning a venue, setting dates, and managing the event status. The resource access flow starts with user login, proceeds to browsing available resources, allows for preview or download actions, and ends with activity logging for analytics purposes.

#### Sequence Diagram
The sequence diagram details the interaction flow between system components for critical operations. The user authentication sequence demonstrates the flow from login through validation to session creation. The form submission sequence illustrates the path from student submission through the system and database to staff review and final approval decision. The resource download sequence shows the progression from user request through authorization and file retrieval to activity logging. The analytics generation sequence depicts the process from query initiation through data aggregation to final visualization of results.

#### Deployment Diagram
The deployment diagram shows the system architecture and infrastructure components. The web server layer utilizes Apache or Nginx to serve the Laravel application. The application server runs PHP 8.2+ runtime with the Laravel 11 framework handling business logic and request processing. The database server employs MySQL 8.0+ for data persistence and management. File storage is implemented through local or cloud storage solutions for uploaded documents and resources. The client layer consists of web browsers including Chrome, Firefox, Safari, and Edge, accessible on both desktop and mobile devices.

## Implementation Phase

The system was developed using modern web development tools and frameworks. The front-end was built with responsive design principles to ensure accessibility across devices. The back-end utilizes robust database management and secure authentication systems. The project followed Agile methodology, allowing continuous incorporation of feedback and system improvement through iterative sprints, ensuring that PRIMOSA evolved to meet institutional needs effectively.

## Testing Phase

Once the initial version of the system was developed, it underwent comprehensive functionality and integration testing. Selected stakeholders from different departments tested the application in real-world scenarios to identify any issues or usability concerns. This process ensured that the system performs as expected and that necessary refinements were implemented before deployment.

## Deployment Phase

After the testing phase was completed and initial feedback addressed, the system underwent a controlled deployment within selected departments of St. Anne College Lucena, Inc. This phased approach allowed monitoring of the system's performance in a real-world environment and making necessary adjustments based on user experience. During this period, any minor issues, usability gaps, or optimization opportunities were identified and resolved. This controlled deployment strategy helped ensure the system's stability and readiness before full institutional implementation.

## Evaluation Phase

Following deployment, the system's overall quality, usability, and effectiveness were evaluated. Comprehensive demonstrations were conducted with various stakeholders including students, faculty members, and administrative staff. Feedback was systematically gathered through structured evaluation forms based on the ISO 25010 software quality model, which addresses characteristics such as functional suitability, performance efficiency, compatibility, usability, reliability, security, maintainability, and portability. This standardized approach to quality assessment provided objective metrics for system evaluation while capturing the subjective experiences of different user groups. The collected feedback guided final refinements and improvements to ensure PRIMOSA meets institutional expectations, aligns with educational workflows, and performs reliably across all intended functions.

## Models, Technologies, Tools, and Techniques

This section describes the comprehensive set of concepts, technologies, tools, and methods used to develop and implement the PRIMOSA system.

### Software

The following software applications and platforms were utilized throughout the development and deployment of PRIMOSA:

The development environment utilized XAMPP 8.2.12 as the local development server package, providing Apache web server, MySQL database, and PHP runtime for the Windows development environment. Visual Studio Code served as the primary code editor, equipped with extensions for PHP, Laravel, JavaScript, and database management. Git Bash provided the command-line interface for Git version control operations, while Composer managed dependencies for PHP packages and the Laravel framework. Node.js and NPM handled the JavaScript runtime and package management for frontend dependencies.

For database management, MySQL Workbench was employed as the visual database design and administration tool for schema design and query optimization. phpMyAdmin, included with XAMPP, provided a web-based MySQL administration interface for database management tasks.

Version control and collaboration were facilitated through Git, a distributed version control system for tracking code changes, and GitHub, which served as the cloud-based repository hosting service for code storage and team collaboration.

Testing was conducted across multiple web browsers to ensure compatibility and responsiveness. Google Chrome served as the primary browser for development and testing with its comprehensive DevTools. Mozilla Firefox was used as a secondary browser for cross-browser compatibility testing, while Microsoft Edge provided additional compatibility verification. Mobile browsers including Safari for iOS and Chrome for Android were utilized for mobile responsiveness testing.

Design and documentation tools included Draw.io and Lucidchart for creating UML diagrams such as use case, activity, sequence, and deployment diagrams. Microsoft Word and Google Docs were used for documentation and report writing, while Markdown editors facilitated the creation of README files and technical documentation.

### Technologies

Visual Studio Code serves as the primary code editor for developing PRIMOSA, offering integrated Git support, debugging tools, and a wide range of extensions for PHP, HTML, CSS, JavaScript, and SQL development.

The backend development utilizes Laravel 11 Framework, a modern PHP framework with elegant syntax, MVC architecture, built-in authentication, ORM (Eloquent), and comprehensive tooling for building the PRIMOSA backend. The system runs on PHP 8.2+, a modern PHP version with improved performance, type safety, and enhanced features. Laravel Jetstream provides the starter kit with authentication scaffolding including login, registration, password reset, email verification, and profile management. Laravel Sanctum implements API token authentication for secure API access. Livewire 3 serves as the full-stack framework enabling dynamic, reactive interfaces without writing JavaScript, used for real-time components like student management tables, event management, and user management.

Database management employs MySQL 8.0+, a reliable and widely-used relational database management system that stores and manages PRIMOSA's structured data including user accounts and authentication data, student profiles with academic information, event records and attendance tracking, resource metadata and access logs, form submissions and approval workflows, document references and file metadata, and analytics and activity logs. Eloquent ORM provides Laravel's database abstraction layer with elegant, object-oriented database interactions including relationships, query building, and data validation. Database migrations enable version-controlled database schema management ensuring consistent database structure across environments. Database indexing optimizes frequently queried fields such as student_id, user_id, and email for improved performance.

Frontend technologies include HTML5, CSS3, and JavaScript as the core web technologies for building the user interface. Tailwind CSS 3.4 provides a utility-first CSS framework with responsive, mobile-first design and custom color schemes matching institutional branding. Alpine.js, integrated via Livewire, offers a lightweight JavaScript framework for interactive components like dropdowns, modals, and dynamic forms. Vite 6 serves as the modern build tool for fast development with hot module replacement and optimized production builds. Font Awesome 6 provides the icon library for consistent visual elements throughout the interface. Custom CSS adds additional styling for dashboard layout, sidebar navigation, and component-specific designs. Responsive design implements mobile-optimized layouts with breakpoints for tablets and desktops, featuring card views for mobile and table views for desktop.

Testing tools include PHPUnit 11 for PHP unit and feature tests, Laravel Pail for real-time log monitoring during development, and Mockery as the mocking framework for testing. Version control utilizes Git for tracking code changes and GitHub as the remote repository, facilitating collaboration, code backup, and continuous progress tracking.

Development tools encompass Laravel Sail for Docker-based local development environment, Laravel Pint for code style fixing and consistent formatting, Laravel Tinker as a REPL for interacting with the application, Composer for PHP dependency management, and NPM for JavaScript package management.

Authentication and authorization are handled through Laravel Jetstream, providing a complete authentication system with registration, login, password reset, email verification, profile management with profile picture upload, and two-factor authentication support. Laravel Sanctum manages API authentication for secure token-based access. A custom role-based access control system implements three user roles: Students with access to personal profile, form submissions, document viewing, and event information; Faculty and Staff with access to student management, event management, form submission review, and resource management; and Administrators with full system access including user management, analytics, and system configuration. The permission system provides granular permissions including canView, canEdit, canDelete, and canManageUsers, controlling access to specific features and operations.

Analytics and reporting capabilities include resource access logging, a comprehensive tracking system recording all resource views, downloads, previews, and uploads with timestamps, user information, and IP addresses. The analytics dashboard provides visual representation of system usage including total views, downloads, previews, and uploads statistics, top users by resource access frequency, most accessed forms and resources, and recent activity timeline with filtering capabilities. Export functionality enables CSV export of analytics data for external analysis and reporting. Real-time statistics display live counters for active and inactive accounts, student enrollment status, and event participation.

File storage utilizes Laravel's storage system for secure file storage of uploaded resources and documents. Public storage provides accessible storage for profile pictures and public resources, while private storage ensures secure storage for sensitive documents with access control.

### Techniques

The development of PRIMOSA employed various programming and implementation techniques to ensure system quality, maintainability, and performance.

#### Development Techniques

**Model-View-Controller (MVC) Architecture** was implemented through the Laravel framework, separating business logic (Models), user interface (Views), and application flow control (Controllers). This architectural pattern promotes code organization, reusability, and maintainability throughout the system.

**Object-Oriented Programming (OOP)** principles were applied extensively, utilizing classes, inheritance, encapsulation, and polymorphism to create modular and reusable code components. This approach facilitated the development of maintainable and scalable system features.

**Database Normalization** techniques were employed to design an efficient database schema, eliminating data redundancy and ensuring data integrity. The database structure follows normalization rules up to the third normal form (3NF), optimizing data storage and retrieval operations.

**Responsive Web Design** techniques were implemented using Tailwind CSS's mobile-first approach, ensuring the system adapts seamlessly to different screen sizes and devices. Breakpoint-based layouts provide optimal user experience across desktop, tablet, and mobile platforms.

**Component-Based Development** was utilized through Livewire components, creating reusable UI elements such as data tables, forms, and modals. This modular approach reduced code duplication and improved development efficiency.

#### Security Techniques

**Password Hashing** using bcrypt algorithm ensures secure storage of user credentials, protecting against unauthorized access even in the event of database compromise.

**CSRF Protection** (Cross-Site Request Forgery) is implemented through Laravel's built-in token verification, preventing malicious requests from unauthorized sources.

**SQL Injection Prevention** is achieved through Eloquent ORM's parameterized queries and prepared statements, safeguarding the database from malicious SQL code injection.

**Role-Based Access Control (RBAC)** restricts system features and data access based on user roles and permissions, ensuring users can only access authorized functionalities.

**Input Validation and Sanitization** techniques verify and clean user inputs before processing, preventing security vulnerabilities and data corruption.

#### Testing Techniques

**Unit Testing** was conducted to verify individual components and functions operate correctly in isolation, ensuring code reliability at the smallest level.

**Integration Testing** validated the interaction between different system modules, confirming that components work together as expected.

**Functional Testing** verified that system features meet specified requirements and perform their intended functions correctly.

**User Acceptance Testing (UAT)** involved actual end-users testing the system in real-world scenarios, providing feedback on usability and functionality.

**Cross-Browser Testing** ensured consistent functionality and appearance across different web browsers including Chrome, Firefox, Edge, and Safari.

**Responsive Testing** validated the system's behavior and layout across various screen sizes and devices, from mobile phones to desktop computers.

#### Performance Optimization Techniques

**Database Indexing** was implemented on frequently queried columns to accelerate data retrieval operations and improve system responsiveness.

**Eager Loading** techniques prevent N+1 query problems by loading related data efficiently, reducing database queries and improving page load times.

**Caching Strategies** store frequently accessed data in memory, reducing database load and improving response times for common operations.

**Asset Optimization** through Vite's build process minifies and bundles CSS and JavaScript files, reducing file sizes and improving page load performance.

**Lazy Loading** defers the loading of non-critical resources until needed, improving initial page load times and overall user experience.

## System/Software Evaluation Plan

The evaluation of PRIMOSA follows a comprehensive approach based on the ISO/IEC 25010 Software Quality Model, which provides a standardized framework for assessing software quality characteristics. This evaluation plan ensures systematic assessment of the system's quality, usability, and effectiveness from multiple stakeholder perspectives.

### Evaluation Framework

The ISO/IEC 25010 model defines eight quality characteristics that serve as the foundation for PRIMOSA's evaluation:

**Functional Suitability** assesses whether the system provides functions that meet stated and implied needs when used under specified conditions. This includes evaluating functional completeness (coverage of all specified tasks), functional correctness (provision of correct results), and functional appropriateness (facilitation of task accomplishment).

**Performance Efficiency** evaluates the system's performance relative to the amount of resources used under stated conditions. This encompasses time behavior (response times and processing speeds), resource utilization (amounts and types of resources used), and capacity (maximum limits of system parameters).

**Compatibility** examines the system's ability to exchange information with other systems and perform its required functions while sharing the same environment. This includes co-existence with other software and interoperability with different browsers and devices.

**Usability** measures the extent to which the system can be used by specified users to achieve specified goals with effectiveness, efficiency, and satisfaction. This covers appropriateness recognizability (ease of understanding system capabilities), learnability (ease of learning to use the system), operability (ease of operation and control), user error protection (protection against user errors), user interface aesthetics (pleasing and satisfying interface), and accessibility (usability by people with diverse characteristics).

**Reliability** assesses the system's ability to perform specified functions under specified conditions for a specified period. This includes maturity (meeting reliability needs under normal operation), availability (operational and accessible when required), fault tolerance (operation despite hardware or software faults), and recoverability (recovery of affected data and system state after interruption).

**Security** evaluates the system's protection of information and data so that unauthorized persons or systems cannot read or modify them. This encompasses confidentiality (data accessibility only to authorized users), integrity (prevention of unauthorized modification), non-repudiation (proof of actions or events), accountability (traceability of actions to entities), and authenticity (proof of identity claims).

**Maintainability** measures the effectiveness and efficiency with which the system can be modified by intended maintainers. This includes modularity (composition of discrete components), reusability (use of assets in other systems), analyzability (ease of assessing change impacts), modifiability (ease of modification without defects), and testability (ease of establishing test criteria and conducting tests).

**Portability** assesses the system's ability to be transferred from one environment to another. This covers adaptability (effective adaptation to different environments), installability (ease of installation in specified environments), and replaceability (ability to replace another specified software product).

### Evaluation Methodology

The evaluation process involves multiple phases and diverse participant groups to ensure comprehensive assessment:

**Participant Selection** includes representatives from three primary user groups: students who utilize the system for profile management, form submissions, and resource access; faculty and staff members who manage student records, events, and form approvals; and administrators who oversee system configuration, user management, and analytics. This diverse participant pool ensures evaluation from all relevant perspectives.

**Evaluation Instruments** consist of structured questionnaires based on ISO 25010 quality characteristics, with Likert-scale questions measuring satisfaction levels for each quality attribute. Open-ended questions gather qualitative feedback on user experiences, suggestions, and concerns. System usage logs provide quantitative data on performance metrics, error rates, and feature utilization patterns.

**Evaluation Procedures** begin with system demonstrations conducted for each user group, showcasing relevant features and functionalities. Participants then engage in hands-on testing, performing typical tasks within their role context. Following the testing period, participants complete evaluation questionnaires providing both quantitative ratings and qualitative feedback. System performance metrics are collected automatically throughout the evaluation period.

**Data Analysis** employs both quantitative and qualitative methods. Quantitative analysis calculates mean scores and standard deviations for each quality characteristic, identifies areas of strength and weakness based on rating distributions, and compares results across different user groups. Qualitative analysis examines open-ended responses to identify common themes and concerns, categorizes feedback by quality characteristic and system feature, and prioritizes improvement recommendations based on frequency and severity.

**Reporting and Action** involves compiling comprehensive evaluation reports summarizing findings across all quality characteristics, documenting specific issues and recommendations for improvement, and presenting results to stakeholders and development team. Based on evaluation findings, a prioritized action plan addresses identified issues and implements recommended improvements, followed by validation testing to confirm effectiveness of modifications.

### Success Criteria

The system is considered successful when it achieves minimum threshold scores across all ISO 25010 quality characteristics, typically targeting average ratings of 4.0 or higher on a 5-point Likert scale. Critical functionality must operate without major defects, and user satisfaction levels must meet or exceed institutional expectations. The evaluation results guide final refinements before full-scale deployment, ensuring PRIMOSA meets the quality standards required for effective student affairs management at St. Anne College Lucena, Inc.
