<?php 
include('dbcon.php'); 

// Get and sanitize inputs (basic)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;

if ($id > 0 && $book_id > 0) {
    // Prepare SQL statement with JOIN and update
    $sql = "UPDATE borrow 
            LEFT JOIN borrowdetails ON borrow.borrow_id = borrowdetails.borrow_id
            SET borrow_status = 'returned', date_return = NOW() 
            WHERE borrow.borrow_id = ? AND borrowdetails.book_id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $id, $book_id);

    if ($stmt->execute()) {
        // Redirect after success
        header("Location: view_borrow.php");
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
} else {
    die("Invalid parameters.");
}
?>
