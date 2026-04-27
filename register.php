<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/validate.js"></script>
</head>
<body>
<div class="container">
    <h2>Student Registration</h2>
    <form action="register_process.php" method="POST" onsubmit="return validateRegister()">
        <input type="text" id="name" name="name" placeholder="Full Name" required>
        <input type="text" id="student_id" name="student_id" placeholder="Student ID" required>
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="tel" id="mobile_number" name="mobile_number" placeholder="Parent Mobile Number" required>
        <input type="email" name="parent_email" placeholder="Parent Email" required>
        <input type="password" id="reg_password" name="password" placeholder="Password (min 6 chars, 1 number, 1 special char)" required>
        <input type="password" id="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
    <p style="text-align: center;">Already registered? <a href="index.php">Login here</a></p>
</div>
</body>
</html>