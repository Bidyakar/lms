<?php
// borrow_form.php

include('header.php');
include('session.php');
include('navbar_borrow.php');
include('dbcon.php'); // this file should set up $conn as your MySQLi connection

?>

<div class="container">
  <div class="margin-top">
    <div class="row">
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-user icon-large"></i>&nbsp;Borrow Book</strong>
      </div>

      <div class="span12">
        <form method="post" action="borrow_save.php">
          <div class="border-borrow">

            <div class="control-group">
              <label class="control-label" for="member_id">Borrower Name</label>
              <div class="controls">
                <select name="member_id" id="member_id" class="chzn-select" required>
                  <option value="">-- Select Borrower --</option>
                  <?php
                  $stmt = $conn->prepare("SELECT member_id, firstname, lastname FROM member");
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['member_id']) . '">' .
                         htmlspecialchars($row['firstname'] . " " . $row['lastname']) .
                         '</option>';
                  }
                  $stmt->close();
                  ?>
                </select>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="due_date">Due Date</label>
              <div class="controls">
                <input type="date" name="due_date" id="due_date" maxlength="10" style="border: 3px double #CCCCCC;" required />
              </div>
            </div>

            <div class="control-group">
              <div class="controls">
                <button type="submit" name="borrow" class="btn btn-success">
                  <i class="icon-plus"></i> Borrow
                </button>
                <!--
                  Removed the delete_student button here as it seemed out of context.
                  Add it back if you want, but specify the purpose.
                -->
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
