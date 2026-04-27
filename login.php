<?php
session_start();
$username = $_POST['username']; 
$password = $_POST['password'];

$file = fopen("data/users.csv", "r");
while (($row = fgetcsv($file)) !== FALSE) {
    if ($row[2] == $username && password_verify($password, $row[5])) {
        $_SESSION['user'] = $row[0];
        $_SESSION['student_id'] = $row[1];
        header("Location: dashboard.php");
        exit;
    }
}
echo "Login Failed";
?>