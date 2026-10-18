<?php
require_once("includes/config.php");
include("includes/functions.php");
$error_message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["email"])){
        $error_message = "Email is required";
    }
    if(empty($_POST["password"])){
        $error_message = "Password is required";
    }
    if(!empty($error_message)){
        displayErr($error_message);
    }else{
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if(login($email, $password)){
            header("Location: index.php");
            exit();
        }
        else{
            displayErr("incorrect Email or Password ");
        }
    }
}
?>

<div>
    <form method="POST">
        <label>email</label><br><br>
        <input type="text" name="email" required><br><br>
        <label>password</label><br><br>
        <input type="password" name="password" required><br><br>
        <input type="submit">
    </form>
    <p>Don't have an acconut ? </p>
    <a href="registration.php">Sign Up</a>
</div>