function validateRegister() {
    let name = document.getElementById('name').value.trim();
    let studentId = document.getElementById('student_id').value.trim();
    let username = document.getElementById('username').value.trim();
    let mobileNumber = document.getElementById('mobile_number').value.trim();
    let pass = document.getElementById('reg_password').value;
    let confirm = document.getElementById('confirm_password').value;

    // Check if all fields are filled
    if (!name || !studentId || !username || !mobileNumber || !pass || !confirm) {
        alert("All fields are required!");
        return false;
    }

    // Validate name (letters and spaces only)
    if (!/^[a-zA-Z\s]+$/.test(name)) {
        alert("Name should contain only letters and spaces!");
        return false;
    }

    // Validate student ID (alphanumeric)
    if (!/^[a-zA-Z0-9]+$/.test(studentId)) {
        alert("Student ID should be alphanumeric!");
        return false;
    }

    // Validate username (alphanumeric and underscore only, 3-20 chars)
    if (!/^[a-zA-Z0-9_]{3,20}$/.test(username)) {
        alert("Username must be 3-20 characters, alphanumeric or underscore only!");
        return false;
    }

    // Validate mobile number (10-15 digits)
    if (!/^[0-9]{10,15}$/.test(mobileNumber.replace(/\s/g, ''))) {
        alert("Mobile number should be 10-15 digits!");
        return false;
    }

    // Validate password strength (at least 6 chars, at least 1 number and 1 special char)
    if (pass.length < 6) {
        alert("Password must be at least 6 characters long!");
        return false;
    }

    if (!/[0-9]/.test(pass)) {
        alert("Password must contain at least one number!");
        return false;
    }

    if (!/[!@#$%^&*]/.test(pass)) {
        alert("Password must contain at least one special character (!@#$%^&*)!");
        return false;
    }

    // Check if passwords match
    if (pass !== confirm) {
        alert("Passwords do not match!");
        return false;
    }

    return true;
}

function validateLogin() {
    let username = document.getElementById('username').value.trim();
    let password = document.getElementById('password').value;

    if (!username) {
        alert("Username is required");
        return false;
    }

    if (!password) {
        alert("Password is required");
        return false;
    }

    return true;
}