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

// Handle form submission for adding a course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

// Fetch all courses for display
$allCourses = $courseObj->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Courses | Result Checker</title>
<link rel="stylesheet" href="../public/css/dashboard.css">
<style>
/* ====== Modular Form & Table Card ====== */
.container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
}

.form-card, .table-card {
    background-color: #f9fafb;
    padding: 1.5rem;
    border-radius: 0.8rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 0.4rem;
}

.form-card input {
    padding: 0.6rem;
    border-radius: 0.4rem;
    border: 1px solid #ccc;
    font-size: 1rem;
}

.form-card button {
    background-color: #2f855a; /* green */
    color: white;
    border: none;
    padding: 0.7rem;
    border-radius: 0.5rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s;
}

.form-card button:hover {
    background-color: #276749;
}

/* Table Styles */
.table-card table {
    width: 100%;
    border-collapse: collapse;
}

.table-card th, .table-card td {
    padding: 0.8rem;
    border: 1px solid #ddd;
    text-align: left;
}

.table-card th {
    background-color: #f0fdf4; /* light green */
}

.table-card td button {
    padding: 0.3rem 0.6rem;
    border-radius: 0.4rem;
    border: none;
    background-color: #e53e3e; /* red for delete */
    color: white;
    cursor: pointer;
    font-size: 0.9rem;
}

.table-card td button:hover {
    background-color: #9b2c2c;
}

/* ====== Messages ====== */
.message {
    background-color: #e6ffed; /* success green */
    color: #027a48;
    padding: 0.8rem;
    margin: 1rem 0;
    border-radius: 0.5rem;
    border: 1px solid #027a48;
    font-weight: 500;
}

.message.error {
    background-color: #ffe6e6;
    color: #c53030;
    border-color: #c53030;
}

/* ====== Mobile First ====== */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
        margin: 1rem;
    }

    .table-card table, .table-card th, .table-card td {
        display: block;
        width: 100%;
    }

    .table-card th {
        display: none;
    }

    .table-card td {
        border: none;
        position: relative;
        padding-left: 50%;
        margin-bottom: 0.5rem;
    }

    .table-card td::before {
        position: absolute;
        left: 1rem;
        top: 0.5rem;
        content: attr(data-label);
        font-weight: 600;
    }
}
</style>
</head>
<body>
<?php include 'partials/navbar.php'; ?>

<main class="container">
    <h2>Manage Courses</h2>

    <?php if($message): ?>
        <div class="message <?php echo strpos($message,'Failed')!==false ? 'error':''; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Add Course Form -->
    <form method="POST" class="form-card">
        <h3>Add New Course</h3>
        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Course Unit</label>
            <input type="number" name="unit" required>
        </div>
        <div class="form-group">
            <label>Lecturer</label>
            <input type="text" name="lecturer" required>
        </div>
        <div class="form-group">
            <label>Course Code</label>
            <input type="text" name="code" required>
        </div>
        <button type="submit">Add Course</button>
    </form>

    <!-- Courses Table -->
    <div class="table-card">
        <h3>Existing Courses</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Lecturer</th>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allCourses as $course): ?>
                <tr>
                    <td data-label="ID"><?php echo $course['id']; ?></td>
                    <td data-label="Name"><?php echo $course['name']; ?></td>
                    <td data-label="Unit"><?php echo $course['unit']; ?></td>
                    <td data-label="Lecturer"><?php echo $course['lecturer']; ?></td>
                    <td data-label="Code"><?php echo $course['code']; ?></td>
                    <td data-label="Action">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" onclick="return confirm('Delete this course?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'partials/footer.php'; ?>

<script>
// Auto-hide messages after 5 seconds
const msg = document.querySelector('.message');
if(msg){
    setTimeout(()=>{ msg.style.display = 'none'; }, 5000);
}
</script>
</body>
</html>