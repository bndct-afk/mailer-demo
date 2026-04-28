<?php
session_start();

// Check authentication
if (!isset($_SESSION['user']) && !isset($_SESSION['parent_auth'])) {
    header("Location: index.php");
    exit;
}

// Get the record ID and date from URL
if (!isset($_GET['id']) || !isset($_GET['date'])) {
    header("Location: records.php?error=Invalid record");
    exit;
}

$record_id = $_GET['id'];
$record_date = $_GET['date'];

// For students, only allow deleting their own records
if (isset($_SESSION['student_id']) && $record_id != $_SESSION['student_id']) {
    header("Location: records.php?error=Unauthorized");
    exit;
}

// Read all records
$file = fopen("data/attendance.csv", "r");
$records = [];
$found = false;

while (($row = fgetcsv($file)) !== FALSE) {
    $row_date = date("Y-m-d", strtotime($row[3]));
    // Skip the record to be deleted
    if ($row[0] == $record_id && $row_date == $record_date) {
        $found = true;
        continue;
    }
    $records[] = $row;
}
fclose($file);

if (!$found) {
    header("Location: records.php?error=Record not found");
    exit;
}

// Write back to file (without the deleted record)
$file = fopen("data/attendance.csv", "w");
foreach ($records as $r) {
    fputcsv($file, $r);
}
fclose($file);

header("Location: records.php?msg=Record deleted successfully");
exit;
?>