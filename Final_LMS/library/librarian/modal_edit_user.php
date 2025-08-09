<div id="edit<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
		<div class="alert alert-info"><strong>Edit User</strong></div>
		<form class="form-horizontal" method="post">
			<input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">

			<div class="control-group">
				<label class="control-label" for="username">Username</label>
				<div class="controls">
					<input type="text" name="username" value="<?php echo $row['username']; ?>" required>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="text" name="password" value="<?php echo $row['password']; ?>" required>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="firstname">Firstname</label>
				<div class="controls">
					<input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" required>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="lastname">Lastname</label>
				<div class="controls">
					<input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" required>
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
if (isset($_POST['edit'])) {
	require_once 'dbcon.php';

	$user_id   = $_POST['id'];
	$username  = $_POST['username'];
	$password  = $_POST['password'];
	$firstname = $_POST['firstname'];
	$lastname  = $_POST['lastname'];

	// Optional: re-hash the password (recommended only if it's a new password)
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, firstname = ?, lastname = ? WHERE user_id = ?");
	$stmt->bind_param("ssssi", $username, $hashed_password, $firstname, $lastname, $user_id);

	if ($stmt->execute()) {
		echo "<script>window.location='users.php';</script>";
	} else {
		echo "<div class='alert alert-danger'>Error updating user: " . $stmt->error . "</div>";
	}

	$stmt->close();
	$conn->close();
}
?>
