<?php session_start(); 
if(!isset($_SESSION['parent_otp'])) {
    header("Location: parent_access.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification - Parent Access</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>OTP Verification</h2>
    <p style="text-align: center; color: #666;">Enter the OTP sent to your email</p>
    
    <form action="parent_view_auth.php" method="POST" id="otpForm">
        <label>Enter OTP:</label>
        <input type="text" name="otp" id="otp" maxlength="6" placeholder="000000" required>
        <button type="submit" id="v_btn">Verify OTP</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        <strong>Code expires in: <span id="timer" style="color: #e74c3c; font-size: 18px;">02:00</span></strong>
    </p>
    
    <div class="links">
        <a href="parent_access.php">Back to Parent Access</a>
    </div>
</div>

<script>
    let time = 120;
    const timerSpan = document.getElementById('timer');
    const submitBtn = document.getElementById('v_btn');
    const otpForm = document.getElementById('otpForm');
    
    const timerInterval = setInterval(() => {
        if (time <= 0) {
            clearInterval(timerInterval);
            submitBtn.disabled = true;
            timerSpan.textContent = "00:00";
            timerSpan.style.color = "#e74c3c";
            otpForm.innerHTML = "<p style='color: #e74c3c; text-align: center;'><strong>OTP has expired. <a href='parent_access.php'>Request a new OTP</a></strong></p>";
            return;
        }
        
        let m = Math.floor(time / 60);
        let s = time % 60;
        timerSpan.textContent = `${m}:${s < 10 ? '0' : ''}${s}`;
        
        // Change color when time is running out
        if (time <= 30) {
            timerSpan.style.color = "#f39c12";
        }
        
        time--;
    }, 1000);
    
    // Auto-focus on OTP input
    document.getElementById('otp').focus();
</script>
</body>
</html>