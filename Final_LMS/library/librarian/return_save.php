<?php
include('dbcon.php');

$id = $_GET['id'];
$book_id = $_GET['book_id'];

// Prepare the UPDATE query with JOIN in MySQLi
$sql = "UPDATE borrow 
        LEFT JOIN borrowdetails ON borrow.borrow_id = borrowdetails.borrow_id
        SET borrow.borrow_status = 'returned', borrow.date_return = NOW()
        WHERE borrow.borrow_id = ? AND borrowdetails.book_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ii", $id, $book_id); // assuming both are integers
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Successfully updated
        $stmt->close();
        header('Location: view_borrow.php');
        exit();
    } else {
        // No rows updated — maybe invalid ids or already returned
        $stmt->close();
        die("No matching borrow record found or already returned.");
    }
} else {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
?>
