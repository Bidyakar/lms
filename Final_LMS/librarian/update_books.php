<?php 
include('dbcon.php'); // $conn is your MySQLi connection

if (isset($_POST['submit'])) {
    // Sanitize and validate input
    $id = intval($_POST['id']);
    $book_title = $_POST['book_title'];
    $category_id = intval($_POST['category_id']);
    $author = $_POST['author'];
    $book_copies = intval($_POST['book_copies']);
    $book_pub = $_POST['book_pub'];
    $publisher_name = $_POST['publisher_name'];
    $isbn = $_POST['isbn'];
    $copyright_year = $_POST['copyright_year'];
    $status = $_POST['status'];

    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE book SET 
        book_title = ?, 
        category_id = ?, 
        author = ?, 
        book_copies = ?, 
        book_pub = ?, 
        publisher_name = ?, 
        isbn = ?, 
        copyright_year = ?, 
        status = ? 
        WHERE book_id = ?");

    // Bind parameters
    $stmt->bind_param(
        "sisisssssi", 
        $book_title, 
        $category_id, 
        $author, 
        $book_copies, 
        $book_pub, 
        $publisher_name, 
        $isbn, 
        $copyright_year, 
        $status, 
        $id
    );

    // Execute and check success
    if ($stmt->execute()) {
        header('Location: books.php');
        exit;
    } else {
        die("Error updating book: " . $stmt->error);
    }
}
?>
