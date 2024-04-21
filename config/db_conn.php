<?php 
$host = "localhost";
$username = "root";
$password = "";
$database = "inventory_db";

$conn = new mysqli($host, $username, $password, $database);

//Check the connection
if($conn->connect_error){
    die("Connection failed: " . $connect_error);
};
?>