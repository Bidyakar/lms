<div id="edit<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <div class="alert alert-info"><strong>Edit User</strong></div>
        <form class="form-horizontal" method="post">
            <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <div class="controls">
                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>" required>
                    <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="text" name="password" id="password" value="<?php echo $row['password']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="firstname">Firstname</label>
                <div class="controls">
                    <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="lastname">Lastname</label>
                <div class="controls">
                    <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button name="edit" type="submit" class="btn btn-success">
                        <i class="icon-save icon-large"></i>&nbsp;Update
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">
            <i class="icon-remove icon-large"></i>&nbsp;Close
        </button>
    </div>
</div>

<?php
// Include database connection
include('dbcon.php');

if (isset($_POST['edit'])) {
    $user_id   = $_POST['id'];
    $username  = $_POST['username'];
    $password  = $_POST['password']; // Hash this if needed
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];

    // Optional: Securely hash the password
    // $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, firstname = ?, lastname = ? WHERE user_id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $username, $password, $firstname, $lastname, $user_id);

    if ($stmt->execute()) {
        echo '<script>window.location="users.php";</script>';
    } else {
        echo "<script>alert('Error updating user: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>
