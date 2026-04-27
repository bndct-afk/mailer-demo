<?php
/**
 * CONFIGURATION FILE - EMAIL SETUP
 * 
 * This file contains configuration settings for the Attendance System.
 * Update this with your actual email credentials.
 */

// Email Configuration for OTP Sending
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_AUTH', true);
define('SMTP_SECURE', 'tls');

// Gmail Account (Update with your actual email)
define('SENDER_EMAIL', 'your-email@gmail.com');
define('SENDER_PASSWORD', 'your-app-password');  // Use Gmail App Password, not regular password
define('SENDER_NAME', 'Attendance System');

// System Configuration
define('USERS_CSV', 'data/users.csv');
define('ATTENDANCE_CSV', 'data/attendance.csv');
define('OTP_TIMEOUT', 120); // 2 minutes
define('OTP_LENGTH', 6);

/**
 * GMAIL SETUP INSTRUCTIONS:
 * 
 * 1. Go to Google Account Settings: https://myaccount.google.com/
 * 2. Navigate to "Security" in the left menu
 * 3. Enable "2-Step Verification" if not already enabled
 * 4. Go back to Security and look for "App passwords"
 * 5. Select "Mail" and "Windows Computer" (or your device)
 * 6. Google will generate a 16-character password
 * 7. Copy this password and paste it as SENDER_PASSWORD above
 * 
 * NOTE: Do NOT use your regular Gmail password. Always use the App Password.
 */

// You can use this configuration in your PHP files like:
// $mail->Host = SMTP_HOST;
// $mail->Username = SENDER_EMAIL;
// $mail->Password = SENDER_PASSWORD;
?>
