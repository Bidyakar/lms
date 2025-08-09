<?php 
include('header.php'); 
include('session.php'); 
include('navbar_member.php'); 

$get_id = $_GET['id']; 

// Use MySQLi procedural or OOP style, I assume procedural here with $conn from dbcon.php
include('dbcon.php');

$query = mysqli_query($conn, "SELECT * FROM member WHERE member_id='$get_id'") or die(mysqli_error($conn));
$row = mysqli_fetch_array($query);
?>

<div class="container">
  <div class="margin-top">
    <div class="row">  
      <div class="span12">  
        <div class="alert alert-danger"><i class="icon-pencil"></i>&nbsp;Edit Member</div>
        <p><a class="btn-default" href="member.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a></p>
        <div class="addstudent">
          <div class="details">Please Enter Details Below</div>  
          <form class="form-horizontal" method="POST" action="update_member.php" enctype="multipart/form-data">
            
            <div class="control-group">
              <label class="control-label" for="firstname">Firstname:</label>
              <div class="controls">
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>" placeholder="Firstname" required>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($get_id); ?>">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="lastname">Lastname:</label>
              <div class="controls">
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>" placeholder="Lastname" required>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="gender">Gender:</label>
              <div class="controls">
                <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($row['gender']); ?>" placeholder="Gender" required>
              </div>
            </div>  
            
            <div class="control-group">
              <label class="control-label" for="address">Address:</label>
              <div class="controls">
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" placeholder="Address" required>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="contact">Contact:</label>
              <div class="controls">
                <input type="tel" pattern="[0-9]{10}" class="search" name="contact" placeholder="Phone Number" autocomplete="off" maxlength="11" value="<?php echo htmlspecialchars($row['contact']); ?>">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="type">Type:</label>
              <div class="controls">
                <select name="type" id="type" required>
                  <option value="Student" <?php if($row['type'] == 'Student') echo 'selected'; ?>>Student</option>
                  <option value="Teacher" <?php if($row['type'] == 'Teacher') echo 'selected'; ?>>Teacher</option>
                </select>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="year_level">Year Level:</label>
              <div class="controls">
                <select name="year_level" id="year_level" required>            
                  <option value="First Year" <?php if($row['year_level'] == 'First Year') echo 'selected'; ?>>First Year</option>
                  <option value="Second Year" <?php if($row['year_level'] == 'Second Year') echo 'selected'; ?>>Second Year</option>
                  <option value="Third Year" <?php if($row['year_level'] == 'Third Year') echo 'selected'; ?>>Third Year</option>
                  <option value="Fourth Year" <?php if($row['year_level'] == 'Fourth Year') echo 'selected'; ?>>Fourth Year</option>
                  <option value="Faculty" <?php if($row['year_level'] == 'Faculty') echo 'selected'; ?>>Faculty</option>
                </select>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="status">Status:</label>
              <div class="controls">
                <select name="status" id="status" required>
                  <option value="Active" <?php if($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                  <option value="Banned" <?php if($row['status'] == 'Banned') echo 'selected'; ?>>Banned</option>
                </select>
              </div>
            </div>
            
            <div class="control-group">
              <div class="controls">
                <button name="submit" type="submit" class="btn btn-default"><i class="icon-save icon-large"></i>&nbsp;Update</button>
              </div>
            </div>
          </form>       
        </div>    
      </div>    
    </div>
  </div>
</div>

<?php include('footer.php') ?>
