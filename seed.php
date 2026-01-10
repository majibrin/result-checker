<?php
require_once 'src/Database.php';
require_once 'src/Student.php';
require_once 'src/Course.php';
require_once 'src/Result.php';

$db = new Database();

// 1. Clear existing data (Careful!)
$db->query("SET FOREIGN_KEY_CHECKS = 0");
$db->query("TRUNCATE TABLE results");
$db->query("TRUNCATE TABLE courses");
$db->query("TRUNCATE TABLE students");
$db->query("SET FOREIGN_KEY_CHECKS = 1");

// 2. Add Test Students
$s = new Student();
$s->create('UG22/SCCS/1001', 'Umar', 'Faruk', 'Computer Science', 300);
$s->create('UG22/SCCS/1002', 'Zainab', 'Idris', 'Computer Science', 300);

// 3. Add Test Courses
$c = new Course();
$c->create('Database Management', 3, 'Dr. Abdullahi', 'CSC301');
$c->create('Software Engineering', 3, 'Prof. Jibril', 'CSC302');
$c->create('Data Structures', 2, 'Mal. Bello', 'CSC305');

// 4. Add Sample Results
$r = new Result();
// Umar (ID 1) results
$r->create(1, 1, 75, '2025/1st'); // A
$r->create(1, 2, 62, '2025/1st'); // B
$r->create(1, 3, 48, '2025/1st'); // D

echo "Database Seeded Successfully! \n";
echo "Admin Password is: password123 \n";
