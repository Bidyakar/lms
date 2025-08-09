<?php 
include('dbcon.php');

if (isset($_POST['submit'])) {
    // Collect and sanitize inputs (basic trimming)
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact']);
    $type = trim($_POST['type']);
    $year_level = trim($_POST['year_level']);

    // Prepare an insert statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO member (firstname, lastname, gender, address, contact, type, year_level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstname, $lastname, $gender, $address, $contact, $type, $year_level);

    if ($stmt->execute()) {
        // Redirect after successful insertion
        header('Location: member.php');
        exit();
    } else {
        die("Error inserting member: " . $stmt->error);
    }

    $stmt->close();
}
?>
