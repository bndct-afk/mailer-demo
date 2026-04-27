<?php 
session_start();
if(!isset($_SESSION['student_id']) || !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Mark Attendance</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Mark Attendance</h2>
    
    <?php 
    if(isset($_GET['error'])) {
        echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
    }
    ?>

    <form action="save_attendance.php" method="POST">
        <label>Select Status</label>
        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Late">Late</option>
            <option value="Absent">Absent</option>
        </select>
        <button type="submit">Submit Attendance</button>
    </form>

    <div class="links">
        <a class="btn" href="dashboard.php">Back to Dashboard</a>
    </div>
</div>
</body>
</html>