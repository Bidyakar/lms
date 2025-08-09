<?php 
include('dbcon.php');

if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];
    $year_level = $_POST['year_level'];
    $status = $_POST['status'];

    // Prepare statement
    $stmt = $conn->prepare("UPDATE member SET firstname=?, lastname=?, gender=?, address=?, contact=?, type=?, year_level=?, status=? WHERE member_id=?");
    $stmt->bind_param("ssssssssi", $firstname, $lastname, $gender, $address, $contact, $type, $year_level, $status, $id);

    if ($stmt->execute()) {
        header('Location: member.php');
        exit();
    } else {
        die("Error updating member: " . $stmt->error);
    }
}
?>
