<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['student_id'], $_POST['parent_email'])) {
    header("Location: parent_access.php");
    exit;
}

// Input sanitization
$student_id = trim(htmlspecialchars($_POST['student_id'], ENT_QUOTES, 'UTF-8'));
$input_email = trim(htmlspecialchars($_POST['parent_email'], ENT_QUOTES, 'UTF-8'));

// Validate email format
if (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
    header("Location: parent_access.php?error=Invalid email format");
    exit;
}

$stored_email = '';

// Find matching student record
$file = fopen("data/users.csv", "r");
while (($row = fgetcsv($file)) !== FALSE) {
    // CSV format: Name, StudentID, Username, MobileNumber, ParentEmail, HashedPassword
    if ($row[1] == $student_id) {
        $stored_email = $row[4];
        break;
    }
}
fclose($file);

if (empty($stored_email) || $stored_email !== $input_email) {
    header("Location: parent_access.php?error=Invalid Student ID or Parent Email");
    exit;
}

// Generate OTP
$otp = rand(100000, 999999);
$_SESSION['parent_otp'] = $otp;
$_SESSION['view_id'] = $student_id;
$_SESSION['otp_time'] = time();

// Send OTP via email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // Replace with your actual email credentials
    $mail->Username = 'johnchristianpadigos@gmail.com';
    $mail->Password = 'arbl lmts hhdf cjjf';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('johnchristianpadigos@gmail.com', 'Attendance System');
    $mail->addAddress($input_email);
    $mail->Subject = "Attendance System - Parent Access OTP";
    $mail->Body = "Your One-Time Password (OTP) to access your child's attendance is: $otp\n\nThis OTP is valid for 2 minutes only.\n\nDo not share this OTP with anyone.";
    $mail->send();

    header("Location: verify_parent.php");
    exit;
} catch (Exception $e) {
    error_log("Email Error: " . $mail->ErrorInfo);
    header("Location: parent_access.php?error=Failed to send OTP. Please try again.");
    exit;
}
?>