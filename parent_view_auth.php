<?php
session_start();

// Check if OTP session exists
if (!isset($_SESSION['parent_otp']) || !isset($_SESSION['view_id'])) {
    header("Location: parent_access.php");
    exit;
}

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['otp'])) {
    header("Location: verify_parent.php");
    exit;
}

// Input sanitization
$otp_input = trim(htmlspecialchars($_POST['otp'], ENT_QUOTES, 'UTF-8'));

// Validate OTP (must be 6 digits)
if (!preg_match('/^\d{6}$/', $otp_input)) {
    header("Location: verify_parent.php?error=Invalid OTP format");
    exit;
}

// Compare OTP
if ($otp_input == $_SESSION['parent_otp']) {
    $_SESSION['parent_auth'] = true;
    // OTP is no longer needed
    unset($_SESSION['parent_otp']);
    
    header("Location: records.php");
    exit;
} else {
    header("Location: verify_parent.php?error=Invalid OTP");
    exit;
}
?>