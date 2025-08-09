<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_archive.php'); ?>
<?php include('dbcon.php'); // This should use mysqli and define $conn ?>

<div class="container">
    <div class="margin-top">
        <div class="row">	
            <div class="span12">	
                <!-- Nav Pills -->
                <ul class="nav nav-pills">
                    <li class="active"><a href="archive.php">Archive</a></li>
                </ul>

                <!-- Page Title -->
                <center class="title">
                    <h1>Books List</h1>
                </center>

                <!-- Print Button -->
                <div class="pull-right">
                    <a href="" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
                </div>

                <!-- Book Table -->
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
                        // Fetch archived books
                        $stmt = $conn->prepare("SELECT * FROM book WHERE status = 'Archive'");
                        $stmt->execute();
                        $books_result = $stmt->get_result();

                        while ($row = $books_result->fetch_assoc()):
                            $id = $row['book_id'];
                            $cat_id = $row['category_id'];

                            // Fetch category name
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
