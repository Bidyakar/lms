<?php
include('dbcon.php');
session_start();

if (isset($_POST['login'])) {
    $student_no = mysqli_real_escape_string($conn, $_POST['student_no']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM students WHERE student_no='$student_no' AND password='$password' AND status='active'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $num_row = mysqli_num_rows($result);

    if ($num_row > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['student_id'];
        header('Location: dasboard.php');
        exit();
    } else {
        header('Location: access_denied.php');
        exit();
    }
}
?>
