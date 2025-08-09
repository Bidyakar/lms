<?php
include('header.php');
include('session.php');
include('navbar_borrow.php');
include('dbcon.php'); // Make sure this sets up $conn as mysqli connection
?>

<div class="container">
  <div class="margin-top">
    <div class="row">
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-user icon-large"></i>&nbsp;Borrow Table</strong>
      </div>

      <div class="span12">
        <form method="post" action="borrow_save.php">
          <div class="span3">
            <div class="control-group">
              <label class="control-label" for="member_id">Borrower Name</label>
              <div class="controls">
                <select name="member_id" id="member_id" class="chzn-select" required>
                  <option value="">Select borrower</option>
                  <?php
                  $result = $conn->query("SELECT member_id, firstname, lastname FROM member");
                  while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['member_id']) . '">' .
                      htmlspecialchars($row['firstname'] . " " . $row['lastname']) .
                      '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="due_date">Due Date</label>
              <div class="controls">
                <input type="date" name="due_date" id="due_date" class="form-control" required style="border: 3px double #CCCCCC;">
              </div>
            </div>

            <div class="control-group">
              <div class="controls">
                <button type="submit" name="submit" class="btn btn-default">Borrow</button>
              </div>
            </div>
          </div>

          <div class="span8">
            <div class="alert alert-success"><strong>Select Book</strong></div>
            <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
              <thead>
                <tr>
                  <th>Acc No.</th>
                  <th>Book title</th>
                  <th>Category</th>
                  <th>Author</th>
                  <th>Publisher name</th>
                  <th>Status</th>
                  <th>Add</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $stmt = $conn->prepare("SELECT book.book_id, book.book_title, book.category_id, book.author, book.publisher_name, book.status, category.classname 
                                        FROM book 
                                        LEFT JOIN category ON book.category_id = category.category_id
                                        WHERE book.status != 'Archive'");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                  $book_id = $row['book_id'];
                  echo '<tr class="del' . htmlspecialchars($book_id) . '">';
                  echo '<td>' . htmlspecialchars($book_id) . '</td>';
                  echo '<td>' . htmlspecialchars($row['book_title']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['classname']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['author']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['publisher_name']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                  echo '<td><input class="uniform_on" name="selector[]" type="checkbox" value="' . htmlspecialchars($book_id) . '"></td>';
                  echo '</tr>';
                }
                $stmt->close();
                ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>

    <script>
      $(".uniform_on").change(function () {
        var max = 3;
        if ($(".uniform_on:checked").length == max) {
          $(".uniform_on").attr('disabled', 'disabled');
          alert('3 Books are allowed per borrow');
          $(".uniform_on:checked").removeAttr('disabled');
        } else {
          $(".uniform_on").removeAttr('disabled');
        }
      });
    </script>
  </div>
</div>

<?php include('footer.php'); ?>
