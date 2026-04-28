<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the request is POST and required fields are set
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['name'], $_POST['student_id'], $_POST['username'], $_POST['mobile_number'], $_POST['parent_email'], $_POST['password'])) {
    header("Location: register.php?error=Missing fields"); 
    exit;
}

// Input sanitization and validation
$name = trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'));
$student_id = trim(htmlspecialchars($_POST['student_id'], ENT_QUOTES, 'UTF-8'));
$username = trim(htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));
$mobile_number = trim(htmlspecialchars($_POST['mobile_number'], ENT_QUOTES, 'UTF-8'));
$parent_email = trim(htmlspecialchars($_POST['parent_email'], ENT_QUOTES, 'UTF-8'));
$password = $_POST['password'];

// Validate inputs
if (empty($name) || empty($student_id) || empty($username) || empty($mobile_number) || empty($parent_email) || empty($password)) {
    header("Location: register.php?error=Empty fields");
    exit;
}

// Validate email format
if (!filter_var($parent_email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=Invalid email");
    exit;
}

// Check if student_id already exists
$file = fopen("data/users.csv", "r");
while (($row = fgetcsv($file)) !== FALSE) {
    if ($row[1] == $student_id) {
        fclose($file);
        header("Location: register.php?error=Student ID already registered");
        exit;
    }
}
fclose($file);

$data = [
    'name' => $name,
    'student_id' => $student_id,
    'username' => $username,
    'mobile_number' => $mobile_number,
    'parent_email' => $parent_email,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];

// Append to CSV
$csvFile = "data/users.csv";

// Check if file exists and is writable
if (!is_writable($csvFile)) {
    header("Location: register.php?error=File not writable: " . urlencode($csvFile));
    exit;
}

$file = fopen($csvFile, "a");
if ($file === false) {
    header("Location: register.php?error=Could not open file");
    exit;
}

// Format: Name, StudentID, Username, MobileNumber, ParentEmail, HashedPassword
$result = fputcsv($file, [$data['name'], $data['student_id'], $data['username'], $data['mobile_number'], $data['parent_email'], $data['password']]);
fclose($file);

if ($result === false) {
    header("Location: register.php?error=Failed to write to CSV");
    exit;
}

header("Location: index.php?msg=Registration Successful. Please Login.");
exit;
?>