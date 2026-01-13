<?php
require_once 'src/Database.php';
require_once 'src/Student.php';
require_once 'src/Course.php';
require_once 'src/Result.php';

$db = new Database();

// 1. Clear existing data
$db->query("SET FOREIGN_KEY_CHECKS = 0");
$db->query("TRUNCATE TABLE results");
$db->query("TRUNCATE TABLE courses");
$db->query("TRUNCATE TABLE students");
$db->query("TRUNCATE TABLE admins");
$db->query("SET FOREIGN_KEY_CHECKS = 1");

// Generate a default hash for "password123"
$defaultPassword = password_hash('password123', PASSWORD_DEFAULT);

// 2. Add Test Students (Now with Password field)
// Note: Ensure your Student::create method is updated to accept the password hash
$db->query("INSERT INTO students (reg_no, first_name, last_name, department, level, `password`) VALUES 
('UG22/SCCS/1001', 'Umar', 'Faruk', 'Computer Science', 300, '$defaultPassword'),
('UG22/SCCS/1002', 'Zainab', 'Idris', 'Computer Science', 300, '$defaultPassword')");

// 3. Add Test Courses
$c = new Course();
$c->create('Database Management', 3, 'Dr. Abdullahi', 'CSC301');
$c->create('Software Engineering', 3, 'Prof. Jibril', 'CSC302');
$c->create('Data Structures', 2, 'Mal. Bello', 'CSC305');

// 4. Add Sample Results
$r = new Result();
// Umar (ID 1) results
$r->create(1, 1, 75, '2025/1st'); 
$r->create(1, 2, 62, '2025/1st'); 
$r->create(1, 3, 48, '2025/1st'); 

// 5. Add Admins (Using backticks for password keyword)
$db->query("INSERT INTO admins (username, `password`, role) VALUES 
('admin', '$defaultPassword', 'admin'),
('lecturer1', '$defaultPassword', 'lecturer')");

echo "--------------------------------------\n";
echo "✅ Database Seeded Successfully!\n";
echo "--------------------------------------\n";
echo "Default Password for all: password123\n";
echo "Admin Username: admin\n";
echo "Student Username: UG22/SCCS/1001\n";
echo "--------------------------------------\n";