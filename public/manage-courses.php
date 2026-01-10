<?php
session_start();
require_once '../src/Course.php';

// ====== RBAC: Only admin ======
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$courseObj = new Course();
$message = '';

// Handle Add Course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $lecturer = $_POST['lecturer'];
    $code = $_POST['code'];

    if ($courseObj->create($name, $unit, $lecturer, $code)) {
        $message = "Course added successfully!";
    } else {
        $message = "Failed to add course.";
    }
}

// Handle Delete Course
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($courseObj->delete($id)) {
        $message = "Course deleted successfully!";
    } else {
        $message = "Failed to delete course.";
    }
}

// Fetch all courses
$allCourses = $courseObj->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Courses | Result Checker</title>
<link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
<?php include 'partials/navbar.php'; ?>

<main class="container">
    <h2>Manage Courses</h2>
    <?php if($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Add Course Form -->
    <form method="POST" class="form-card">
        <input type="hidden" name="action" value="add">
        <label>Course Name</label>
        <input type="text" name="name" required>

        <label>Unit</label>
        <input type="number" name="unit" min="1" max="6" required>

        <label>Lecturer</label>
        <input type="text" name="lecturer" required>

        <label>Course Code</label>
        <input type="text" name="code" required>

        <button type="submit">Add Course</button>
    </form>

    <!-- Courses Table -->
    <div class="table-card">
        <h3>All Courses</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Lecturer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allCourses as $c): ?>
                <tr>
                    <td><?php echo $c['id']; ?></td>
                    <td><?php echo $c['code']; ?></td>
                    <td><?php echo $c['name']; ?></td>
                    <td><?php echo $c['unit']; ?></td>
                    <td><?php echo $c['lecturer']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $c['id']; ?>" onclick="return confirm('Delete this course?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
</body>
</html>