# CHAPTER V

# SUMMARY OF FINDINGS, CONCLUSIONS, AND RECOMMENDATIONS

The development of PRIMOSA: Project Resource and Information Management for the Office of Student Affairs became essential as students, faculty, and OSA staff needed a centralized, efficient system to manage resources, coordinate events, and track usage analytics. PRIMOSA serves as the institutional resource management platform attending to the needs of document distribution, event coordination, and data-driven decision-making. Using a web-based interface with role-based access control, the system provides comprehensive functionality that greatly contributes to the operational efficiency, accessibility, and insights of the Office of Student Affairs at St. Anne College Lucena.

The methodology used to build the system was Agile Methodology with Iterative Framework, as it is most suitable for developing complex web applications that require continuous refinement and user feedback integration. With the help of UML Diagrams, the functionality and interactions between users and the system are clearly defined using use-case diagrams, activity diagrams, sequence diagrams, and deployment diagrams. The platform used to create the system was Laravel 12 framework coupled with PHP 8.2+ programming language, Livewire 3 for reactive components, Tailwind CSS for responsive design, and MySQL for database management. Evaluating the system software was based on the ISO Standard 25010 criteria.

---

## Summary of Findings

The Office of Student Affairs at St. Anne College Lucena faced challenges in managing resources, distributing documents, coordinating events, and tracking usage patterns. Manual processes and fragmented systems resulted in inefficiencies, limited accessibility, and difficulty in making data-driven decisions. PRIMOSA was developed to address these challenges by providing a unified, web-based platform accessible to students, faculty, and administrators. From the data gathered, the following findings were derived:

### 1. Requirements Analysis and Data Gathering

Through the use of observation, interviews, document analysis, and research as part of the data gathering techniques, the proponents were able to articulate the core requirements needed to develop the system. The following needs were identified:

**Resource Management Requirements:**
- Centralized storage and distribution of OSA forms (SOA, GTC, POD)
- Document preview and download capabilities for all users
- Upload functionality for Faculty/Staff to manage resources
- File validation and security controls
- Organized categorization by form type

**Analytics and Reporting Requirements:**
- Automated activity logging for all resource interactions
- Real-time dashboard displaying usage statistics
- Filtering capabilities by form type, date range, and time period
- Export functionality for external analysis
- Top users and most accessed resources reports

**Event Management Requirements:**
- Event creation and management tools for Faculty/Staff
- Event categorization and status tracking
- Centralized calendar and listing views
- Detailed event information display
- Student access to view upcoming events

**User Management Requirements:**
- Role-based access control (Students, Faculty/Staff, Administrators)
- Secure authentication with session management
- Profile management with photo upload
- User account creation and management for administrators
- Permission-based feature access

### 2. System Design and Architecture

To elucidate the functionality and interactions of the system, the Unified Modeling Language (UML) was applied as a tool to design the logical and physical architecture. The following diagrams were developed:

**Use Case Diagram:**
- Illustrated interactions between three user roles (Students, Faculty/Staff, Administrators) and system features
- Defined access levels and permissions for each role
- Showed relationships between actors and use cases

**Activity Diagrams:**
- Document Upload Process: Showed the workflow from user authentication through file validation, storage, and activity logging
- User Login Process: Demonstrated authentication flow with CSRF validation, password verification, and session creation
- Event Creation Process: Illustrated form validation, database transaction handling, and response generation
- Analytics Viewing and Export: Depicted data retrieval, filtering, and CSV export processes

**Sequence Diagrams:**
- User Login Process: Detailed interactions between User, Browser, Laravel, Jetstream, Database, and Session components
- Document Upload: Showed communication between User, Browser, Controller, Validator, Storage, Database, and Logger
- Analytics Report Generation: Illustrated the flow from request to data query, processing, and CSV export

**Deployment Diagram:**
- Showed the cloud-based hosting architecture with cPanel web server
- Illustrated client devices, web server layer, application layer, storage layer, and database layer
- Defined external services including email server and backup service

### 3. Development Platform and Methodology

As a development platform, the following technologies and methodologies were employed:

**Backend Technologies:**
- Laravel 12 Framework as the core application framework
- PHP 8.2+ as the primary programming language
- MySQL 8.0+ for relational database management
- Eloquent ORM for database interactions
- Laravel Jetstream for authentication scaffolding
- Laravel Sanctum for API token authentication
- Livewire 3 for reactive, dynamic components

**Frontend Technologies:**
- HTML5, CSS3, and JavaScript for core web technologies
- Tailwind CSS 3.4 for responsive, utility-first styling
- Alpine.js for client-side interactivity
- Vite 6.2 for modern asset compilation and hot module replacement
- Blade templating engine for server-side rendering

**Development Tools:**
- Visual Studio Code as the primary code editor
- Git and GitHub for version control and collaboration
- Composer for PHP dependency management
- NPM for JavaScript package management
- Laravel Pail for real-time log monitoring
- PHPUnit for automated testing

**Methodology:**
- Agile Methodology with Iterative Framework was used as the development approach
- Iterative cycles allowed for continuous refinement based on testing and feedback
- MVC (Model-View-Controller) architectural pattern ensured organized code structure
- Three-tier architecture (Presentation, Application, Data layers) provided clear separation of concerns

### 4. System Evaluation and Testing

With the help of evaluation and testing based on ISO Standard 25010 criteria, the proponents were able to assess whether the software met quality standards. The evaluation covered the following quality characteristics:

**Functional Suitability:**
- The system successfully meets the specific needs of Students, Faculty/Staff, and Administrators
- All features function as intended for their respective user roles
- The system provides accurate and timely information (forms, events, analytics)
- Resource management, analytics, event management, and user management modules operate correctly

**Usability:**
- Users find the system easy to use and understand
- The interface is intuitive with clear navigation
- Error prevention mechanisms (validation, confirmation dialogs) protect users from mistakes
- The responsive design works well across desktop, tablet, and mobile devices
- Users can accomplish their objectives efficiently

**Performance Efficiency:**
- Pages load quickly with minimal delay
- The system handles multiple concurrent users effectively
- Database queries are optimized for fast data retrieval
- File uploads and downloads process efficiently
- Performance remains consistent even with large datasets

**Compatibility:**
- The system functions correctly on various devices (desktop, laptop, tablet, smartphone)
- Compatible with major web browsers (Chrome, Firefox, Safari, Edge)
- The interface and database exchange information effectively
- The system coexists with operating system functions (authentication, file downloads)

**Reliability:**
- The system is consistently available and ready for use
- Features work reliably across different tasks and workflows
- The system continues to function despite minor issues
- Data integrity is maintained through proper validation and transaction handling

**Security:**
- User authentication is secure with session management
- Role-based access control properly restricts features based on user roles
- Uploaded documents are protected from unauthorized access
- CSRF protection prevents cross-site request forgery attacks
- Password hashing ensures credential security

**Maintainability:**
- The system code is organized and follows Laravel best practices
- The modular architecture makes it easy to identify and modify specific features
- The system behaves consistently across different operations
- Clear documentation supports future maintenance and updates

**Portability:**
- The web-based system can be accessed from different types of devices
- No special software installation is required (only a web browser)
- The system works seamlessly across various operating systems
- Cloud-based deployment enables easy access from anywhere with internet connectivity

**Evaluation Results:**
Based on the responses and feedback collected from students, faculty, staff, and administrators, the following conclusions were drawn:

- The content and functionality of the system are accurate and useful for OSA operations
- The system delivers data quickly and efficiently
- Users appreciate the centralized access to resources and the analytics capabilities
- Students find the self-service features helpful and time-saving
- Faculty/Staff value the upload functionality and analytics dashboard
- Administrators appreciate the comprehensive user management and system oversight capabilities
- The system is viewed as a significant improvement over previous manual processes
- Users are eager to see the system expanded with additional features and broader scope

---

## Conclusions

Based on the findings of the study, the following conclusions were drawn:

### 1. Requirements Gathering and Analysis

From the gathered data through the use of interviews, observations, document analysis, and research, comprehensive information was collected to conceptualize the requirements for all beneficiaries. The data gathering process successfully identified:

- The need for centralized resource management to replace fragmented manual processes
- The importance of analytics and reporting for data-driven decision-making
- The requirement for structured event management to improve coordination
- The necessity of role-based access control to ensure security and appropriate feature access
- The demand for a user-friendly, accessible interface that works across devices

The requirements analysis phase provided a solid foundation for system design and development, ensuring that PRIMOSA addresses real needs and delivers tangible value to the Office of Student Affairs.

### 2. System Design and Visualization

Utilizing UML diagrams such as use case, activity, sequence, and deployment diagrams, a clear visual representation of the system architecture was developed. These diagrams served multiple purposes:

- **Use Case Diagrams** clearly defined the interactions between different user roles and system features, establishing access levels and permissions
- **Activity Diagrams** illustrated the step-by-step workflows for key processes, showing how User, Client (Browser), and Server components interact
- **Sequence Diagrams** detailed the temporal sequence of interactions between system components, clarifying the flow of data and control
- **Deployment Diagram** showed the physical architecture and hosting environment, defining how the system is deployed in a real-world setting

These visual representations facilitated communication among stakeholders, guided the development process, and provided documentation for future maintenance and enhancements. The diagrams helped ensure that all team members had a shared understanding of system functionality and architecture.

### 3. Technology Selection and Development

The software tools and technologies used to design and develop PRIMOSA were carefully selected to ensure a robust, scalable, and maintainable system:

**Laravel 12 Framework** provided a solid foundation with built-in features for routing, authentication, database management, and security. The framework's MVC architecture promoted organized code structure and separation of concerns.

**PHP 8.2+** offered modern language features, improved performance, and strong type safety, making the codebase more reliable and maintainable.

**Livewire 3** enabled the creation of reactive, dynamic interfaces without leaving PHP, simplifying development and reducing the need for complex JavaScript frameworks.

**Tailwind CSS** facilitated rapid development of a responsive, mobile-friendly interface with consistent styling across all pages.

**MySQL** provided reliable, efficient data storage with strong support for complex queries and relationships.

The **Agile Methodology with Iterative Framework** served as an effective guide throughout the development process. The iterative approach allowed for:
- Continuous refinement based on testing and feedback
- Flexibility to adapt to changing requirements
- Regular delivery of working features
- Early identification and resolution of issues
- Incremental progress toward project goals

The combination of modern technologies and agile methodology enabled the successful development of a fully-functional, production-ready system that meets the defined requirements.

### 4. System Quality and User Acceptance

The results of the evaluation and testing based on ISO Standard 25010 criteria revealed that PRIMOSA successfully meets quality standards across all evaluated characteristics:

**Functional Suitability:** The system provides all required features and functions correctly for all user roles.

**Usability:** Users find the system easy to use, intuitive, and satisfying to interact with.

**Performance Efficiency:** The system responds quickly and handles data efficiently without performance degradation.

**Compatibility:** The system works correctly across different devices, browsers, and operating systems.

**Reliability:** The system is consistently available and functions reliably across different tasks.

**Security:** The system properly protects user data and restricts access based on roles.

**Maintainability:** The system is well-organized and can be easily maintained and updated.

**Portability:** The system is accessible from various devices without special software requirements.

From the feedback gathered from students, faculty, staff, and administrators, it can be concluded that PRIMOSA is a valuable tool that:
- Significantly improves resource accessibility and distribution
- Reduces administrative workload through automation
- Provides valuable insights through analytics and reporting
- Enhances event coordination and student engagement
- Delivers a positive user experience across all user roles

The system has been well-received by all stakeholders and is viewed as a significant improvement over previous manual processes. Users have expressed enthusiasm for the system and have provided constructive suggestions for future enhancements.

---

## Recommendations

From the drawn conclusions, the following recommendations are proposed to further enhance the functionality, usability, and impact of PRIMOSA:

### 1. Expand System Scope and Features

**Recommendation:** Future researchers and developers should expand the scope of PRIMOSA to include additional OSA functions and services not currently covered in the system.

**Suggested Enhancements:**
- **Student Records Management:** Integrate student profile management with academic records, disciplinary records, and participation history
- **Scholarship Management:** Add modules for scholarship application, tracking, and disbursement
- **Counseling Services:** Include appointment scheduling and session tracking for OSA counseling services
- **Student Organization Management:** Provide tools for managing student organizations, memberships, and activities
- **Feedback and Surveys:** Implement feedback collection and survey tools to gather student input
- **Announcement System:** Add a comprehensive announcement and notification system for OSA communications

**Rationale:** Expanding the system scope will increase its value and utility, making it a more comprehensive solution for all OSA operations.

### 2. Implement Real-Time Notifications and Alerts

**Recommendation:** Future developers should implement a real-time notification system to keep users informed of important updates and events.

**Suggested Features:**
- Email notifications for form submissions, approvals, and status changes
- Browser push notifications for urgent announcements
- SMS notifications for critical updates (optional)
- In-app notification center showing recent activity
- Customizable notification preferences for users
- Automated reminders for upcoming events and deadlines

**Rationale:** Real-time notifications will improve communication, increase user engagement, and ensure that important information reaches users promptly.

### 3. Enhance Analytics with Data Visualization

**Recommendation:** Future researchers should enhance the analytics module by integrating advanced data visualization tools and charts.

**Suggested Enhancements:**
- **Chart.js Integration:** Implement interactive charts and graphs for visual data representation
- **Dashboard Widgets:** Create customizable dashboard widgets for different metrics
- **Trend Analysis:** Add trend lines and comparative analysis over time periods
- **Predictive Analytics:** Implement basic predictive models for resource demand forecasting
- **Custom Reports:** Allow administrators to create custom reports with selected metrics
- **Automated Report Scheduling:** Enable scheduled generation and distribution of reports

**Rationale:** Visual data representation makes analytics more accessible and actionable, enabling better decision-making and insights.

### 4. Develop Mobile Applications

**Recommendation:** Future researchers should develop native mobile applications for Android and iOS platforms to complement the web-based system.

**Suggested Features:**
- Native mobile apps with optimized performance
- Offline mode for viewing previously accessed resources
- Push notifications for mobile devices
- Mobile-optimized interface and navigation
- Camera integration for document scanning and upload
- Biometric authentication (fingerprint, face recognition)

**Rationale:** Native mobile applications will provide a better user experience on mobile devices, increase accessibility, and enable features not possible in web browsers.

### 5. Integrate with Existing Institutional Systems

**Recommendation:** Future developers should integrate PRIMOSA with existing institutional systems to create a seamless ecosystem.

**Suggested Integrations:**
- **Student Information System (SIS):** Sync student data and academic records
- **Learning Management System (LMS):** Connect with course materials and assignments
- **Library System:** Integrate library resources and borrowing records
- **Financial System:** Link with billing, payments, and financial aid
- **Email System:** Integrate with institutional email for seamless communication
- **Single Sign-On (SSO):** Implement SSO for unified authentication across systems

**Rationale:** System integration will eliminate data silos, reduce redundant data entry, and provide a more cohesive user experience.

### 6. Implement Advanced Search and Filtering

**Recommendation:** Future researchers should enhance the search and filtering capabilities throughout the system.

**Suggested Features:**
- Global search functionality across all modules
- Advanced filtering options with multiple criteria
- Search history and saved searches
- Auto-complete and suggestions
- Full-text search in documents (if feasible)
- Tag-based organization and filtering

**Rationale:** Enhanced search and filtering will improve user efficiency and make it easier to find specific information quickly.

### 7. Add Collaboration and Communication Tools

**Recommendation:** Future developers should integrate collaboration and communication features to facilitate teamwork and interaction.

**Suggested Features:**
- **Discussion Forums:** Create forums for students to discuss OSA-related topics
- **Direct Messaging:** Enable private messaging between users (with appropriate controls)
- **Comment System:** Allow comments on events and announcements
- **File Sharing:** Enhance file sharing capabilities with version control
- **Collaborative Editing:** Enable multiple users to work on documents simultaneously (future consideration)

**Rationale:** Collaboration tools will foster community engagement and improve communication within the OSA ecosystem.

### 8. Enhance Security and Privacy Features

**Recommendation:** Future researchers should continuously enhance security measures to protect sensitive data and ensure privacy compliance.

**Suggested Enhancements:**
- **Advanced Audit Logging:** Implement comprehensive audit trails for all sensitive operations
- **Data Encryption:** Encrypt sensitive data at rest and in transit
- **Privacy Controls:** Provide users with granular control over their data and privacy settings
- **Compliance Tools:** Implement features to support data privacy regulations (e.g., GDPR, Data Privacy Act)
- **Security Monitoring:** Add automated security monitoring and alerting
- **Regular Security Audits:** Conduct periodic security assessments and penetration testing

**Rationale:** Enhanced security and privacy features will protect user data, ensure regulatory compliance, and build trust in the system.

### 9. Implement Automated Backup and Disaster Recovery

**Recommendation:** Future developers should implement robust backup and disaster recovery mechanisms to ensure data protection and business continuity.

**Suggested Features:**
- Automated daily backups of database and files
- Off-site backup storage for disaster recovery
- Point-in-time recovery capabilities
- Backup verification and testing procedures
- Documented disaster recovery plan
- Regular backup restoration drills

**Rationale:** Comprehensive backup and disaster recovery measures will protect against data loss and ensure system availability even in the event of failures or disasters.

### 10. Establish a Continuous Improvement Process

**Recommendation:** Future researchers and administrators should establish a formal process for continuous system improvement based on user feedback and usage analytics.

**Suggested Processes:**
- **User Feedback Collection:** Implement in-app feedback forms and regular surveys
- **Usage Analytics Review:** Regularly analyze system usage patterns to identify improvement opportunities
- **Feature Request Management:** Create a system for collecting, prioritizing, and tracking feature requests
- **Regular Updates:** Establish a schedule for regular system updates and enhancements
- **User Training:** Provide ongoing training and support resources for users
- **Performance Monitoring:** Continuously monitor system performance and optimize as needed

**Rationale:** A continuous improvement process will ensure that PRIMOSA evolves to meet changing needs and remains a valuable tool for the Office of Student Affairs.

### 11. Develop Comprehensive Documentation

**Recommendation:** Future researchers should create and maintain comprehensive documentation for users, administrators, and developers.

**Suggested Documentation:**
- **User Manuals:** Detailed guides for students, faculty, and administrators
- **Video Tutorials:** Create video walkthroughs for common tasks
- **Administrator Guide:** Comprehensive documentation for system administration
- **Developer Documentation:** Technical documentation for future developers
- **API Documentation:** If APIs are developed, provide complete API documentation
- **FAQ and Troubleshooting:** Compile frequently asked questions and solutions

**Rationale:** Comprehensive documentation will facilitate user adoption, reduce support burden, and enable future developers to maintain and enhance the system effectively.

### 12. Implement Accessibility Features

**Recommendation:** Future developers should enhance accessibility features to ensure the system is usable by people with disabilities.

**Suggested Features:**
- **Screen Reader Support:** Ensure compatibility with screen readers
- **Keyboard Navigation:** Enable full keyboard navigation without mouse
- **High Contrast Mode:** Provide high contrast themes for visually impaired users
- **Font Size Adjustment:** Allow users to adjust font sizes
- **Alt Text for Images:** Ensure all images have descriptive alt text
- **WCAG Compliance:** Strive for WCAG 2.1 Level AA compliance

**Rationale:** Accessibility features will ensure that PRIMOSA is inclusive and usable by all members of the academic community, regardless of disabilities.

---

## Final Remarks

The development and implementation of PRIMOSA represents a significant advancement in the operational efficiency and service delivery of the Office of Student Affairs at St. Anne College Lucena. The system successfully addresses the challenges of fragmented resource management, manual processes, and limited data visibility by providing a unified, web-based platform that centralizes resource distribution, event coordination, and analytics.

Through careful requirements analysis, thoughtful system design, modern technology selection, and rigorous testing, PRIMOSA has been developed as a robust, user-friendly, and scalable solution that meets the needs of students, faculty, staff, and administrators. The positive feedback from users and the successful evaluation against ISO Standard 25010 criteria confirm that the system delivers tangible value and significantly improves OSA operations.

The recommendations provided in this chapter offer a roadmap for future enhancements that will further increase the system's capabilities, usability, and impact. By implementing these recommendations, future researchers and developers can build upon the solid foundation established by PRIMOSA and create an even more comprehensive and valuable system for the Office of Student Affairs.

PRIMOSA demonstrates the power of technology to transform administrative processes, improve service delivery, and enhance the student experience. As the system continues to evolve and expand, it will play an increasingly important role in supporting the mission of St. Anne College Lucena to provide quality education and comprehensive student support services.

The success of PRIMOSA serves as a model for other departments and institutions seeking to modernize their operations and leverage technology to better serve their stakeholders. By embracing digital transformation and data-driven decision-making, organizations can achieve significant improvements in efficiency, effectiveness, and stakeholder satisfaction.

---

**End of Chapter V**
