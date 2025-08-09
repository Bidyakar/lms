<?php
include('dbcon.php'); // This should create a $conn MySQLi connection

$id = $_GET['id'];

// Prepare statement
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: users.php');
    exit();
} else {
    die("Error deleting user: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
