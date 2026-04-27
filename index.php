<?php
session_start();

// If already logged in, redirect to dashboard
if(isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Attendance System - Login</title>
<link rel="stylesheet" href="css/style.css">
<script src="js/validate.js"></script>
</head>
<body>
    <div class="container">
        <h2>Attendance System</h2>
        <h3>Student Login</h3>
        
        <?php 
        if(isset($_GET['msg'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['msg']) . "</div>";
        }
        if(isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>

        <form action="login_process.php" method="POST" onsubmit="return validateLogin()">
            <label>Username</label>
            <input type="text" name="username" id="username" required>

            <label>Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            <p><a href="parent_access.php">Parent Access</a></p>
        </div>
    </div>
</body>
</html>