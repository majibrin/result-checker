<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Student.php';

// 1️⃣ Connect to the database
$db = new Database();

// 2️⃣ Create a Student object
$student = new Student();

// 3️⃣ Fetch all students
$allStudents = $student->getAll();

// 4️⃣ Print them
echo "===== All Students =====\n";
foreach ($allStudents as $s) {
    echo "ID: {$s['id']}, Reg No: {$s['reg_no']}, Name: {$s['first_name']} {$s['last_name']}, Dept: {$s['department']}, Level: {$s['level']}\n";
}

// 5️⃣ Close connections
$student->close();
$db->close();