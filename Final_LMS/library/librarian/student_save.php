<?php
include('dbcon.php'); // make sure this connects using mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $type = $_POST['type'] ?? '';
    $year_level = $_POST['year_level'] ?? '';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO member (firstname, lastname, gender, address, contact, type, year_level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstname, $lastname, $gender, $address, $contact, $type, $year_level);

    if ($stmt->execute()) {
        header('Location: member.php');
        exit;
    } else {
        die("Error inserting member: " . $stmt->error);
    }
}
?>
