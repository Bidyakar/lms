<?php
include('dbcon.php');

$id = $_POST['selector'] ?? [];
$member_id = $_POST['member_id'];
$due_date = $_POST['due_date'];

if (empty($id)) {
    header("Location: borrow.php");
    exit();
} else {
    // Insert into borrow table
    $stmt = $conn->prepare("INSERT INTO borrow (member_id, date_borrow, due_date) VALUES (?, NOW(), ?)");
    $stmt->bind_param("is", $member_id, $due_date);
    $stmt->execute();

    // Get the last inserted borrow_id
    $borrow_id = $conn->insert_id;

    // Prepare insert for borrowdetails
    $stmt_details = $conn->prepare("INSERT INTO borrowdetails (book_id, borrow_id, borrow_status) VALUES (?, ?, 'pending')");

    foreach ($id as $book_id) {
        $stmt_details->bind_param("ii", $book_id, $borrow_id);
        $stmt_details->execute();
    }

    // Redirect
    header("Location: borrow.php");
    exit();
}
?>
