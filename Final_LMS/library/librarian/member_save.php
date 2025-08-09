<?php 
include('dbcon.php'); // make sure this uses mysqli connection, e.g., $conn = mysqli_connect(...);

if (isset($_POST['submit'])) {
    // Sanitize user input
    $firstname   = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname    = mysqli_real_escape_string($conn, $_POST['lastname']);
    $gender      = mysqli_real_escape_string($conn, $_POST['gender']);
    $address     = mysqli_real_escape_string($conn, $_POST['address']);
    $contact     = mysqli_real_escape_string($conn, $_POST['contact']);
    $type        = mysqli_real_escape_string($conn, $_POST['type']);
    $year_level  = mysqli_real_escape_string($conn, $_POST['year_level']);

    // Use prepared statement
    $stmt = mysqli_prepare($conn, "INSERT INTO member (firstname, lastname, gender, address, contact, type, year_level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $gender, $address, $contact, $type, $year_level);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: member.php');
        exit;
    } else {
        die('Database error: ' . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);
}
?>
