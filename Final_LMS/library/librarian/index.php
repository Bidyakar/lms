<?php
session_start();
include('header.php');
include('navbar.php');
include('dbcon.php'); 
?>
<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">
                <div class="sti">
                    <img src="../../LMS/vit.png" class="img-rounded" style="width: 250px; height: auto; background-color: none;" alt="Logo">
                </div>
                <div class="login">
                    <div class="log_txt">
                        <p><strong>Please Enter the Details Below..</strong></p>
                    </div>
                    <form class="form-horizontal" method="POST">
                        <div class="control-group">
                            <label class="control-label" for="username">Username</label>
                            <div class="controls">
                                <input type="text" name="username" id="username" placeholder="Username" required>
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
                                <button id="login" name="submit" type="submit" class="btn"><i class="icon-signin icon-large"></i>&nbsp;Submit</button>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['submit'])) {
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            
                            $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows === 1) {
                                $row = $result->fetch_assoc();
                                if (password_verify($password, $row['password'])) {
                                    $_SESSION['id'] = $row['user_id'];
                                    header('Location: dashboard.php');
                                    exit();
                                } else {
                                    echo '<div class="alert alert-danger">Access Denied: Incorrect Password</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger">Access Denied: User Not Found</div>';
                            }

                            $stmt->close();
                        }
                        ?>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
