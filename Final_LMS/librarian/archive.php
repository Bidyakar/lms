<?php
include('header.php');
include('session.php');
include('navbar_archive.php');
include('dbcon.php'); // Make sure this sets up $conn as mysqli
?>

<div class="container">
    <div class="margin-top">
        <div class="row">
            <div class="span12">
                <!-- Navigation -->
                <ul class="nav nav-pills">
                    <li class="active"><a href="archive.php">Archive</a></li>
                </ul>

                <center class="title">
                    <h1>Archived Books List</h1>
                </center>

                <div class="pull-right mb-2">
                    <a href="#" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
                </div>

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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM book WHERE status = 'Archive'");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()):
                            $id = $row['book_id'];
                            $cat_id = $row['category_id'];

                            // Get category name
                            $cat_stmt = $conn->prepare("SELECT classname FROM category WHERE category_id = ?");
                            $cat_stmt->bind_param("i", $cat_id);
                            $cat_stmt->execute();
                            $cat_stmt->bind_result($classname);
                            $cat_stmt->fetch();
                            $cat_stmt->close();
                        ?>
                        <tr class="del<?php echo $id; ?>">
                            <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                            <td><?php echo htmlspecialchars($classname); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="action"><?php echo htmlspecialchars($row['book_copies']); ?></td>
                            <td><?php echo htmlspecialchars($row['book_pub']); ?></td>
                            <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($row['copyright_year']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
