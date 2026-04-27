<?php
session_start();

// Clear all session variables
session_destroy();

// Redirect to home
header("Location: index.php?msg=You have been logged out successfully");
exit;
?>