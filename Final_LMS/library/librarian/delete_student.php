<?php
include('dbcon.php'); // Make sure this file creates $conn as MySQLi connection

$id = $_GET['id'];

// Prepare the DELETE statement
$stmt = $conn->prepare("DELETE FROM member WHERE member_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: member.php');
    exit();
} else {
    die("Error deleting member: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
