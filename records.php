<?php
session_start();

// Check authentication
if(!isset($_SESSION['user']) && !isset($_SESSION['parent_auth'])) {
    header("Location: index.php");
    exit;
}

// Determine whose records to display
if(isset($_SESSION['user'])) {
    // Student logged in - can only view their own records
    if(!isset($_SESSION['student_id'])) {
        header("Location: index.php");
        exit;
    }
    $target = $_SESSION['student_id'];
} elseif(isset($_SESSION['parent_auth'])) {
    // Parent authenticated - can only view the specific student they verified
    if(!isset($_SESSION['view_id'])) {
        header("Location: parent_access.php");
        exit;
    }
    $target = $_SESSION['view_id'];
} else {
    // Unauthorized
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Attendance Records</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container wide">
    <h2>Attendance Records - ID: <?php echo htmlspecialchars($target); ?></h2>
    
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php
        $file = fopen("data/attendance.csv", "r");
        $found_records = false;
        
        while(($row = fgetcsv($file)) !== FALSE) {
            if($row[0] == $target) {
                $found_records = true;
                $datetime = $row[3];
                $date_part = date("Y-m-d", strtotime($datetime));
                $time_part = date("H:i:s", strtotime($datetime));
                echo "<tr><td>" . htmlspecialchars($date_part) . "</td><td>" . htmlspecialchars($time_part) . "</td><td>" . htmlspecialchars($row[2]) . "</td></tr>";
            }
        }
        fclose($file);
        
        if (!$found_records) {
            echo "<tr><td colspan='3' style='text-align: center;'>No attendance records found</td></tr>";
        }
        ?>
    </table>

    <div class="links">
        <?php if(isset($_SESSION['user'])): ?>
            <a class="btn" href="dashboard.php">Back to Dashboard</a>
        <?php elseif(isset($_SESSION['parent_auth'])): ?>
            <a class="btn" href="index.php">Back to Home</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>