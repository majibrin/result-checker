<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
require_once 'src/Course.php';
$c_obj = new Course();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_obj->create($_POST['name'], $_POST['unit'], $_POST['lecturer'], $_POST['code']);
}
$courses = $c_obj->getAll();
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
            <h3><i class="fa-solid fa-book"></i> Add Course</h3>
            <input type="text" name="code" placeholder="Course Code" required>
            <input type="text" name="name" placeholder="Course Title" required>
            <input type="number" name="unit" placeholder="Units (1-6)" required>
            <input type="text" name="lecturer" placeholder="Lecturer Name">
            <button type="submit">Add Course</button>
        </form>

        <div class="table-container" style="margin-top:20px;">
            <table>
                <thead>
                    <tr><th>Code</th><th>Course</th><th>Units</th></tr>
                </thead>
                <tbody>
                    <?php foreach($courses as $c): ?>
                    <tr><td><?= $c['code'] ?></td><td><?= $c['name'] ?></td><td><?= $c['unit'] ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
