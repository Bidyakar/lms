<?php
include('header.php');
include('session.php');
include('navbar_books.php');
include('dbcon.php');  
?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">    
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="icon-user icon-large"></i>&nbsp;Books Table</strong>
                </div>

                <ul class="nav nav-pills nav-justified mb-3">
                    <li class="active"><a href="books.php">All</a></li>
                    <li><a href="new_books.php">New Books</a></li>
                    <li><a href="old_books.php">Old Books</a></li>
                    <li><a href="lost.php">Lost Books</a></li>
                    <li><a href="damage.php">Damage Books</a></li>
                    <li><a href="sub_rep.php">Subject for Replacement</a></li>
                </ul>

                <center class="title">
                    <h1>Books List</h1>
                </center>

                <div class="pull-right mb-2">
                    <a href="#" onclick="window.print()" class="btn btn-default">Print</a>
                </div>
                <p>
                    <a href="add_books.php" class="btn btn-default">Add Books</a>
                </p>

                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="example">
                    <thead>
                        <tr>
                            <th>Acc No.</th>
                            <th>Book Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th class="action">Copies Available</th>
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
                        $sql = "SELECT * FROM book WHERE status != 'Archive'";
                        $result = $conn->query($sql) or die($conn->error);

                        while ($row = $result->fetch_assoc()) {
                            $id = $row['book_id'];
                            $cat_id = $row['category_id'];
                            $book_copies = $row['book_copies'];

                            // Get category classname
                            $cat_sql = "SELECT classname FROM category WHERE category_id = ?";
                            $stmt_cat = $conn->prepare($cat_sql);
                            $stmt_cat->bind_param("i", $cat_id);
                            $stmt_cat->execute();
                            $stmt_cat->bind_result($classname);
                            $stmt_cat->fetch();
                            $stmt_cat->close();

                            // Count how many copies are currently borrowed (pending)
                            $borrow_sql = "SELECT COUNT(*) FROM borrowdetails WHERE book_id = ? AND borrow_status = 'pending'";
                            $stmt_borrow = $conn->prepare($borrow_sql);
                            $stmt_borrow->bind_param("i", $id);
                            $stmt_borrow->execute();
                            $stmt_borrow->bind_result($count_pending);
                            $stmt_borrow->fetch();
                            $stmt_borrow->close();

                            $total_available = $book_copies - $count_pending;
                            if ($total_available < 0) $total_available = 0; // avoid negative copies
                        ?>
                        <tr class="del<?php echo $id; ?>">
                            <td><?php echo htmlspecialchars($id); ?></td>
                            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                            <td><?php echo htmlspecialchars($classname); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="action"><?php echo $total_available; ?></td>
                            <td><?php echo htmlspecialchars($row['book_pub']); ?></td>
                            <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($row['copyright_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <?php include('toolttip_edit_delete.php'); ?>
                            <td class="action">
                                <div class="span2">
                                    <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal" class="btn btn-default">
                                        <i class="icon-trash icon-large"></i>
                                    </a>
                                    <?php include('delete_book_modal.php'); ?>
                                    <div class="span1">
                                        <a rel="tooltip" title="Edit" id="e<?php echo $id; ?>" href="edit_book.php?id=<?php echo $id; ?>" class="btn btn-default">
                                            <i class="icon-pencil icon-large"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>      
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
