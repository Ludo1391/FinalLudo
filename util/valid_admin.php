<?php 
    // Start session if not already started
    session_status() === PHP_SESSION_ACTIVE ? '' : session_start();
    // If admin logged in not set, redirect to login
    isset($_SESSION['is_valid_admin']) ? "" : header("Location: ./admin.php");
?>