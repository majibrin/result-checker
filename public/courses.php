<?php
require_once __DIR__ . '/../src/Course.php';
$course = new Course();
$courses = $course->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Courses | Result Checker</title>
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
        <a href="courses.php" class="active">Courses</a>
        <a href="results.php">Results</a>
    </nav>
    <button class="hamburger">&#9776;</button>
</header>

<main class="main-container">
    <h1>All Courses</h1>
    <?php if (empty($courses)): ?>
        <p>No courses found.</p>
    <?php else: ?>
        <div class="card-grid">
        <?php foreach ($courses as $c): ?>
            <div class="card">
                <h2><?= $c['name'] ?></h2>
                <p><strong>Code:</strong> <?= $c['code'] ?></p>
                <p><strong>Unit:</strong> <?= $c['unit'] ?></p>
                <p><strong>Lecturer:</strong> <?= $c['lecturer'] ?></p>
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