<?php

class Connect
{
    private const servername = "localhost";
    private const username = "root";
    private const password = "";
    private const database = "crud";

    private $conn;
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . (self::servername) . ";dbname=" . (self::database), (self::username), (self::password));
            // Set the PDO error mode exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERROR: Could not connect. " . $e->getMessage());
        }

    }

    public function getConn(): PDO{
        return $this->conn;
    }
}

?>