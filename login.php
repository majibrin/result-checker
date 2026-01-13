<?php
session_start();
require_once 'src/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $username = $db->escape($_POST['username']);
    $password = $_POST['password'];

    // 1. Check Admins Table (using backticks for password keyword)
    $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['role'] = $admin['role'];
        header("Location: dashboard.php");
        exit;
    }

    // 2. Check Students Table (Username is the Reg No)
    $stmt = $db->prepare("SELECT * FROM students WHERE reg_no = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();

    if ($student && password_verify($password, $student['password'])) {
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['role'] = 'student';
        header("Location: student-dashboard.php");
        exit;
    }

    $error = "Invalid Credentials. Please try again.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portal Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body class="login-page">
    <div class="container">
        <form method="POST">
            <h2><i class="fa-solid fa-lock"></i> Result Portal</h2>
            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <input type="text" name="username" placeholder="Admin User or Reg No" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>