<?php
session_start();
if ($_POST['otp'] == $_SESSION['otp']) {
    $data = $_SESSION['reg_data'];
    $file = fopen("data/users.csv", "a");
    // Format: Name, StudentID, Username, Class, ParentEmail, HashedPassword
    fputcsv($file, [$data['name'], $data['student_id'], $data['username'], $data['class'], $data['parent_email'], $data['password']]);
    fclose($file);
    header("Location: index.php?msg=Success");
} else {
    echo "Invalid OTP";
}
?>