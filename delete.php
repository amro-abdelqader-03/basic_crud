<?php
require_once("includes/config.php");
include("includes/functions.php");
if(isset($_POST["id"])){
    $id = $_POST["id"];
    deleteUser( $id);
}
?>