<?php
// Database credentials
$host = "localhost";  
$user = "root";       
$password = "";       
$database = "jobquest2"; 

// Create a database connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set character encoding to avoid encoding issues
mysqli_set_charset($conn, "utf8");

?>
