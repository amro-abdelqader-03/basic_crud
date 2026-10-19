<?php
require_once("includes/database.php");
include("includes/functions.php");
if(isset($_POST["id"])){
    $id = $_POST["id"];
    $db = new Database();
    if($db->deleteUser( $id)) {
        header("location: index.php");
        exit();
    }else{
        echo "<p>Something wrong</p>";
    }
}
?>