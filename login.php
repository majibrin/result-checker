<?php
session_start();
require_once 'src/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $username = $db->escape($_POST['username']);
    $password = $_POST['password'];

    // 1. Check Admin Table
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

    // 2. Check Student Table (Reg No as Username)
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
    $error = "Invalid Credentials";
}
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login</title></head>
<body>
    <form method="POST">
        <h2>Portal Login</h2>
        <?php if(isset($error)) echo "<p>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username/Reg No" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
