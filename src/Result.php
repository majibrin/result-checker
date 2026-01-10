<?php
require_once __DIR__ . '/Database.php';

class Result {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($student_id, $course_id, $mark, $semester) {
        $student_id = (int)$student_id;
        $course_id = (int)$course_id;
        $mark = (float)$mark;
        $semester = $this->db->escape($semester);

        $sql = "INSERT INTO results (student_id, course_id, mark, semester) 
                VALUES ($student_id, $course_id, $mark, '$semester')
                ON DUPLICATE KEY UPDATE mark = $mark";
        return $this->db->query($sql);
    }

    public function getByStudent($student_id) {
        $student_id = (int)$student_id;
        $sql = "SELECT r.*, c.name as course_name, c.code as course_code, c.unit 
                FROM results r 
                JOIN courses c ON r.course_id = c.id 
                WHERE r.student_id = $student_id";
        $res = $this->db->query($sql);
        $data = [];
        while($row = $res->fetch_assoc()) { $data[] = $row; }
        return $data;
    }

    public static function getGradeInfo($mark) {
        if ($mark >= 70) return ['grade' => 'A', 'point' => 5];
        if ($mark >= 60) return ['grade' => 'B', 'point' => 4];
        if ($mark >= 50) return ['grade' => 'C', 'point' => 3];
        if ($mark >= 45) return ['grade' => 'D', 'point' => 2];
        if ($mark >= 40) return ['grade' => 'E', 'point' => 1];
        return ['grade' => 'F', 'point' => 0];
    }
}
