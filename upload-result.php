<?php
session_start();
// Security: Only Admins or Lecturers allowed
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'lecturer'])) {
    header("Location: login.php"); 
    exit;
}

require_once 'src/Student.php';
require_once 'src/Course.php';
require_once 'src/Result.php';

$db = new Database();
$msg = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $r = new Result();
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $mark = $_POST['mark'];
    $semester = $_POST['semester'];

    if ($r->create($student_id, $course_id, $mark, $semester)) {
        $msg = "✅ Result Saved Successfully!";
    } else {
        $msg = "❌ Error: Could not save record.";
    }
}

$students = (new Student())->getAll();
$courses = (new Course())->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Student Result</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <nav>
        <span><i class="fa-solid fa-user-shield"></i> Admin Portal</span>
        <div style="float:right;">
            <a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 style="color: var(--primary); margin-bottom: 20px;">
                <i class="fa-solid fa-upload" style="color: var(--secondary);"></i> Upload Student Result
            </h2>

            <?php if($msg): ?>
                <div style="margin-bottom: 15px; font-weight: bold; color: var(--secondary);">
                    <?= $msg ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div style="text-align: left;">
                    <label><i class="fa-solid fa-user-graduate"></i> Select Student</label>
                    <select name="student_id" required>
                        <option value="">-- Choose Student --</option>
                        <?php foreach($students as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['reg_no'] ?> - <?= $s['first_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="text-align: left;">
                    <label><i class="fa-solid fa-book-open"></i> Select Course</label>
                    <select name="course_id" required>
                        <option value="">-- Choose Course --</option>
                        <?php foreach($courses as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['code'] ?> - <?= $c['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="text-align: left;">
                    <label><i class="fa-solid fa-marker"></i> Score / Mark</label>
                    <input type="number" step="0.01" name="mark" placeholder="e.g. 75" min="0" max="100" required>
                </div>

                <div style="text-align: left;">
                    <label><i class="fa-solid fa-calendar-check"></i> Academic Semester</label>
                    <input type="text" name="semester" placeholder="e.g. 2025/1st" required>
                </div>

                <button type="submit">
                    <i class="fa-solid fa-floppy-disk"></i> Save Result
                </button>
            </form>
            
            <div style="margin-top: 20px;">
                <a href="dashboard.php" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>