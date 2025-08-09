<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_dashboard.php'); ?>
<?php include('dbcon.php'); ?>

<!-- Add User Modal -->
<div id="add_user" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
		<div class="alert alert-info"><strong>Add User</strong></div>

		<form class="form-horizontal" method="post">
			<div class="control-group">
				<label class="control-label" for="username">Username</label>
				<div class="controls">
					<input type="text" id="username" name="username" placeholder="Username" required>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="password" name="password" id="password" placeholder="Password" required>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="firstname">Firstname</label>
				<div class="controls">
					<input type="text" id="firstname" name="firstname" placeholder="Firstname" required>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="lastname">Lastname</label>
				<div class="controls">
					<input type="text" id="lastname" name="lastname" placeholder="Lastname" required>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<button name="submit" type="submit" class="btn btn-success">
						<i class="icon-save icon-large"></i>&nbsp;Save
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

<!-- PHP logic to insert user -->
<?php
if (isset($_POST['submit'])) {
	require_once 'dbcon.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];

	// Optional: hash the password
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $conn->prepare("INSERT INTO users (username, password, firstname, lastname) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $username, $hashed_password, $firstname, $lastname);

	if ($stmt->execute()) {
		echo "<script>alert('User added successfully!'); window.location='dashboard.php';</script>";
	} else {
		echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
	}

	$stmt->close();
	$conn->close();
}
?>

<?php include('footer.php'); ?>
