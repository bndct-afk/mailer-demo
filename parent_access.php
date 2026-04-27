<?php
session_start();

// Clear any previous parent auth
if(isset($_SESSION['parent_auth'])) {
    unset($_SESSION['parent_auth']);
}
if(isset($_SESSION['view_id'])) {
    unset($_SESSION['view_id']);
}
if(isset($_SESSION['parent_otp'])) {
    unset($_SESSION['parent_otp']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Access - Attendance System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Parent Access</h2>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">Verify your identity to view student attendance</p>
        
        <?php 
        if(isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>
        
        <form action="parent_otp_send.php" method="POST">
            <label>Student ID:</label>
            <input type="text" name="student_id" required>

            <label>Parent Email:</label>
            <input type="email" name="parent_email" required>

            <button type="submit">Send OTP</button>
        </form>
        
        <div class="links">
            <p><a href="index.php">Back to Student Login</a></p>
        </div>
    </div>
</body>
</html>
