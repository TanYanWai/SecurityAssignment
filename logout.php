<?php
// Start the session
session_start();

// Destroy the session data
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page after logout
header("Location: login1.html"); // Replace with your actual login page URL
exit();
?>
