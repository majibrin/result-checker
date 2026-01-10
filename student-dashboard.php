<?php
session_start();
if ($_SESSION['role'] !== 'student') { header("Location: login.php"); exit; }
require_once 'src/Student.php';
require_once 'src/Result.php';

$s_obj = new Student();
$r_obj = new Result();
$student = $s_obj->getById($_SESSION['user_id']);
$my_results = $r_obj->getByStudent($_SESSION['user_id']);

$total_units = 0;
$total_points = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>My Results</title>
</head>
<body>
    <h2><i class="fa-solid fa-user-graduate"></i> <?= $student['first_name'] ?>'s Results</h2>
    <table border="1" width="100%" style="text-align:center;">
        <tr style="background:#eee;">
            <th>Code</th>
            <th>Mark</th>
            <th>Grade</th>
            <th>GP</th>
        </tr>
        <?php foreach($my_results as $res): 
            $info = Result::getGradeInfo($res['mark']);
            $total_units += $res['unit'];
            $total_points += ($info['point'] * $res['unit']);
        ?>
        <tr>
            <td><?= $res['course_code'] ?></td>
            <td><?= $res['mark'] ?></td>
            <td><?= $info['grade'] ?></td>
            <td><?= $info['point'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <div style="margin-top:20px; padding:10px; background:#f9f9f9; border-left:5px solid green;">
        <strong><i class="fa-solid fa-chart-line"></i> Summary:</strong><br>
        Total Units: <?= $total_units ?><br>
        GPA: <?= ($total_units > 0) ? round($total_points / $total_units, 2) : '0.00' ?>
    </div>
    <br>
    <a href="logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
</body>
</html>
