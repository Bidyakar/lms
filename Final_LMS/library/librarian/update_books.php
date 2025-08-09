<?php
include('dbcon.php');  // Make sure this creates $conn as your mysqli connection

if (isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $id = $_POST['id'];
    $book_title = $_POST['book_title'];
    $category_id = $_POST['category_id'];
    $author = $_POST['author'];
    $book_copies = $_POST['book_copies'];
    $book_pub = $_POST['book_pub'];
    $publisher_name = $_POST['publisher_name'];
    $isbn = $_POST['isbn'];
    $copyright_year = $_POST['copyright_year'];
    $status = $_POST['status'];

    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE book SET book_title=?, category_id=?, author=?, book_copies=?, book_pub=?, publisher_name=?, isbn=?, copyright_year=?, status=? WHERE book_id=?");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters (s = string, i = integer)
    $stmt->bind_param('sisssssssi', $book_title, $category_id, $author, $book_copies, $book_pub, $publisher_name, $isbn, $copyright_year, $status, $id);

    // Execute statement
    if ($stmt->execute()) {
        header('Location: books.php');
        exit();
    } else {
        die('Update failed: ' . $stmt->error);
    }
}
?>
