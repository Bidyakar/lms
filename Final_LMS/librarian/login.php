<?php
session_start();
include('dbcon.php'); // Make sure this file sets up $conn with mysqli_connect

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare and execute the query securely
    $stmt = mysqli_prepare($conn, "SELECT user_id, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $db_password);
        mysqli_stmt_fetch($stmt);

        // Plaintext password check (since your DB stores plaintext)
        if ($password === $db_password) {
            $_SESSION['id'] = $user_id;
            header('Location: dashboard.php');
            exit();
        } else {
            echo '<div class="alert alert-danger">Access Denied: Incorrect Password</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Access Denied: User not found</div>';
    }

    mysqli_stmt_close($stmt);
}
?>
