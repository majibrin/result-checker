<?php
session_start();
require_once '../src/Student.php';
require_once '../src/Result.php';

// ====== RBAC: Redirect if not student ======
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit();
}

// ====== Fetch Data ======
$studentId = $_SESSION['user_id']; // Assume user_id stored in session
$studentObj = new Student();
$resultObj = new Result();

$student = $studentObj->getById($studentId);
$results = $resultObj->getByStudent($studentId);

// Calculate GPA (simple average)
$totalMarks = 0;
$totalCourses = count($results);
foreach($results as $r){
    $totalMarks += $r['mark'];
}
$currentGPA = $totalCourses > 0 ? round($totalMarks / $totalCourses, 2) : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard | Result Checker</title>
<link rel="stylesheet" href="../public/css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<!-- Navbar -->
<header class="navbar">
    <div class="logo">Result Checker 💚</div>
    <nav>
        <ul>
            <li><a href="student-dashboard.php">Dashboard</a></li>
            <li><a href="view-results.php">View Results</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <div class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
</header>

<!-- Main Dashboard -->
<main class="container">
    <!-- Stats Cards -->
    <section class="cards">
        <div class="card">
            <i class="fas fa-book fa-2x"></i>
            <div class="card-info">
                <h3>Courses Taken</h3>
                <p><?php echo $totalCourses; ?></p>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-file-alt fa-2x"></i>
            <div class="card-info">
                <h3>Total Results</h3>
                <p><?php echo $totalCourses; ?></p>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-chart-line fa-2x"></i>
            <div class="card-info">
                <h3>Current GPA</h3>
                <p><?php echo $currentGPA; ?></p>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-user-graduate fa-2x"></i>
            <div class="card-info">
                <h3>Level / Session</h3>
                <p><?php echo $student['level']; ?> / 2025/1st</p>
            </div>
        </div>
    </section>

    <!-- Results Table -->
    <section class="recent">
        <h3>Your Results</h3>
        <table style="width:100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="background:#2ecc71; color:#fff;">
                    <th>Course</th>
                    <th>Unit</th>
                    <th>Mark</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($results as $r): ?>
                <tr style="background:#fff; border-bottom:1px solid #ccc;">
                    <td><?php echo $r['course_name']; ?></td>
                    <td><?php echo $r['unit']; ?></td>
                    <td><?php echo $r['mark']; ?></td>
                    <td>
                        <?php
                            if($r['mark'] >= 70) echo 'A';
                            elseif($r['mark'] >= 60) echo 'B';
                            elseif($r['mark'] >= 50) echo 'C';
                            elseif($r['mark'] >= 45) echo 'D';
                            else echo 'F';
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<!-- Footer -->
<footer>
    <p>© <?php echo date('Y'); ?> Result Checker. All rights reserved.</p>
    <div class="social">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
</footer>

<!-- JS -->
<script>
const hamburger = document.getElementById('hamburger');
const navUl = document.querySelector('nav ul');
hamburger.addEventListener('click', () => {
    navUl.classList.toggle('show');
});
</script>
</body>
</html>