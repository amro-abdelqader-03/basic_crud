<?php
require_once("includes/database.php");
require_once("includes/auth.php");
include("includes/functions.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();
    if (empty($_POST["username"])) {
        $error_message = "Username is required";
    } elseif (empty($_POST["email"])) {
        $error_message = "Email is required";
    } elseif (empty($_POST["password"])) {
        $error_message = "Password is required";
    } elseif (empty($_POST["conf-pass"])) {
        $error_message = "Confirm password is required";
    } elseif ($_POST["conf-pass"] !== $_POST["password"]) {
        $error_message = "The passwords must match";
    } elseif( !$db->validateUsername($_POST["username"]) ) {
        $error_message = "The username is already exist";
    } elseif (!$db->validateEmail(trim($_POST["email"]))) {
        $error_message = "The email is already exist";
    }

    if (!empty($error_message)) {
        displayErr($error_message);
    } else {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $created_at = date("Y-m-d H:i:s");

        $auth = new Auth();
        $auth->registrer($username, $email, $password, $created_at);
    }
}
?>


<div>
    <form method="post">
        <label>Username</label><br><br>
        <input type="text" name="username">
        <br><br>

        <label>Email</label><br><br>
        <input type="email" name="email">
        <br><br>

        <label>Password</label><br><br>
        <input type="password" name="password">
        <br><br>

        <label>Confirm Password</label><br><br>
        <input type="password" name="conf-pass">
        <br><br>

        <input type="submit" value="Sign Up">
    </form>
    <p>already have an acconut ? </p>
    <a href="login.php">login</a>
</div>