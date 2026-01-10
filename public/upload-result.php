<?php
session_start();
require_once '../src/Result.php';
require_once '../src/Student.php';
require_once '../src/Course.php';

// ====== RBAC: Only admin ======
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$resultObj = new Result();
$studentObj = new Student();
$courseObj = new Course();
$message = '';

// Handle Result Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int)$_POST['student_id'];
    $course_id = (int)$_POST['course_id'];
    $mark = (float)$_POST['mark'];
    $semester = $_POST['semester'];

    if ($resultObj->create($student_id, $course_id, $mark, $semester)) {
        $message = "Result uploaded successfully!";
    } else {
        $message = "Failed to upload result.";
    }
}

// Fetch students & courses
$allStudents = $studentObj->getAll();
$allCourses = $courseObj->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Result | Result Checker</title>
<link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
<?php include 'partials/navbar.php'; ?>

<main class="container">
    <h2>Upload Result</h2>
    <?php if($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" class="form-card">
        <label>Select Student</label>
        <select name="student_id" required>
            <option value="">--Choose Student--</option>
            <?php foreach($allStudents as $s): ?>
            <option value="<?php echo $s['id']; ?>">
                <?php echo "{$s['reg_no']} - {$s['first_name']} {$s['last_name']}"; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Select Course</label>
        <select name="course_id" required>
            <option value="">--Choose Course--</option>
            <?php foreach($allCourses as $c): ?>
            <option value="<?php echo $c['id']; ?>">
                <?php echo "{$c['code']} - {$c['name']}"; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Mark</label>
        <input type="number" name="mark" min="0" max="100" step="0.01" required>

        <label>Semester</label>
        <input type="text" name="semester" placeholder="2025/1st" required>

        <button type="submit">Upload Result</button>
    </form>
</main>

<?php include 'partials/footer.php'; ?>
</body>
</html>