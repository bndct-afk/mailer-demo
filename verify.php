<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">

<h2>Email Verification</h2>

<form action="verify_process.php" method="POST">

<label>Enter OTP</label>
<input type="text" name="otp">

<button type="submit">Verify</button>

</form>

</div>
</body>
</html>