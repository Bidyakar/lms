<?php
include('dbcon.php'); // Your mysqli connection file
include('session.php'); // To ensure user is logged in (optional but recommended)

if (isset($_GET['id'])) {
    $borrow_details_id = intval($_GET['id']);
    $date_return = date('Y-m-d'); // Current date

    // Prepare the UPDATE query with placeholders
    $stmt = $conn->prepare("UPDATE borrowdetails 
                            SET date_return = ?, borrow_status = 'Returned' 
                            WHERE borrow_details_id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters (s = string, i = integer)
    $stmt->bind_param('si', $date_return, $borrow_details_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to view_borrow.php with success message
        header('Location: view_borrow.php?success=1');
        exit();
    } else {
        echo "Error updating record: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
