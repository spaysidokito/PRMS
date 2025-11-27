# PRIMOSA Entity-Relationship Diagram (ERD)

## Entities and Relationships

### Core Entities

#### 1. USERS
**Primary Key:** id
**Attributes:**
- id (PK)
- name
- email (UNIQUE)
- email_verified_at
- password
- current_team_id
- profile_photo_path
- is_active
- remember_token
- created_at
- updated_at

**Relationships:**
- One-to-Many with STUDENT_PROFILES (1:1)
- Many-to-Many with ROLES (through role_user)
- One-to-Many with EVENTS (as creator)
- One-to-Many with RESOURCES (as creator)
- One-to-Many with FORM_SUBMISSIONS (as submitter)
- One-to-Many with FORM_SUBMISSIONS (as reviewer)
- One-to-Many with RESOURCE_ACCESS_LOGS

---

#### 2. ROLES
**Primary Key:** id
**Attributes:**
- id (PK)
- name
- slug (UNIQUE)
- created_at
- updated_at

**Relationships:**
- Many-to-Many with USERS (through role_user)

---

#### 3. ROLE_USER (Junction Table)
**Primary Key:** id
**Attributes:**
- id (PK)
- user_id (FK)
- role_id (FK)
- created_at
- updated_at

**Relationships:**
- Many-to-One with USERS
- Many-to-One with ROLES

---

#### 4. STUDENT_PROFILES
**Primary Key:** id
**Attributes:**
- id (PK)
- user_id (FK, UNIQUE)
- student_id (UNIQUE)
- first_name
- last_name
- middle_name
- birth_date
- gender
- address
- contact_number
- email (UNIQUE)
- course
- year_level
- section
- status (active/inactive/graduated/dropped)
- emergency_contact
- medical_information
- department_cluster
- profile_picture
- created_at
- updated_at

**Relationships:**
- One-to-One with USERS
- One-to-Many with FORM_SUBMISSIONS

---

#### 5. EVENTS
**Primary Key:** id
**Attributes:**
- id (PK)
- title
- description
- start_date
- end_date
- venue
- type (social/academic/training/workshop/seminar)
- status (upcoming/ongoing/completed/cancelled)
- max_participants
- budget
- created_by (FK)
- requirements (JSON)
- attachments (JSON)
- created_at
- updated_at
- deleted_at

**Relationships:**
- Many-to-One with USERS (creator)

---

#### 6. RESOURCES
**Primary Key:** id
**Attributes:**
- id (PK)
- title
- description
- type (equipment/venue/document)
- status (available/in-use/maintenance/retired)
- location
- quantity
- cost
- purchase_date
- last_maintenance
- specifications (JSON)
- attachments (JSON)
- created_by (FK)
- created_at
- updated_at
- deleted_at

**Relationships:**
- Many-to-One with USERS (creator)

---

#### 7. RESOURCE_FORMS
**Primary Key:** id
**Attributes:**
- id (PK)
- category (soa/gtc/pod)
- subcategory
- name
- template_filename
- display_order
- is_active
- created_at
- updated_at

**Relationships:**
- Referenced by RESOURCE_ACCESS_LOGS (indirectly through form_type)

---

#### 8. FORM_SUBMISSIONS
**Primary Key:** id
**Attributes:**
- id (PK)
- user_id (FK)
- student_profile_id (FK)
- form_type (soa/gtc/pod)
- file_path
- original_filename
- status (pending/approved/rejected)
- notes
- admin_notes
- reviewed_by (FK)
- reviewed_at
- created_at
- updated_at

**Relationships:**
- Many-to-One with USERS (submitter)
- Many-to-One with STUDENT_PROFILES
- Many-to-One with USERS (reviewer)

---

#### 9. RESOURCE_ACCESS_LOGS
**Primary Key:** id
**Attributes:**
- id (PK)
- user_id (FK)
- form_type (soa/gtc/pod)
- form_name
- action (view/download/preview/upload)
- ip_address
- user_agent
- file_path
- created_at
- updated_at

**Relationships:**
- Many-to-One with USERS

---

## Relationship Summary

### One-to-One Relationships
1. **USERS ↔ STUDENT_PROFILES**
   - One user can have one student profile
   - One student profile belongs to one user

### One-to-Many Relationships
1. **USERS → EVENTS**
   - One user can create many events
   - Each event is created by one user

2. **USERS → RESOURCES**
   - One user can create many resources
   - Each resource is created by one user

3. **USERS → FORM_SUBMISSIONS (as submitter)**
   - One user can submit many forms
   - Each form submission belongs to one user

4. **USERS → FORM_SUBMISSIONS (as reviewer)**
   - One user can review many form submissions
   - Each reviewed form submission has one reviewer

5. **STUDENT_PROFILES → FORM_SUBMISSIONS**
   - One student profile can have many form submissions
   - Each form submission belongs to one student profile

6. **USERS → RESOURCE_ACCESS_LOGS**
   - One user can have many access log entries
   - Each access log entry belongs to one user

### Many-to-Many Relationships
1. **USERS ↔ ROLES** (through role_user junction table)
   - One user can have many roles
   - One role can be assigned to many users

---

## ERD Diagram Notation

```
┌─────────────────────┐
│      USERS          │
├─────────────────────┤
│ PK: id              │
│     name            │
│     email (U)       │
│     password        │
│     is_active       │
│     profile_photo   │
└─────────────────────┘
         │ 1
         │
         │ creates
         ├──────────────────┐
         │                  │
         │ M                │ M
┌────────▼────────┐  ┌──────▼──────────┐
│    EVENTS       │  │   RESOURCES     │
├─────────────────┤  ├─────────────────┤
│ PK: id          │  │ PK: id          │
│ FK: created_by  │  │ FK: created_by  │
│     title       │  │     title       │
│     start_date  │  │     type        │
│     end_date    │  │     status      │
│     venue       │  │     quantity    │
│     type        │  │     location    │
│     status      │  └─────────────────┘
└─────────────────┘

         │ 1
         │ has
         │
         │ 1
┌────────▼──────────────┐
│  STUDENT_PROFILES     │
├───────────────────────┤
│ PK: id                │
│ FK: user_id (U)       │
│     student_id (U)    │
│     first_name        │
│     last_name         │
│     course            │
│     year_level        │
│     department_cluster│
│     status            │
└───────────────────────┘
         │ 1
         │ submits
         │
         │ M
┌────────▼──────────────┐
│  FORM_SUBMISSIONS     │
├───────────────────────┤
│ PK: id                │
│ FK: user_id           │
│ FK: student_profile_id│
│ FK: reviewed_by       │
│     form_type         │
│     file_path         │
│     status            │
│     reviewed_at       │
└───────────────────────┘

┌─────────────────────┐       ┌─────────────────────┐
│      USERS          │   M:M │       ROLES         │
├─────────────────────┤◄─────►├─────────────────────┤
│ PK: id              │       │ PK: id              │
└─────────────────────┘       │     name            │
         │                    │     slug (U)        │
         │ 1                  └─────────────────────┘
         │ logs                        ▲
         │                             │
         │ M                           │ M
┌────────▼──────────────┐              │
│ RESOURCE_ACCESS_LOGS  │              │
├───────────────────────┤              │
│ PK: id                │              │
│ FK: user_id           │              │
│     form_type         │              │
│     action            │              │
│     ip_address        │              │
│     created_at        │              │
└───────────────────────┘              │
                                       │
                              ┌────────┴────────┐
                              │   ROLE_USER     │
                              │  (Junction)     │
                              ├─────────────────┤
                              │ PK: id          │
                              │ FK: user_id     │
                              │ FK: role_id     │
                              └─────────────────┘

┌─────────────────────┐
│  RESOURCE_FORMS     │
├─────────────────────┤
│ PK: id              │
│     category        │
│     subcategory     │
│     name            │
│     template_file   │
│     is_active       │
└─────────────────────┘
```

---

## Cardinality Legend

- **1** = One
- **M** = Many
- **U** = Unique constraint
- **PK** = Primary Key
- **FK** = Foreign Key

---

## Key Constraints

### Foreign Key Constraints

1. **student_profiles.user_id** → users.id (CASCADE DELETE)
2. **role_user.user_id** → users.id (CASCADE DELETE)
3. **role_user.role_id** → roles.id (CASCADE DELETE)
4. **events.created_by** → users.id
5. **resources.created_by** → users.id
6. **form_submissions.user_id** → users.id (CASCADE DELETE)
7. **form_submissions.student_profile_id** → student_profiles.id (SET NULL)
8. **form_submissions.reviewed_by** → users.id (SET NULL)
9. **resource_access_logs.user_id** → users.id (SET NULL)

### Unique Constraints

1. users.email
2. student_profiles.user_id
3. student_profiles.student_id
4. student_profiles.email
5. roles.slug

### Indexes

1. users.is_active
2. student_profiles.student_id
3. student_profiles.department_cluster
4. student_profiles.course
5. student_profiles.year_level
6. resource_access_logs.form_type, action
7. resource_access_logs.created_at

---

## Business Rules

1. Each user must have at least one role (student, faculty/staff, or administrator)
2. Only users with student role can have a student profile
3. Student profiles have a one-to-one relationship with users
4. Events and resources must be created by authenticated users
5. Form submissions can only be created by students
6. Form submissions can only be reviewed by faculty/staff or administrators
7. Resource access logs track all interactions with forms and documents
8. Soft deletes are enabled for events and resources (deleted_at column)
9. User accounts can be activated/deactivated (is_active flag)
10. Student profiles track enrollment status (active/inactive/graduated/dropped)

---

## Notes for ERD Visualization

When creating this ERD in a visual tool (draw.io, Lucidchart, MySQL Workbench):

1. **Use crow's foot notation** for relationships:
   - One: Single line with perpendicular line
   - Many: Single line with crow's foot (three lines)

2. **Color coding suggestion**:
   - User Management: Blue (users, roles, role_user)
   - Student Management: Green (student_profiles)
   - Event Management: Orange (events)
   - Resource Management: Purple (resources, resource_forms)
   - Form Management: Red (form_submissions)
   - Analytics: Yellow (resource_access_logs)

3. **Entity positioning**:
   - Place USERS at the center as it's the core entity
   - Group related entities together
   - Show junction tables between many-to-many relationships

4. **Relationship labels**:
   - Add verbs to relationships (creates, submits, reviews, logs, has)
   - Show cardinality clearly (1:1, 1:M, M:M)

---

## Database Statistics (for documentation)

- **Total Tables:** 9 main tables + 3 system tables (sessions, password_reset_tokens, personal_access_tokens)
- **Total Relationships:** 11 foreign key relationships
- **Junction Tables:** 1 (role_user for many-to-many)
- **Soft Deletes:** 2 tables (events, resources)
- **Indexed Columns:** 8 indexes for performance optimization
