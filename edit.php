<?php
require_once("includes/config.php");
include("includes/functions.php");

$id = $_POST["id"];

if (isset($_POST["username"])) {
    editUser( $id, $_POST["username"], $_POST["email"]);
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