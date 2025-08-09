<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "your_database_name";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
