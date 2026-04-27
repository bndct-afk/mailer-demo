<?php
session_start();

if(!isset($_SESSION['student_id']) || !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Input sanitization
$status = trim(htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8'));
$student_id = $_SESSION['student_id'];
$today = date("Y-m-d");

// Check if student already marked attendance today
$file = fopen("data/attendance.csv", "r");
$already_marked = false;

while (($row = fgetcsv($file)) !== FALSE) {
    // CSV format: StudentID, Name, Status, DateTime
    $record_date = date("Y-m-d", strtotime($row[3]));
    if ($row[0] == $student_id && $record_date == $today) {
        $already_marked = true;
        break;
    }
}
fclose($file);

if ($already_marked) {
    header("Location: attendance.php?error=You have already marked attendance today");
    exit;
}

// Save attendance
$file = fopen("data/attendance.csv", "a");
fputcsv($file, [$student_id, $_SESSION['user'], $status, date("Y-m-d H:i:s")]);
fclose($file);

header("Location: dashboard.php?msg=Attendance marked successfully");
exit;
?>