<?php  
require_once "db_connect.php";

if(isset($_POST['attemptLogin'])){
    die(json_encode(["content" => "i worked sir"]));
}
?>
