<?php
require_once __DIR__ . '/../src/Result.php';
require_once __DIR__ . '/../src/Student.php';
require_once __DIR__ . '/../src/Course.php';

$resultObj = new Result();
$results = $resultObj->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Results | Result Checker</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/components.css">
<link rel="stylesheet" href="css/responsive.css">
</head>
<body>

<header class="navbar">
    <div class="brand">Result Checker</div>
    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="students.php">Students</a>
        <a href="courses.php">Courses</a>
        <a href="results.php" class="active">Results</a>
    </nav>
    <button class="hamburger">&#9776;</button>
</header>

<main class="main-container">
    <h1>All Results</h1>
    <?php if (empty($results)): ?>
        <p>No results found.</p>
    <?php else: ?>
        <div class="card-grid">
        <?php foreach ($results as $r): ?>
            <div class="card">
                <p><strong>Student ID:</strong> <?= $r['student_id'] ?></p>
                <p><strong>Course ID:</strong> <?= $r['course_id'] ?></p>
                <p><strong>Mark:</strong> <?= $r['mark'] ?></p>
                <p><strong>Semester:</strong> <?= $r['semester'] ?></p>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<footer class="footer">
    &copy; <?= date('Y') ?> Gombe State University | Result Checker
</footer>

<script src="js/scripts.js"></script>
</body>
</html>