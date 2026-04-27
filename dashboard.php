<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container wide">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    
    <?php 
    if(isset($_GET['msg'])) {
        echo "<div class='success-msg'>" . htmlspecialchars($_GET['msg']) . "</div>";
    }
    if(isset($_GET['error'])) {
        echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
    }
    ?>

    <div class="button-group">
        <a class="btn" href="attendance.php">Mark Attendance</a>
        <a class="btn" href="records.php">View Attendance Records</a>
        <a class="btn" href="summary.php">View Attendance Summary</a>
        <a class="btn logout" href="logout.php">Logout</a>
    </div>
</div>
</body>
</html>
