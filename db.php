<?php
// Database Connection

$servername = "localhost";
$username = "root";
$password = "2003";      
$database = "visitor_management";

// Create Connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>