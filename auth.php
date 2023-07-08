<?php
// Check if the user is logged in
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
}

// Logout code...

// Destroy the session and redirect to the login page
session_destroy();
header("Location: login.php");
exit;
?>