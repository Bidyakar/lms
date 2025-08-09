<?php
include('dbcon.php'); // assumes $conn is your MySQLi connection

$id = $_GET['id'];

// Prepare statement to avoid SQL injection
$stmt = $conn->prepare("DELETE FROM member WHERE member_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: member.php');
    exit();
} else {
    die("Error deleting record: " . $conn->error);
}

$stmt->close();
$conn->close();
?>
