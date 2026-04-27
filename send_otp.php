<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Check if the request is POST and required fields are set
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
    !isset($_POST['name'], $_POST['student_id'], $_POST['username'], $_POST['class'], $_POST['parent_email'], $_POST['password'])) {
    header("Location: register.php"); // Redirect back to registration form
    exit;
}

$_SESSION['reg_data'] = [
    'name' => $_POST['name'],
    'student_id' => $_POST['student_id'],
    'username' => $_POST['username'],
    'class' => $_POST['class'],
    'parent_email' => $_POST['parent_email'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
];

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'johnchristianpadigos@gmail.com'; // Use your actual email
    $mail->Password = 'arbl lmts hhdf cjjf';    // Use your actual app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('johnchristianpadigos@gmail.com', 'Attendance System');
    $mail->addAddress($_POST['parent_email']); 
    $mail->Subject = "Verification Code";
    $mail->Body = "Your registration OTP is: $otp";
    $mail->send();

    header("Location: verify.php");
} catch (Exception $e) { echo "Mailer Error: " . $mail->ErrorInfo; }
?>