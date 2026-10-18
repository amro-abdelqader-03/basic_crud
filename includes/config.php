<?php
define("servername","localhost");
define("username","root");
define("password","");
define("database","crud");

try {
    $conn = new PDO("mysql:host=".servername.";dbname=".database, username, password);
    // Set the PDO error mode exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
     die("ERROR: Could not connect. " . $e->getMessage());
}
?>