<?php
include('dbcon.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $stmt = $conn->prepare("DELETE FROM member WHERE member_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: member.php');
        exit();
    } else {
        die("Error deleting member: " . $stmt->error);
    }

    $stmt->close();
} else {
    die("Invalid request: ID not set.");
}
?>
