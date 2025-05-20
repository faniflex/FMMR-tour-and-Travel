
# FMMR Tour and Travel
Version 2.0

## System Overview

Features
- Secure login/signup
- Birthdate-based password recovery
- Session management
- Complete package customization
- Multiple destination options
- Room type selection
- Weekly/monthly reports
- Booking analytics
- CSV export functionality

Requirements
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)

Installation
- Import database schema (database.sql)
- Configure config.php with DB credentials
- Set up admin credentials in admin_login.php

Security Notes
- All passwords are hashed
- SQL injection protected
- Session timeout after 30 minutes

Usage
- Users: Access via index.php
- Admins: Login at admin_login.php

## NEW FEATURES DOCUMENTATION
 ### Forgot Password System
Added modules
- forgot_password.php
- reset_password.php
Database updates How It Works
- Users click "Forgot Password" on login page
- Verify identity using birthdate (stored during registration)
- System allows setting a new password
- Automatic session termination after reset

 ### Reporting Module
Added modules
- reports.php
- export_report.php
Features 
- Weekly/Monthly booking reports
- Export to CSV functionality
- Interactive date filtering
- Summary statistics dashboard

### Admin Authentication
Added Modules
- admin_login.php
- logout.php
- check_admin.php
Security Features
- Session-based access control
- Password hashing
- 30-minute inactivity timeout
- Secure logout handling

### Data Export Functionality
Endpoint
- export_report.php?type=[weekly/monthly]&start_date=YYYY-MM-DD&end_date=YYYY-MM-DD

Output Formats
- CSV with booking data
-  Printable HTML reports



