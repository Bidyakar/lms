<?php
include('dbcon.php'); // This must define $conn (mysqli connection)

if (isset($_POST['login'])) {
    session_start();
    
    $student_no = mysqli_real_escape_string($conn, $_POST['student_no']);
    $password = $_POST['password'];

    // Fetch user by student_no
    $query = "SELECT * FROM students WHERE student_no = '$student_no' AND status = 'active'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['student_id'];
            header('Location: dashboard.php');
            exit();
        } else {
            // Wrong password
            header('Location: access_denied.php');
            exit();
        }
    } else {
        // Student number not found or inactive
        header('Location: access_denied.php');
        exit();
    }
}
?>
