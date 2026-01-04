<?php
require_once __DIR__ . '/Database.php';

class Result {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new result
    public function create($student_id, $course_id, $mark, $semester) {
        $student_id = (int)$student_id;
        $course_id = (int)$course_id;
        $mark = (float)$mark;
        $semester = $this->db->escape($semester);

        $sql = "INSERT INTO results (student_id, course_id, mark, semester) 
                VALUES ($student_id, $course_id, $mark, '$semester')";
        return $this->db->query($sql);
    }

    // Get a result by ID
    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM results WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    // Get all results
    public function getAll() {
        $sql = "SELECT * FROM results ORDER BY id ASC";
        $result = $this->db->query($sql);
        $results = [];
        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        return $results;
    }

    // Get all results for a specific student
    public function getByStudent($student_id) {
        $student_id = (int)$student_id;
        $sql = "SELECT r.*, c.name AS course_name, c.unit 
                FROM results r
                JOIN courses c ON r.course_id = c.id
                WHERE r.student_id = $student_id
                ORDER BY r.semester ASC";
        $result = $this->db->query($sql);
        $results = [];
        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        return $results;
    }

    // Delete a result
    public function delete($id) {
        $id = (int)$id;
        $sql = "DELETE FROM results WHERE id = $id";
        return $this->db->query($sql);
    }

    // Close connection
    public function close() {
        $this->db->close();
    }
}