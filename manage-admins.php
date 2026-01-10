<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
require_once 'src/Database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $db->escape($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $db->escape($_POST['role']);

    $stmt = $db->prepare("INSERT INTO admins (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $role);
    $stmt->execute();
    $msg = "Admin/Lecturer Created!";
}

$admins = $db->query("SELECT id, username, role FROM admins");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <nav><a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Dashboard</a></nav>
    <div class="container">
        <form method="POST">
            <h3><i class="fa-solid fa-user-shield"></i> Create Staff Account</h3>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="lecturer">Lecturer</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Create Account</button>
        </form>

        <div class="table-container" style="margin-top:20px;">
            <table>
                <tr><th>Username</th><th>Role</th></tr>
                <?php while($row = $admins->fetch_assoc()): ?>
                <tr><td><?= $row['username'] ?></td><td><?= $row['role'] ?></td></tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
