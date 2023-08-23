<?php  

$servername = "localhost";
$username = "root"; // change this to your username!
$password = ""; // change this to your username!
$dbname = "chat_app"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
