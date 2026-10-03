# Campus Lost & Found Management System

Campus Lost & Found is a PHP web application for reporting and browsing lost and found items on campus. Students can register, sign in, and submit claims for items; administrators can review and update claim statuses.

## Features

- Student registration and sign-in.
- Report lost or found items with a name, category, type, location, date, and description.
- Browse reported items and their current status.
- Submit and review claims for reported items.
- Administrator sign-in and dashboard with user, item, and claim counts.
- Administrators can approve or reject pending claims; approving a claim marks the associated item as claimed.

## Tech Stack

- PHP with MySQLi
- MySQL
- HTML and CSS
- Google Fonts (Poppins)
- XAMPP for local Apache and MySQL services

Bootstrap 5, PDO, and JavaScript dependencies were not found in the current project files.

## Security Measures

- Parameterized MySQLi prepared statements are used for queries with variable user values.
- Student passwords are stored using `password_hash()` and checked with `password_verify()`; admin login also uses `password_verify()`.
- Student pages check for a signed-in user, and the admin dashboard checks for an admin session.
- `htmlspecialchars()` is used for most database-backed page output.

CSRF tokens and file-upload handling or upload validation are not implemented in the current PHP files. Output escaping is not applied uniformly. The local database connection details are currently in `config/database.php`; review them before publishing or deploying the project.

## Database Overview

The PHP pages query these tables:

| Table | Purpose in the application |
| --- | --- |
| `users` | Student account details and password hashes. |
| `admins` | Administrator account details and password hashes. |
| `items` | Lost and found reports, their details, submitter, and status. |
| `claims` | Student claims, descriptions, statuses, and related item/user IDs. |

No schema export or SQL file is included in this workspace, so column types, constraints, and an import filename cannot be documented from the project files.

## Project Structure

```text
campus-lost-found/
├── config/
│   └── database.php       MySQLi connection settings
├── css/
│   └── style.css          Shared stylesheet
├── js/                    Empty; no JavaScript files are present
├── uploads/               Empty; no upload handling is implemented
├── admin_dashboard.php    Admin statistics and claim management
├── admin_login.php        Admin sign-in
├── claim_item.php         Submit a claim for an item
├── dashboard.php          Student dashboard
├── index.php              Home page and navigation
├── login.php              Student sign-in
├── logout.php             End the current session
├── my_claims.php          List the signed-in student's claims
├── register.php           Create a student account
├── report_item.php        Submit a lost or found item report
├── view_items.php         Browse item reports
├── style.css              Additional root stylesheet; current PHP pages load css/style.css
├── .gitignore             Ignore local settings, uploads, and common temporary files
└── README.md              Project documentation
```

## Run Locally on XAMPP

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Copy the project folder to `C:\xampp\htdocs\campus-lost-found`.
3. Open phpMyAdmin and create a database named `campus_lost_found`.
4. Import the project's SQL schema into that database. **No `database/` folder or `.sql` file is present in this workspace**, so the required schema export must be added before this step can be completed. Do not guess an import filename.
5. Check `config/database.php` and adjust the MySQL connection settings if your local XAMPP settings differ. The current file uses host `localhost`, user `root`, an empty password, and database `campus_lost_found`.
6. Open [http://localhost/campus-lost-found/](http://localhost/campus-lost-found/) in a browser. The current project has no `public/` subfolder.

## Demo Logins

No demo credentials are documented in the project files. Create a student account through the registration page; use configured account details for admin sign-in.

| Account | Email | Password |
| --- | --- | --- |
| Student | (your registered student email) | (your demo password) |
| Admin | (your configured admin email) | (your demo password) |

## Screenshots

No `screenshots/` folder is present yet. Add project screenshots there when available.

## Possible Future Improvements

- Add and document a database schema export.
- Add CSRF protection to state-changing forms.
- Implement secure item-image uploads with file validation and access controls.
- Apply output escaping consistently and disable detailed error display outside local development.
- Move local database credentials into an ignored local configuration file.
- Add automated tests for account, item, and claim workflows.

## Author

- **Name:** Your Name
- **Register No.:** Your Register No.
- **College:** Your College
- **Case Study:** Component 3 Case Study, Front End Development
