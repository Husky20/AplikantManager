<?php

class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->conn = new mysqli($this->host, $this->username, $this->password);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createDatabase()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;
        if ($this->conn->query($sql) === false) {
            die("Error creating database: " . $this->conn->error);
        }
        $this->conn->select_db($this->dbname);
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}