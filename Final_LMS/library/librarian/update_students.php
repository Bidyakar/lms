<?php
include('dbcon.php');  // Make sure this sets up $conn as your mysqli connection

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];
    $year_level = $_POST['year_level'];

    $stmt = $conn->prepare("UPDATE member SET firstname=?, lastname=?, gender=?, address=?, contact=?, type=?, year_level=? WHERE member_id=?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('sssssssi', $firstname, $lastname, $gender, $address, $contact, $type, $year_level, $id);

    if ($stmt->execute()) {
        header('Location: students.php');
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }
}
?>
