<?php
include('dbcon.php'); // your DB connection file
session_start();

$username = 'bb';
$password = 'bb'; // temporary password

// Set session manually for this user
$result = mysqli_query($conn, "SELECT user_id FROM users WHERE username='$username'");
if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['id'] = $row['user_id'];
    echo "Logged in as $username";
    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
} else {
    echo "User not found";
}
?>
