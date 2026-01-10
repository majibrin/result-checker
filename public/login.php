<?php
session_start();

// If already logged in, redirect based on role
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'lecturer') {
        header("Location: admin-dashboard.php");
        exit;
    } elseif ($_SESSION['user_role'] === 'student') {
        header("Location: student-dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Result Checker Login</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <div class="login-card">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="auth.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p id="errorMsg">
            <?php 
                if(isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                }
            ?>
        </p>
    </div>
</div>
<script src="js/login.js"></script>
</body>
</html>