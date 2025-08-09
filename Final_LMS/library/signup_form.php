<?php
include('dbcon.php');

$exist = "";
$a = "";

if (isset($_POST['submit'])) {
    $student_no = $_POST['student_no'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE student_no = ?");
    $stmt->bind_param("s", $student_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count == 0) {
        $exist = 'ID Number not Found!';
    }

    if ($cpassword != $password) {
        $a = "Passwords do not match";
    }

    // If everything is valid and student exists
    if ($cpassword == $password && $count == 1) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);

        move_uploaded_file($_FILES["image"]["tmp_name"], "registrar/upload/" . $_FILES["image"]["name"]);
        $location = "upload/" . $_FILES["image"]["name"];

        $update_stmt = $conn->prepare("UPDATE students SET password = ?, photo = ?, status = 'active' WHERE student_no = ?");
        $update_stmt->bind_param("sss", $password, $location, $student_no);
        $update_stmt->execute();

        echo "<script>window.location='success.php';</script>";
        exit();
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <div class="span5">
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Student No:</label>
                <div class="controls">
                    <input type="text" id="inputEmail" name="student_no" value="<?php echo isset($student_no) ? $student_no : ''; ?>" placeholder="Student No" required>
                    <?php if (!empty($exist)) echo "<span class='label label-important'>$exist</span>"; ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputPassword">Password</label>
                <div class="controls">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputPassword">Confirm Password</label>
                <div class="controls">
                    <input type="password" name="cpassword" placeholder="Confirm Password" required>
                    <?php if (!empty($a)) echo "<span class='label label-important'>$a</span>"; ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button name="submit" type="submit" class="btn btn-info"><i class="icon-signin icon-large"></i>&nbsp;Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="span6">
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="input01">Image:</label>
                <div class="controls">
                    <input type="file" name="image" class="font" required>
                </div>
            </div>
        </div>
    </div>
</form>
