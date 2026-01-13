<?php
require_once 'src/Database.php';
$db = new Database();

// Clear existing admin to avoid "Duplicate entry" errors
$db->query("DELETE FROM admins WHERE username = 'admin'");

// Create fresh admin with hashed password
$username = 'admin';
$password = 'password123';
$hashed = password_hash($password, PASSWORD_BCRYPT);
$role = 'admin';

$stmt = $db->prepare("INSERT INTO admins (username, `password`, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashed, $role);

if ($stmt->execute()) {
    echo "<h2>✅ Admin Reset Successful!</h2>";
    echo "Username: <b>admin</b><br>Password: <b>password123</b><br>";
    echo "<a href='login.php'>Go to Login</a>";
} else {
    echo "❌ Error: " . $stmt->error;
}
?>