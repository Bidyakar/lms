<?php
include('dbcon.php');  // make sure $conn is your mysqli connection

if (!isset($_POST['selector']) || empty($_POST['selector']) || !is_array($_POST['selector'])) {
    // No books selected, redirect back
    header("Location: borrow.php");
    exit();
}

$book_ids = $_POST['selector']; // array of selected book ids
$member_id = $_POST['member_id'] ?? null;
$due_date = $_POST['due_date'] ?? null;

if (!$member_id || !$due_date) {
    // Required fields missing, redirect back or handle error
    header("Location: borrow.php");
    exit();
}

// Insert into borrow table
$stmt = $conn->prepare("INSERT INTO borrow (member_id, date_borrow, due_date) VALUES (?, NOW(), ?)");
$stmt->bind_param("is", $member_id, $due_date);
if (!$stmt->execute()) {
    die("Insert borrow failed: " . $stmt->error);
}
$borrow_id = $stmt->insert_id;
$stmt->close();

// Insert into borrowdetails table for each book
$stmt_detail = $conn->prepare("INSERT INTO borrowdetails (book_id, borrow_id, borrow_status) VALUES (?, ?, 'pending')");
if (!$stmt_detail) {
    die("Prepare borrowdetails failed: " . $conn->error);
}

foreach ($book_ids as $book_id) {
    $stmt_detail->bind_param("ii", $book_id, $borrow_id);
    if (!$stmt_detail->execute()) {
        die("Insert borrowdetails failed for book $book_id: " . $stmt_detail->error);
    }
}
$stmt_detail->close();

header("Location: borrow.php");
exit();
?>
