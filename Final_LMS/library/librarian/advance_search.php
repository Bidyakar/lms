<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_books.php'); ?>
<?php include('dbcon.php'); // Make sure this uses mysqli like $conn = new mysqli(...) ?>

<?php
$title = isset($_POST['title']) ? $_POST['title'] : '';
$author = isset($_POST['author']) ? $_POST['author'] : '';

// Prepare and execute the search query securely
$stmt = $conn->prepare("
    SELECT * FROM book 
    WHERE status != 'Archive' AND (book_title LIKE ? OR author LIKE ?)
");
$searchTitle = "%$title%";
$searchAuthor = "%$author%";
$stmt->bind_param("ss", $searchTitle, $searchAuthor);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">	
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="icon-user icon-large"></i>&nbsp;Books Table</strong>
                </div>

                <ul class="nav nav-pills">
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

                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="example">
                    <div class="pull-right">
                        <a href="" onclick="window.print()" class="btn-default"> Print</a>
                    </div>
                    <p><a href="add_books.php" class="btn-default">&nbsp;Add Books</a></p>

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
                    <?php while ($row = $result->fetch_assoc()):
                        $id = $row['book_id'];
                        $cat_id = $row['category_id'];
                        $book_copies = $row['book_copies'];

                        // Count pending borrows
                        $borrow_stmt = $conn->prepare("SELECT COUNT(*) AS borrow_count FROM borrowdetails WHERE book_id = ? AND borrow_status = 'pending'");
                        $borrow_stmt->bind_param("i", $id);
                        $borrow_stmt->execute();
                        $borrow_result = $borrow_stmt->get_result()->fetch_assoc();
                        $borrow_count = $borrow_result['borrow_count'];
                        $available_copies = $book_copies - $borrow_count;

                        // Get category name
                        $cat_stmt = $conn->prepare("SELECT classname FROM category WHERE category_id = ?");
                        $cat_stmt->bind_param("i", $cat_id);
                        $cat_stmt->execute();
                        $cat_result = $cat_stmt->get_result()->fetch_assoc();
                        $category_name = $cat_result ? $cat_result['classname'] : 'Unknown';
                    ?>
                        <tr class="del<?php echo $id; ?>">
                            <td><?php echo $id; ?></td>
                            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                            <td><?php echo htmlspecialchars($category_name); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="action"><?php echo $available_copies; ?></td>
                            <td><?php echo htmlspecialchars($row['book_pub']); ?></td>
                            <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($row['copyright_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="action">
                                <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                <?php include('delete_book_modal.php'); ?>
                                <a rel="tooltip" title="Edit" href="edit_book.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>		
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
