# QUICK START GUIDE

## 🚀 Get Started in 5 Minutes

### Step 1: File Structure Check ✅
Ensure these files exist:
- ✅ `index.php` - Landing page
- ✅ `register.php` - Student registration
- ✅ `dashboard.php` - Student dashboard
- ✅ `attendance.php` - Mark attendance
- ✅ `summary.php` - Statistics dashboard
- ✅ `parent_access.php` - Parent access
- ✅ `data/users.csv` - User database (will be auto-created)
- ✅ `data/attendance.csv` - Attendance log (will be auto-created)

### Step 2: Initialize Data Files
Create empty CSV files in the `/data/` folder if they don't exist:

**data/users.csv** - Initially empty, will store:
```
Name,StudentID,Username,MobileNumber,ParentEmail,HashedPassword
```

**data/attendance.csv** - Initially empty, will store:
```
StudentID,Name,Status,DateTime
```

### Step 3: Configure Email (Optional for Parent OTP)
Edit: `parent_otp_send.php` (Line 26-29)

Replace with your Gmail credentials:
```php
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-16-char-app-password';
```

**No Gmail? Email features won't work, but OTP session will still be created for testing.**

### Step 4: Start Testing 🧪

#### Test 1: Student Registration
1. Open: `http://localhost/MidLab_LQ/index.php`
2. Click: "Register here"
3. Fill Form:
   - Name: `John Doe`
   - Student ID: `STU001`
   - Username: `johndoe123`
   - Mobile: `9876543210`
   - Email: `john@example.com`
   - Password: `Password@123`
   - Confirm: `Password@123`
4. Click: "Register"
5. ✅ Should see: "Registration Successful"

#### Test 2: Student Login
1. Go back to: `index.php`
2. Enter:
   - Username: `johndoe123`
   - Password: `Password@123`
3. Click: "Login"
4. ✅ Should see: "Welcome, John Doe!"

#### Test 3: Mark Attendance
1. From Dashboard, click: "Mark Attendance"
2. Select: "Present"
3. Click: "Submit Attendance"
4. ✅ Should see: "Attendance marked successfully"

#### Test 4: Duplicate Prevention
1. Try to mark attendance again
2. ✅ Should see: "You have already marked attendance today"

#### Test 5: View Records
1. From Dashboard, click: "View Attendance Records"
2. ✅ Should see: Table with your attendance entries
3. Date and Time columns should show your submissions

#### Test 6: Attendance Summary ⭐
1. From Dashboard, click: "View Attendance Summary"
2. ✅ Should see:
   - Total Records: 1
   - Days Present: 1
   - Present Count: 1
   - Attendance: 100%
   - Last Attendance Date

#### Test 7: Parent Access (With Email)
1. Go to: `index.php`
2. Click: "Parent Access"
3. Enter:
   - Student ID: `STU001`
   - Email: `john@example.com`
4. Click: "Send OTP"
5. ✅ Should receive email with OTP
6. Enter OTP in verification page (within 2 minutes)
7. ✅ Should see student's attendance records

#### Test 7b: Parent Access (Without Email)
1. Go to: `index.php`
2. Click: "Parent Access"
3. Enter:
   - Student ID: `STU001`
   - Email: `john@example.com`
4. Click: "Send OTP"
5. ℹ️ If email fails, check console logs
6. A session OTP is still created for testing

#### Test 8: Logout
1. Click: "Logout"
2. ✅ Should redirect to login page with message

---

## 📋 Test Cases Checklist

- [ ] Student Registration with validation
- [ ] Duplicate Student ID prevention
- [ ] Password strength requirements
- [ ] Student Login authentication
- [ ] Session persistence
- [ ] Mark attendance
- [ ] Duplicate attendance prevention (per day)
- [ ] View attendance records
- [ ] View attendance summary
- [ ] Summary statistics accuracy
- [ ] Parent access verification
- [ ] OTP email sending (if configured)
- [ ] OTP verification with timer
- [ ] Parent viewing student records
- [ ] Logout session termination
- [ ] Input sanitization (XSS prevention)
- [ ] SQL injection prevention
- [ ] Error messages display correctly

---

## 🔐 Security Features Tested

- ✅ Password hashing (bcrypt)
- ✅ Password verification
- ✅ Session management
- ✅ Input sanitization (htmlspecialchars)
- ✅ Email validation
- ✅ Authorization checks (session validation)
- ✅ Unauthorized access prevention
- ✅ OTP timeout (2 minutes)

---

## 📊 Sample Test Data

### Student 1
```
Name: Alice Johnson
Student ID: STU002
Username: alice_j
Mobile: 9123456789
Email: alice@example.com
Password: Alice@2024
```

### Student 2
```
Name: Bob Smith
Student ID: STU003
Username: bob_smith
Mobile: 9234567890
Email: bob@example.com
Password: BobPass123!
```

---

## ⚠️ Common Issues & Solutions

**Issue**: "Fatal error: Failed opening required 'PHPMailer/PHPMailer.php'"
- Solution: Verify PHPMailer folder exists in root directory

**Issue**: File permissions error
- Solution: Right-click `/data/` folder → Properties → Security → Grant Write permissions

**Issue**: OTP not received
- Solution: Check Gmail app password configuration (NOT regular password)

**Issue**: Password validation fails
- Solution: Password must have: 1 number, 1 special char, min 6 characters
  - ✅ Valid: `Pass123!`
  - ❌ Invalid: `password123` (no special char)
  - ❌ Invalid: `Pass!` (too short)

**Issue**: Attendance marked twice on same day
- Solution: This is prevented by the system - only 1 entry per student per day

---

## 🎯 Next Steps

1. ✅ Complete all test cases above
2. ✅ Verify all features work as expected
3. ✅ Test error handling and edge cases
4. ✅ Review security features
5. ✅ Check database format (CSV)
6. ✅ Ready for production!

---

**System Status**: ✅ READY TO TEST

**Need Help?** Check the main README.md file for detailed documentation.
