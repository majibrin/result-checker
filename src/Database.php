<?php
require_once __DIR__ . '/../config/config.php';

class Database {
    private $conn;

    // Constructor: connects to the DB
    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    // Execute a query
    public function query($sql) {
        return $this->conn->query($sql);
    }

    // Prepare and execute a statement
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    // Escape string for safety
    public function escape($str) {
        return $this->conn->real_escape_string($str);
    }

    // Close connection
    public function close() {
        $this->conn->close();
    }
}
