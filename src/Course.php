<?php
require_once __DIR__ . '/Database.php';

class Course {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Create a new course
    public function create($name, $unit, $lecturer, $code) {
        $name = $this->db->escape($name);
        $unit = (int)$unit;
        $lecturer = $this->db->escape($lecturer);
        $code = $this->db->escape($code);

        $sql = "INSERT INTO courses (name, unit, lecturer, code) 
                VALUES ('$name', $unit, '$lecturer', '$code')";
        return $this->db->query($sql);
    }

    // Get a course by ID
    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM courses WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // Get all courses
    public function getAll() {
        $sql = "SELECT * FROM courses ORDER BY code ASC";
        $result = $this->db->query($sql);
        $courses = [];
        while($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
        return $courses;
    }

    // Delete a course
    public function delete($id) {
        $id = (int)$id;
        $sql = "DELETE FROM courses WHERE id = $id";
        return $this->db->query($sql);
    }

    // Close connection
    public function close() {
        $this->db->close();
    }
}