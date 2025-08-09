<?php
include('dbcon.php');  

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid request');
}

$id = (int)$_GET['id'];  

$stmt = $conn->prepare("UPDATE book SET status = 'Archive' WHERE book_id = ?");
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    
    header('Location: books.php');
    exit();
} else {
    die('Failed to archive book or book not found.');
}
?>
