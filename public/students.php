<?php
require_once __DIR__ . '/../src/Student.php';

$student = new Student();
$students = $student->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h1>Students List</h1>

<?php if (empty($students)): ?>
    <p>No students found.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Reg No</th>
            <th>Name</th>
            <th>Department</th>
            <th>Level</th>
        </tr>

        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= $s['reg_no'] ?></td>
                <td><?= $s['first_name'] . ' ' . $s['last_name'] ?></td>
                <td><?= $s['department'] ?></td>
                <td><?= $s['level'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>