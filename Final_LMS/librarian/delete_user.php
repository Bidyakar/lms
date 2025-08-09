<?php
include('dbcon.php'); // this file should set up the $conn (mysqli) connection

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Use prepared statement for security
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: users.php");
        exit();
    } else {
        die("Error deleting user: " . $conn->error);
    }
} else {
    die("Invalid request.");
}
?>
