<?php 
ob_start();
session_start();
require 'classes/Admin_Class.php'; // Adjust the path as needed
$obj_admin = new Admin_Class();

if(isset($_GET['logout'])){
    $obj_admin->admin_logout();
}
?>
<?php

//$servername = "localhost"; // Replace with your server name
//$username = "u754249269_eprecision"; // Replace with your database username
//$password = "Server_101"; // Replace with your database password
//$dbname = "u754249269_etms_db"; // Replace with your database name

$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "u754249269_etms_db"; // Replace with your database name


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
