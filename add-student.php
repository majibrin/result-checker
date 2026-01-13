<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
require_once 'src/Student.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s = new Student();
    
    $res = $s->create(
    $_POST['reg_no'], 
    $_POST['first_name'], 
    $_POST['last_name'], 
    $_POST['department'], 
    $_POST['level'], 
    'password123' // You can set a default or take from a form input
);
    $msg = $res ? "Student Added Successfully" : "Error adding student";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <nav>
        <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </nav>
    <div class="container">
        <form method="POST">
            <h2><i class="fa-solid fa-user-plus"></i> Register Student</h2>
            <?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
            <input type="text" name="reg_no" placeholder="Reg Number (e.g. UG22/1001)" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="department" placeholder="Department" required>
            <select name="level">
                <option value="100">100 Level</option>
                <option value="200">200 Level</option>
                <option value="300">300 Level</option>
                <option value="400">400 Level</option>
            </select>
            <button type="submit">Save Student</button>
        </form>
    </div>
</body>
</html>
