<?php

require_once("includes/config.php");
include("includes/functions.php");

session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

echo '<p>Welcome Back ! ' . $_SESSION['username'] . '</p>';

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