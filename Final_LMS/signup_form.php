<?php
include('dbcon.php'); // assumes $conn = new mysqli(...);

$exist = "";
$a = "";

if (isset($_POST['submit'])) {
    $student_no = trim($_POST['student_no']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if student exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_no = ?");
    $stmt->bind_param("s", $student_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    $stmt->close();

    if ($count == 0) {
        $exist = "ID Number not Found!";
    }

    if ($password !== $cpassword) {
        $a = "Passwords do not match";
    }

    // Only proceed if no errors
    if ($count == 1 && $password === $cpassword) {
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = "registrar/upload/";
            $filename = basename($_FILES['image']['name']);
            $target_file = $upload_dir . $filename;

            // Optional: validate file type & size here

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Update student info with hashed password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $update_stmt = $conn->prepare("UPDATE students SET password = ?, photo = ?, status = 'active' WHERE student_no = ?");
                $update_stmt->bind_param("sss", $hashed_password, $target_file, $student_no);
                if ($update_stmt->execute()) {
                    $update_stmt->close();
                    echo "<script>window.location='success.php';</script>";
                    exit();
                } else {
                    $a = "Failed to update student info.";
                }
            } else {
                $a = "Failed to upload image.";
            }
        } else {
            $a = "Image file is required.";
        }
    }
}
?>

<form method="post" enctype="multipart/form-data">    
    <div class="span5">
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="student_no">Student No:</label>
                <div class="controls">
                    <input type="text" id="student_no" name="student_no" value="<?php echo htmlspecialchars($_POST['student_no'] ?? ''); ?>" placeholder="Student No" required>
                    <?php if ($exist): ?>
                        <span class="label label-important"><?php echo htmlspecialchars($exist); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="cpassword">Confirm Password</label>
                <div class="controls">
                    <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                    <?php if ($a): ?>
                        <span class="label label-important"><?php echo htmlspecialchars($a); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="image">Image:</label>
                <div class="controls">
                    <input type="file" id="image" name="image" class="font" required>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button name="submit" type="submit" class="btn btn-info">
                        <i class="icon-signin icon-large"></i>&nbsp;Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
