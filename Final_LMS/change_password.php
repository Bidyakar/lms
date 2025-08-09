<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar.php'); ?>
<?php
include('dbcon.php');

// Fetch current student details
$query = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$session_id'") or die(mysqli_error($conn));
$row = mysqli_fetch_array($query);
?>
<div class="container">
    <div class="margin-top">
        <div class="row">
            <?php include('head.php'); ?>
            <div class="span3"></div>

            <div class="span7">
                <form class="form-horizontal" method="post">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">New Password</label>
                        <div class="controls">
                            <input type="password" name="np" id="inputEmail" placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Re-type Password</label>
                        <div class="controls">
                            <input type="password" name="rp" id="inputPassword" placeholder="Re-type Password" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" name="update" class="btn btn-success">Update</button>
                        </div>
                        <br><br>

                        <?php
                        if (isset($_POST['update'])) {
                            $np = $_POST['np'];
                            $rp = $_POST['rp'];

                            if ($np != $rp) {
                                echo '<div class="alert alert-danger">Passwords do not match.</div>';
                            } else {
                                // Hash the password (optional but recommended)
                                $hashedPassword = password_hash($np, PASSWORD_DEFAULT);

                                $update = mysqli_query($conn, "UPDATE students SET password = '$hashedPassword' WHERE student_id = '$session_id'") or die(mysqli_error($conn));
                                if ($update) {
                                    echo '<div class="alert alert-success">Password updated successfully.</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
