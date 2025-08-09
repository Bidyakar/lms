<?php 
include('header.php'); 
include('navbar.php'); 

session_start();
include('dbcon.php'); 

$error = '';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

   
    $stmt = mysqli_prepare($conn, "SELECT user_id, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $db_password);
        mysqli_stmt_fetch($stmt);

       
        if ($password === $db_password) {
            $_SESSION['id'] = $user_id;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Access Denied: Incorrect password";
        }
    } else {
        $error = "Access Denied: User not found";
    }

    mysqli_stmt_close($stmt);
}
?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">
                <div class="sti">
                    <img src="../LMS/vit.png" class="img-rounded" alt="Logo">
                </div>
                <div class="login">
                    <div class="log_txt">
                        <p><strong>Please Enter the Details Below..</strong></p>
                    </div>
                    <form class="form-horizontal" method="POST" action="">
                        <div class="control-group">
                            <label class="control-label" for="username">Admin Name</label>
                            <div class="controls">
                                <input type="text" name="username" id="username" placeholder="Username" required
                                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                                <input type="password" name="password" id="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button id="login" name="submit" type="submit" class="btn">
                                    <i class="icon-signin icon-large"></i>&nbsp;Submit
                                </button>
                            </div>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>        
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
