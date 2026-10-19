<?php

require_once("includes/database.php");
include("includes/functions.php");

session_start();
if (!isset($_SESSION['userID'])) {
    header("location: login.php");
}

$db = new Database();

$username = $db->getUsername($_SESSION['userID']);
echo "<p> Welcome Back ! " .  htmlspecialchars($username ? $username : "User")  . "</p>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
    header("location: login.php");
}
?>

<div>
    <form method="POST">
        <button type="submit">Log out</button>
    </form>
</div>

<?php
if($db->isAdmin($_SESSION['userID'])){
    buildUsersTable($_SESSION['userID']);
} 
?>