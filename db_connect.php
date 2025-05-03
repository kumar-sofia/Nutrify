<?php
// Database connection 
$servername = "localhost";
$username = "root";
$password = ""; // default DB password
$dbname = "sofia"; // database name created

// Create connection with the databse
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection with the databse
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

