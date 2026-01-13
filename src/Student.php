<?php
require_once __DIR__ . '/Database.php';

class Student {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Create a new student with a hashed password
    public function create($reg_no, $first_name, $last_name, $department, $level, $password = 'password123') {
        $reg_no = $this->db->escape($reg_no);
        $first_name = $this->db->escape($first_name);
        $last_name = $this->db->escape($last_name);
        $department = $this->db->escape($department);
        $level = (int)$level;
        
        // Hash the password before saving
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Note the backticks around `password` keyword
        $sql = "INSERT INTO students (reg_no, first_name, last_name, department, level, `password`) 
                VALUES ('$reg_no', '$first_name', '$last_name', '$department', $level, '$hashed_password')";
        
        return $this->db->query($sql);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM students WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // New helper method for login
    public function getByRegNo($reg_no) {
        $reg_no = $this->db->escape($reg_no);
        $sql = "SELECT * FROM students WHERE reg_no = '$reg_no'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function getAll() {
        $sql = "SELECT * FROM students ORDER BY reg_no ASC";
        $result = $this->db->query($sql);
        $students = [];
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    }

    public function delete($id) {
        $id = (int)$id;
        $sql = "DELETE FROM students WHERE id = $id";
        return $this->db->query($sql);
    }

    public function close() {
        $this->db->close();
    }
}