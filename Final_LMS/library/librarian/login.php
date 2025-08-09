<?php
session_start();
include('dbcon.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['id'] = $row['user_id'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Access Denied: Incorrect Password</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Access Denied: User not found</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
