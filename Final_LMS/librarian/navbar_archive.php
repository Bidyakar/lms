<?php
include('header.php');
include('session.php');
include('navbar_archive.php');  // Include the archive navbar here
?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">    
                <!-- Navigation pills -->
                <ul class="nav nav-pills">
                    <li class="active"><a href="archive.php">Archive</a></li>
                </ul>

                <center class="title">
                    <h1>Books List</h1>
                </center>

                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="example">
                    <div class="pull-right">
                        <a href="" onclick="window.print()" class="btn btn-info">
                            <i class="icon-print icon-large"></i> Print
                        </a>
                    </div>

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
                        // Using MySQLi (make sure your dbcon.php creates $conn)
                        $user_query = $conn->query("SELECT * FROM book WHERE status = 'Archive'") or die($conn->error);

                        while ($row = $user_query->fetch_assoc()) {
                            $id = $row['book_id'];
                            $cat_id = $row['category_id'];

                            $cat_query = $conn->query("SELECT * FROM category WHERE category_id = '$cat_id'") or die($conn->error);
                            $cat_row = $cat_query->fetch_assoc();
                        ?>
                        <tr class="del<?php echo $id; ?>">
                            <td><?php echo $row['book_id']; ?></td>
                            <td><?php echo $row['book_title']; ?></td>
                            <td><?php echo $cat_row['classname']; ?></td>
                            <td><?php echo $row['author']; ?></td> 
                            <td class="action"><?php echo $row['book_copies']; ?></td>
                            <td><?php echo $row['book_pub']; ?></td>
                            <td><?php echo $row['publisher_name']; ?></td>
                            <td><?php echo $row['isbn']; ?></td>
                            <td><?php echo $row['copyright_year']; ?></td>       
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>      
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
