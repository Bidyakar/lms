<?php
include('dbcon.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, firstname, lastname) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $firstname, $lastname);

    if ($stmt->execute()) {
        header("Location: users.php");
        exit();
    } else {
        die("Error adding user: " . $conn->error);
    }
}
?>
