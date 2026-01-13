<?php
session_start();
// Ensure only students can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') { 
    header("Location: login.php"); 
    exit; 
}

require_once 'src/Student.php';
require_once 'src/Result.php';

$s_obj = new Student();
$r_obj = new Result();

// Ensure session user_id exists
$student = $s_obj->getById($_SESSION['user_id']);
$my_results = $r_obj->getByStudent($_SESSION['user_id']);

$total_units = 0;
$total_points = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <nav>
        <span><i class="fa-solid fa-graduation-cap"></i> Student Portal</span>
        <div style="float:right;">
            <a href="logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
        </div>
    </nav>

    <div class="container">
        <header style="margin-bottom: 20px;">
            <h2>Welcome, <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></h2>
            <p><i class="fa-solid fa-id-card"></i> Reg No: <?= $student['reg_no'] ?></p>
        </header>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-code"></i> Course Code</th>
                        <th><i class="fa-solid fa-star"></i> Mark</th>
                        <th><i class="fa-solid fa-ranking-star"></i> Grade</th>
                        <th><i class="fa-solid fa-calculators"></i> GP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($my_results as $res): 
                        $info = Result::getGradeInfo($res['mark']);
                        $total_units += $res['unit'];
                        $total_points += ($info['point'] * $res['unit']);
                    ?>
                    <tr>
                        <td><?= $res['course_code'] ?></td>
                        <td><?= $res['mark'] ?></td>
                        <td><strong><?= $info['grade'] ?></strong></td>
                        <td><?= $info['point'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="stats-grid" style="margin-top: 20px;">
            <div class="card">
                <i class="fa-solid fa-book fa-2x"></i>
                <h3><?= $total_units ?></h3>
                <p>Total Units</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-chart-column fa-2x"></i>
                <h3><?= ($total_units > 0) ? round($total_points / $total_units, 2) : '0.00' ?></h3>
                <p>Current GPA</p>
            </div>
        </div>
    </div>
</body>
</html>