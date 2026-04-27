<?php
session_start();

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['username'], $_POST['password'])) {
    header("Location: index.php");
    exit;
}

// Input sanitization
$username = trim(htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));
$password = $_POST['password'];

// Validate inputs
if (empty($username) || empty($password)) {
    header("Location: index.php?error=Username and password are required");
    exit;
}

$file = fopen("data/users.csv", "r");
$found = false;

while (($row = fgetcsv($file)) !== FALSE) {
    // CSV format: Name, StudentID, Username, MobileNumber, ParentEmail, HashedPassword
    if ($row[2] == $username && password_verify($password, $row[5])) {
        // Login successful
        $_SESSION['user'] = $row[0];  // Name
        $_SESSION['student_id'] = $row[1];  // Student ID
        $_SESSION['username'] = $row[2];  // Username
        fclose($file);
        header("Location: dashboard.php");
        exit;
    }
}
fclose($file);

// Login failed
header("Location: index.php?error=Invalid username or password");
exit;
?>