<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'lecturer'])) {
    header("Location: login.php"); exit;
}
require_once 'src/Student.php';
require_once 'src/Course.php';
require_once 'src/Result.php';

$db = new Database();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $r = new Result();
    $r->create($_POST['student_id'], $_POST['course_id'], $_POST['mark'], $_POST['semester']);
    $msg = "Record Saved!";
}
$students = (new Student())->getAll();
$courses = (new Course())->getAll();
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Upload Result</h2>
    <?php if(isset($msg)) echo $msg; ?>
    <form method="POST">
        <select name="student_id"><?php foreach($students as $s) echo "<option value='{$s['id']}'>{$s['reg_no']}</option>"; ?></select>
        <select name="course_id"><?php foreach($courses as $c) echo "<option value='{$c['id']}'>{$c['code']}</option>"; ?></select>
        <input type="number" step="0.01" name="mark" placeholder="Mark">
        <input type="text" name="semester" placeholder="Semester">
        <button type="submit">Upload</button>
    </form>
    <a href="dashboard.php">Back</a>
</body>
</html>
