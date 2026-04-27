# Attendance System - Setup & Usage Guide

## System Overview
A complete Student and Parent Attendance Management System with secure login, OTP verification, attendance recording, and comprehensive dashboard analytics.

---

## Project Structure

```
MidLab_LQ/
├── index.php                    # Main login page (landing page)
├── register.php                 # Student registration form
├── register_process.php         # Registration backend with validation
├── login_process.php            # Login authentication
├── dashboard.php                # Student dashboard
├── attendance.php               # Mark attendance page
├── save_attendance.php          # Save attendance with duplicate prevention
├── records.php                  # View attendance records
├── summary.php                  # Attendance summary & statistics ⭐ NEW
├── parent_access.php            # Parent access entry
├── parent_otp_send.php          # Generate and send OTP
├── verify_parent.php            # OTP verification page with timer
├── parent_view_auth.php         # OTP validation
├── logout.php                   # Logout handler
├── css/
│   └── style.css               # Enhanced styling
├── js/
│   └── validate.js             # Client-side validation (enhanced)
├── PHPMailer/                  # Email library for OTP
├── data/
│   ├── users.csv               # User database
│   └── attendance.csv          # Attendance records
└── README.md                   # This file
```

---

## Part A: Student Module

### 1. Registration
- **File**: [register.php](register.php)
- **Fields**: 
  - Full Name
  - Student ID
  - Username
  - Parent Mobile Number
  - Parent Email
  - Password (with strength requirements)
  - Confirm Password

**Validation Rules**:
- Name: Letters and spaces only
- Student ID: Alphanumeric, must be unique
- Username: 3-20 chars, alphanumeric/underscore only
- Mobile: 10-15 digits
- Email: Valid format
- Password: Min 6 chars, at least 1 number, 1 special character (!@#$%^&*)

**Storage**: Secure hashing with `password_hash()`

### 2. Login
- **File**: [login_process.php](login_process.php)
- **Process**: 
  1. Username verification from CSV
  2. Password validation using `password_verify()`
  3. Session creation
  4. Redirect to dashboard

### 3. Student Dashboard
- **File**: [dashboard.php](dashboard.php)
- **Features**:
  - Welcome message
  - Quick access buttons:
    - Mark Attendance
    - View Attendance Records
    - View Attendance Summary
    - Logout

### 4. Mark Attendance
- **File**: [attendance.php](attendance.php) + [save_attendance.php](save_attendance.php)
- **Features**:
  - Select status: Present, Late, Absent
  - **Duplicate Prevention**: Only 1 entry per student per day
  - Automatic timestamp recording
  - Error handling for duplicate attempts

### 5. Attendance Summary Dashboard ⭐
- **File**: [summary.php](summary.php)
- **Displays**:
  - Total Records Logged
  - Total Days Present (unique dates)
  - Present Count
  - Late Count
  - Absent Count
  - Attendance Percentage
  - Last Attendance Date/Time
  - Visual cards with statistics

---

## Part B: Parent Module

### 1. Parent Access Page
- **File**: [parent_access.php](parent_access.php)
- **Input**: 
  - Student ID
  - Parent Email (must match registered email)
- **Validation**: Cross-referenced against student records

### 2. OTP Generation & Sending
- **File**: [parent_otp_send.php](parent_otp_send.php)
- **Process**:
  1. Verify Student ID exists
  2. Verify email matches registered parent email
  3. Generate 6-digit OTP
  4. Send via email using PHPMailer
  5. Store OTP in session
  6. Redirect to verification page

### 3. OTP Verification
- **File**: [verify_parent.php](verify_parent.php)
- **Features**:
  - 2-minute countdown timer
  - Color-coded timer (green → yellow → red)
  - Timer automatically disables button when expired
  - User-friendly interface
  - Auto-focus on OTP input field

### 4. Parent View Authorization
- **File**: [parent_view_auth.php](parent_view_auth.php)
- **Process**:
  1. Validate OTP (6 digits)
  2. Compare with session OTP
  3. Set `parent_auth` session flag
  4. Redirect to attendance records

### 5. View Records (Parent)
- Parents see same records page as students
- Filtered by Student ID
- Can logout to clear session

---

## Security Features

### Input Sanitization
- All user inputs sanitized with `htmlspecialchars()` and `trim()`
- XSS protection on all forms
- Email validation with `filter_var()`

### Password Security
- Bcrypt hashing with `password_hash()`
- Password verification with `password_verify()`
- Password strength requirements enforced

### Session Management
- Session-based authentication
- Automatic redirection for unauthorized access
- Session termination on logout
- OTP timeout after 2 minutes

### Data Storage
- CSV format (can be migrated to database)
- No sensitive data in plain text
- Passwords hashed on storage

---

## CSV File Formats

### users.csv
```
Name,StudentID,Username,MobileNumber,ParentEmail,HashedPassword
John Doe,STU001,johndoe,9876543210,john@email.com,hashed_password_here
```

### attendance.csv
```
StudentID,Name,Status,DateTime
STU001,John Doe,Present,2024-04-22 09:30:45
STU001,John Doe,Late,2024-04-23 10:15:30
```

---

## JavaScript Validation

### File: [js/validate.js](js/validate.js)

**Functions**:

1. **validateRegister()** - Comprehensive registration validation
   - All fields required
   - Name format validation
   - Student ID uniqueness check
   - Username format (3-20 chars)
   - Mobile number format (10-15 digits)
   - Password strength (min 6, needs number & special char)
   - Password match confirmation

2. **validateLogin()** - Login form validation
   - Username required
   - Password required

---

## Setup & Configuration

### 1. Database Initialization
The `data/` folder should contain:
- `users.csv` - Initially empty or with headers
- `attendance.csv` - Initially empty or with headers

### 2. Email Configuration (Parent OTP)
Edit [parent_otp_send.php](parent_otp_send.php):
```php
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
```

**Gmail Setup**:
- Enable 2-Factor Authentication
- Generate App Password
- Use App Password in configuration

### 3. Server Requirements
- PHP 7.2+
- PHPMailer library (included)
- File write permissions for `/data/` folder
- SMTP access (for email sending)

---

## Testing Flow

### Student Flow
1. Go to `index.php`
2. Click "Register here"
3. Fill registration form with valid data
4. Submit registration
5. Login with credentials
6. Click "Mark Attendance"
7. Select status and submit
8. Try marking again (should show duplicate error)
9. View attendance in "Records"
10. Check statistics in "Summary"

### Parent Flow
1. From `index.php`, click "Parent Access"
2. Enter Student ID and Parent Email
3. Check email for OTP
4. Enter OTP in verification page (within 2 minutes)
5. View student's attendance records

---

## Error Handling

- ✅ Missing required fields
- ✅ Invalid input formats
- ✅ Duplicate attendance entries
- ✅ Student ID/Email mismatch
- ✅ Invalid OTP attempts
- ✅ Expired OTP
- ✅ Session timeouts

---

## Features Implemented

### Part A - Student Module ✅
- [x] Student Registration Form
- [x] JavaScript Validation
- [x] Secure Storage (password_hash)
- [x] Login System (password_verify + sessions)
- [x] Attendance Marking with Time In
- [x] Duplicate Prevention per Day

### Part B - Parent Module ✅
- [x] Parent Access Page
- [x] 6-digit OTP Generation
- [x] OTP Verification Page
- [x] JavaScript Timer (2 minutes)
- [x] Access Control
- [x] Attendance Records Display

### New Feature - Dashboard ✅
- [x] Total Days Present
- [x] Last Attendance Date
- [x] Total Records Logged
- [x] Additional Statistics (Late, Absent, Attendance %)
- [x] Responsive Card Layout

### Technical Requirements ✅
- [x] PHP Backend Logic
- [x] HTML Structure
- [x] JavaScript Validation & Timer
- [x] CSV Data Storage
- [x] Session Management
- [x] Input Sanitization
- [x] Password Hashing
- [x] Session Control

---

## File Descriptions

| File | Purpose |
|------|---------|
| **index.php** | Landing page with student login form |
| **register.php** | Student registration form |
| **register_process.php** | Registration backend with validation & storage |
| **login_process.php** | Authentication logic |
| **dashboard.php** | Main student menu |
| **attendance.php** | Attendance marking interface |
| **save_attendance.php** | Attendance recording with duplicate check |
| **records.php** | View attendance records |
| **summary.php** | Attendance statistics dashboard |
| **parent_access.php** | Parent login entry point |
| **parent_otp_send.php** | OTP generation & email sending |
| **verify_parent.php** | OTP entry with timer |
| **parent_view_auth.php** | OTP validation |
| **logout.php** | Session termination |
| **css/style.css** | Responsive styling |
| **js/validate.js** | Client-side validations |

---

## Future Enhancements

- [ ] Database migration (MySQL/SQLite)
- [ ] Password reset functionality
- [ ] Attendance reports (PDF export)
- [ ] SMS notifications
- [ ] Student QR code check-in
- [ ] Mobile-responsive improvements
- [ ] Admin dashboard
- [ ] Bulk attendance import

---

## Support & Troubleshooting

**Q: Attendance duplicate error appears when it shouldn't?**
- Check system time is correct
- Clear browser cache
- Verify CSV format

**Q: OTP not received?**
- Check email configuration in `parent_otp_send.php`
- Verify Gmail app password is correct
- Check email spam folder

**Q: Password verification fails?**
- Ensure password contains: 1 number, 1 special char, min 6 length
- Check for space characters

**Q: Session expires too quickly?**
- Modify PHP `session.gc_maxlifetime` in php.ini

---

**Last Updated**: April 2024
**Status**: Production Ready ✅
