<?php

namespace classes;

class TableCreator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createApplicantTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS applicant (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(30) NOT NULL,
            last_name VARCHAR(30) NOT NULL,
            birth_date DATE NOT NULL,
            email VARCHAR(50) NOT NULL,
            education VARCHAR(20) NOT NULL,
            attachment1 VARCHAR(100) NOT NULL,
            attachment2 VARCHAR(100) NOT NULL,
            attachment3 VARCHAR(100) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if ($this->conn->query($sql) === false) {
            die("Error creating 'applicant' table: " . $this->conn->error);
        }
    }

    public function createInternshipsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS internships (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            applicant_id INT(6) UNSIGNED,
            company VARCHAR(50) NOT NULL,
            start_date DATE NOT NULL,
            end_date DATE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (applicant_id) REFERENCES applicant(id)
        )";

        if ($this->conn->query($sql) === false) {
            die("Error creating 'internships' table: " . $this->conn->error);
        }
    }
}