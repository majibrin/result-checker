<?php
// Placeholder for front-end testing
session_start();

// Fake login: just redirect based on dummy role
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    if($username === 'admin') {
        $_SESSION['user_role'] = 'admin';
        header("Location: admin-dashboard.php");
    } else {
        $_SESSION['user_role'] = 'student';
        header("Location: student-dashboard.php");
    }
    exit;
}
?>