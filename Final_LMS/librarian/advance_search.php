<?php
include('header.php');
include('session.php');
include('navbar_books.php');
include('dbcon.php');  // mysqli connection $conn

$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';

$title_search = "%$title%";
$author_search = "%$author%";

?>

<div class="container">
  <div class="margin-top">
    <div class="row">  
      <div class="span12">  
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><i class="icon-user icon-large"></i>&nbsp;Books Table</strong>
        </div>

        <!-- Navigation Pills -->
        <ul class="nav nav-pills">
          <li class="active"><a href="books.php">All</a></li>
          <li><a href="new_books.php">New Books</a></li>
          <li><a href="old_books.php">Old Books</a></li>
          <li><a href="lost.php">Lost Books</a></li>
          <li><a href="damage.php">Damage Books</a></li>
          <li><a href="sub_rep.php">Subject for Replacement</a></li>
        </ul>

        <center class="title"><h1>Books List</h1></center>

        <div class="pull-right">
          <a href="" onclick="window.print()" class="btn-default"> Print</a>
        </div>

        <p><a href="add_books.php" class="btn-default">&nbsp;Add Books</a></p>

        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="example">
          <thead>
            <tr>
              <th>Acc No.</th>                                 
              <th>Book Title</th>                                 
              <th>Category</th>
              <th>Author</th>
              <th class="action">Copies</th>
              <th>Book Pub</th>
              <th>Publisher Name</th>
              <th>ISBN</th>
              <th>Copyright Year</th>
              <th>Date Added</th>
              <th>Status</th>
              <th class="action">Action</th>     
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT b.*, c.classname FROM book b 
                    LEFT JOIN category c ON b.category_id = c.category_id
                    WHERE b.status != 'Archive' 
                      AND (b.book_title LIKE ? OR b.author LIKE ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title_search, $author_search);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $id = $row['book_id'];

                // Count borrowed pending copies
                $stmt_borrow = $conn->prepare("SELECT COUNT(*) FROM borrowdetails WHERE book_id = ? AND borrow_status = 'pending'");
                $stmt_borrow->bind_param("i", $id);
                $stmt_borrow->execute();
                $stmt_borrow->bind_result($count);
                $stmt_borrow->fetch();
                $stmt_borrow->close();

                $total = $row['book_copies'] - $count;
                ?>
                <tr class="del<?php echo htmlspecialchars($id); ?>">
                  <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                  <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                  <td><?php echo htmlspecialchars($row['classname']); ?></td>
                  <td><?php echo htmlspecialchars($row['author']); ?></td>
                  <td class="action"><?php echo htmlspecialchars($total); ?></td>
                  <td><?php echo htmlspecialchars($row['book_pub']); ?></td>
                  <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
                  <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                  <td><?php echo htmlspecialchars($row['copyright_year']); ?></td>
                  <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                  <td><?php echo htmlspecialchars($row['status']); ?></td>
                  <?php include('toolttip_edit_delete.php'); ?>
                  <td class="action">
                    <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                    <?php include('delete_book_modal.php'); ?>
                    <a rel="tooltip" title="Edit" id="e<?php echo $id; ?>" href="edit_book.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
                  </td>
                </tr>
            <?php
            }
            $stmt->close();
            ?>
          </tbody>
        </table>

      </div>    
    </div>
  </div>
</div>

<?php include('footer.php') ?>
