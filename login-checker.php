<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // User is logged in, redirect based on role
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin-dashboard.php");
    } else {
        header("Location: view-games.php");
    }
    exit;
}

// If not logged in, allow access to the login page
?>