-- =========================================
-- Result Checker SQL Setup
-- Run this once to create database + tables
-- =========================================

-- 1️⃣ Create the database
CREATE DATABASE IF NOT EXISTS result_checker;
USE result_checker;

-- =========================================
-- 2️⃣ Students table
-- =========================================
CREATE TABLE IF NOT EXISTS students (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reg_no VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    department VARCHAR(50) NOT NULL,
    level TINYINT(3) DEFAULT 100
) ENGINE=InnoDB;

-- =========================================
-- 3️⃣ Courses table
-- =========================================
CREATE TABLE IF NOT EXISTS courses (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    unit TINYINT(2) NOT NULL,
    lecturer VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- =========================================
-- 4️⃣ Results table
-- =========================================
CREATE TABLE IF NOT EXISTS results (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    mark DECIMAL(5,2) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================
-- 5️⃣ Admins table
-- =========================================
CREATE TABLE IF NOT EXISTS admins (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'lecturer') DEFAULT 'lecturer'
) ENGINE=InnoDB;

-- =========================================
-- 6️⃣ Sample Data
-- =========================================

-- Sample Students
INSERT INTO students (reg_no, first_name, last_name, department, level)
VALUES 
('UG22/SCCS/1007', 'Muhammad', 'Jibrin', 'Computer Science', 300),
('UG22/SCCS/1008', 'Aisha', 'Mohammed', 'Computer Science', 300);

-- Sample Courses
INSERT INTO courses (name, unit, lecturer, code)
VALUES
('Database Systems', 3, 'Dr. Aliyu', 'CS301'),
('Data Structures', 3, 'Dr. Musa', 'CS302');

-- Sample Results
INSERT INTO results (student_id, course_id, mark, semester)
VALUES
(1, 1, 87.5, '2025/1st'),
(1, 2, 92.0, '2025/1st'),
(2, 1, 78.0, '2025/1st'),
(2, 2, 85.0, '2025/1st');

-- Sample Admins (passwords must be hashed later in PHP)
INSERT INTO admins (username, password, role)
VALUES
('admin', '$2y$10$examplehash...', 'admin'),
('lecturer1', '$2y$10$examplehash...', 'lecturer');