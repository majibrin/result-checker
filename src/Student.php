<?php
require_once __DIR__ . '/Database.php';

class Student {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Create a new student
    public function create($reg_no, $first_name, $last_name, $department, $level) {
        $reg_no = $this->db->escape($reg_no);
        $first_name = $this->db->escape($first_name);
        $last_name = $this->db->escape($last_name);
        $department = $this->db->escape($department);
        $level = (int)$level;

        $sql = "INSERT INTO students (reg_no, first_name, last_name, department, level) 
                VALUES ('$reg_no', '$first_name', '$last_name', '$department', $level)";
        return $this->db->query($sql);
    }

    // Get a student by ID
    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM students WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // Get all students
    public function getAll() {
        $sql = "SELECT * FROM students ORDER BY reg_no ASC";
        $result = $this->db->query($sql);
        $students = [];
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    }

    // Delete a student
    public function delete($id) {
        $id = (int)$id;
        $sql = "DELETE FROM students WHERE id = $id";
        return $this->db->query($sql);
    }

    // Close connection
    public function close() {
        $this->db->close();
    }
}