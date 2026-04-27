<?php
session_start();

if(!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Security check - ensure the student_id matches the session and can't be overridden
if(!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Calculate attendance statistics
$total_present = 0;
$total_absent = 0;
$total_late = 0;
$total_records = 0;
$last_attendance_date = "N/A";
$unique_dates = array();

$file = fopen("data/attendance.csv", "r");
while(($row = fgetcsv($file)) !== FALSE) {
    if($row[0] == $student_id) {
        $total_records++;
        $status = $row[2];
        $date = date("Y-m-d", strtotime($row[3]));
        
        if ($status === "Present") {
            $total_present++;
            // Track unique dates ONLY for Present status
            if (!in_array($date, $unique_dates)) {
                $unique_dates[] = $date;
            }
        } elseif ($status === "Absent") {
            $total_absent++;
        } elseif ($status === "Late") {
            $total_late++;
        }
        
        // Update last attendance
        $last_attendance_date = $row[3];
    }
}
fclose($file);

$total_days_present = count($unique_dates);
$attendance_percentage = $total_records > 0 ? round(($total_present / $total_records) * 100, 2) : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Summary</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container wide">
    <h2>Attendance Summary</h2>
    <p style="text-align: center; color: #666;">Student ID: <?php echo htmlspecialchars($student_id); ?></p>
    
    <div class="summary-grid">
        <div class="summary-card">
            <h3>Total Records</h3>
            <p class="stat-number"><?php echo $total_records; ?></p>
        </div>
        
        <div class="summary-card">
            <h3>Days Present</h3>
            <p class="stat-number"><?php echo $total_days_present; ?></p>
        </div>
        
     
        
        <div class="summary-card">
            <h3>Late Count</h3>
            <p class="stat-number" style="color: #f39c12;"><?php echo $total_late; ?></p>
        </div>
        
        <div class="summary-card">
            <h3>Absent Count</h3>
            <p class="stat-number" style="color: #e74c3c;"><?php echo $total_absent; ?></p>
        </div>
        
    </div>
    
    <div class="info-box">
        <p><strong>Last Attendance:</strong> <?php echo ($last_attendance_date !== "N/A") ? htmlspecialchars($last_attendance_date) : "No records"; ?></p>
    </div>
    
    <div class="links">
        <a class="btn" href="records.php">View Detailed Records</a>
        <a class="btn" href="dashboard.php">Back to Dashboard</a>
    </div>
</div>
</body>
</html>