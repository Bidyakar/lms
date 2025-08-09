<?php
include('dbcon.php'); // assumes $conn is the MySQLi connection object

$id = $_GET['id'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("UPDATE book SET status = 'Archive' WHERE book_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: books.php');
    exit();
} else {
    die("Error updating record: " . $conn->error);
}

$stmt->close();
$conn->close();
?>
