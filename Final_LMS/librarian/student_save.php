<?php 
include('dbcon.php'); // This should initialize $conn (MySQLi connection)

if (isset($_POST['submit'])) {
    $firstname   = trim($_POST['firstname']);
    $lastname    = trim($_POST['lastname']);
    $gender      = trim($_POST['gender']);
    $address     = trim($_POST['address']);
    $contact     = trim($_POST['contact']);
    $type        = trim($_POST['type']);
    $year_level  = trim($_POST['year_level']);

    // Optional: Basic server-side validation
    if (empty($firstname) || empty($lastname) || empty($gender) || empty($address) || empty($contact) || empty($type) || empty($year_level)) {
        die("All fields are required.");
    }

    // Insert using prepared statement
    $stmt = $conn->prepare("INSERT INTO member (firstname, lastname, gender, address, contact, type, year_level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstname, $lastname, $gender, $address, $contact, $type, $year_level);

    if ($stmt->execute()) {
        header("Location: member.php");
        exit();
    } else {
        die("Error inserting member: " . $conn->error);
    }

    $stmt->close();
}
?>
