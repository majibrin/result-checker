<?php
session_start();
require_once '../src/Student.php';
require_once '../src/Course.php';
require_once '../src/Result.php';

// ====== RBAC: Redirect if not admin ======
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// ====== Fetch Data ======
$studentObj = new Student();
$courseObj = new Course();
$resultObj = new Result();

$totalStudents = count($studentObj->getAll());
$totalCourses = count($courseObj->getAll());
$totalResults = count($resultObj->getAll());

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Result Checker</title>
<link rel="stylesheet" href="../public/css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<!-- Navbar -->
<header class="navbar">
    <div class="logo">Result Checker 💚</div>
    <nav>
        <ul>
            <li><a href="admin-dashboard.php">Dashboard</a></li>
            <li><a href="manage-students.php">Students</a></li>
            <li><a href="manage-courses.php">Courses</a></li>
            <li><a href="manage-results.php">Results</a></li>
            <li><a href="manage-admins.php">Admins</a></li>
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
            <i class="fas fa-users fa-2x"></i>
            <div class="card-info">
                <h3>Total Students</h3>
                <p><?php echo $totalStudents; ?></p>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-book fa-2x"></i>
            <div class="card-info">
                <h3>Total Courses</h3>
                <p><?php echo $totalCourses; ?></p>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-file-alt fa-2x"></i>
            <div class="card-info">
                <h3>Total Results</h3>
                <p><?php echo $totalResults; ?></p>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-calendar fa-2x"></i>
            <div class="card-info">
                <h3>Active Semesters</h3>
                <p>2025/1st</p>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="actions">
            <a href="add-student.php" class="action-card"><i class="fas fa-user-plus fa-2x"></i> Add Student</a>
            <a href="add-course.php" class="action-card"><i class="fas fa-book-medical fa-2x"></i> Add Course</a>
            <a href="upload-result.php" class="action-card"><i class="fas fa-upload fa-2x"></i> Upload Result</a>
        </div>
    </section>

    <!-- Recent Activities -->
    <section class="recent">
        <h3>Recent Students Added</h3>
        <table style="width:100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="background:#2ecc71; color:#fff;">
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $recentStudents = array_slice($studentObj->getAll(), -5); // last 5 students
            foreach($recentStudents as $s): ?>
                <tr style="background:#fff; border-bottom:1px solid #ccc;">
                    <td><?php echo $s['reg_no']; ?></td>
                    <td><?php echo $s['first_name'].' '.$s['last_name']; ?></td>
                    <td><?php echo $s['department']; ?></td>
                    <td><?php echo $s['level']; ?></td>
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