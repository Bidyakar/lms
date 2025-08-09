<?php
$servername = "localhost";
$username = "root";        // Usually 'root' on XAMPP
$password = "";            // Usually empty password on XAMPP
$dbname = "eb_lms"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
