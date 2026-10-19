<?php
require_once("includes/database.php");
include("includes/functions.php");

$id = $_POST["id"];

if (isset($_POST["username"])) {
    $db = new Database();
    if($db->editUser( $id, $_POST["username"], $_POST["email"])){
        header("location: index.php");
        exit();
    }else{
        echo "<p>Something wrong</p>";
    }
}
?>

<div>
    <form method="POST">
        <label>username:</label><br><br>
        <input type="text" name="username" required><br><br>
        <label>email:</label><br><br>
        <input type="email" name="email" required><br><br>
        <button type="submit" name="id" value="<?= $id ?>">submit</button>
    </form>
</div>