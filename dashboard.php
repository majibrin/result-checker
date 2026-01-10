<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
require_once 'src/Database.php';
$db = new Database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <nav>
        <span><i class="fa-solid fa-graduation-cap"></i> University Portal</span>
        <div style="float:right;">
            <a href="logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2>Admin Control Panel</h2>
        <div class="stats-grid">
            <a href="add-student.php" class="card" style="text-decoration:none; color:inherit;">
                <i class="fa-solid fa-user-plus fa-2x"></i>
                <p>Add Student</p>
            </a>
            <a href="manage-courses.php" class="card" style="text-decoration:none; color:inherit;">
                <i class="fa-solid fa-book fa-2x"></i>
                <p>Manage Courses</p>
            </a>
            <a href="upload-result.php" class="card" style="text-decoration:none; color:inherit;">
                <i class="fa-solid fa-file-arrow-up fa-2x"></i>
                <p>Upload Results</p>
            </a>
            <a href="manage-admins.php" class="card" style="text-decoration:none; color:inherit;">
                <i class="fa-solid fa-user-shield fa-2x"></i>
                <p>Staff Accounts</p>
            </a>
        </div>
    </div>
</body>
</html>
