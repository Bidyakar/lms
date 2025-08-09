<?php
include('header.php');
include('session.php');
include('navbar_books.php');
include('dbcon.php'); // Assuming this initializes $conn as MySQLi connection

// Validate and sanitize GET parameter
$get_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($get_id <= 0) {
    echo "Invalid book ID.";
    exit;
}

// Prepare and execute query safely
$stmt = $conn->prepare("SELECT book.*, category.classname 
                        FROM book 
                        LEFT JOIN category ON category.category_id = book.category_id 
                        WHERE book.book_id = ?");
$stmt->bind_param("i", $get_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Book not found.";
    exit;
}

$row = $result->fetch_assoc();
$category_id = $row['category_id'];

$stmt->close();
?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">    
                <div class="alert alert-danger"><i class="icon-pencil"></i>&nbsp;Edit Books</div>
                <p><a class="btn-default" href="books.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a></p>
                <div class="addstudent">
                    <div class="details">Please Enter Details Below</div>    
                    <form class="form-horizontal" method="POST" action="update_books.php" enctype="multipart/form-data">
                        
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Book_title:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="inputEmail" name="book_title" value="<?php echo htmlspecialchars($row['book_title']); ?>" placeholder="book_title" required>
                                <input type="hidden" name="id" value="<?php echo $get_id; ?>">
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="category_id">Category:</label>
                            <div class="controls">
                                <select name="category_id" id="category_id" required>
                                    <option value="<?php echo $category_id; ?>"><?php echo htmlspecialchars($row['classname']); ?></option>
                                    <?php 
                                    $cat_stmt = $conn->prepare("SELECT category_id, classname FROM category WHERE category_id != ? ORDER BY classname ASC");
                                    $cat_stmt->bind_param("i", $category_id);
                                    $cat_stmt->execute();
                                    $cat_result = $cat_stmt->get_result();
                                    while($row1 = $cat_result->fetch_assoc()) {
                                        echo '<option value="'.intval($row1['category_id']).'">'.htmlspecialchars($row1['classname']).'</option>';
                                    }
                                    $cat_stmt->close();
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="author">Author:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="author" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" placeholder="author" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="book_copies">Book_copies:</label>
                            <div class="controls">
                                <input class="span1" type="number" id="book_copies" name="book_copies" value="<?php echo intval($row['book_copies']); ?>" placeholder="book_copies" min="0" required>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="book_pub">Book_pub:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="book_pub" name="book_pub" value="<?php echo htmlspecialchars($row['book_pub']); ?>" placeholder="book_pub" required>
                            </div>
                        </div>    

                        <div class="control-group">
                            <label class="control-label" for="publisher_name">Publisher_name:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="publisher_name" name="publisher_name" value="<?php echo htmlspecialchars($row['publisher_name']); ?>" placeholder="publisher_name" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="isbn">Isbn:</label>
                            <div class="controls">
                                <input type="text" class="span4" id="isbn" name="isbn" value="<?php echo htmlspecialchars($row['isbn']); ?>" placeholder="isbn" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="copyright_year">Copyright_year:</label>
                            <div class="controls">
                                <input type="text" id="copyright_year" name="copyright_year" value="<?php echo htmlspecialchars($row['copyright_year']); ?>" placeholder="copyright_year" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="status">Status:</label>
                            <div class="controls">
                                <select name="status" id="status" required>
                                    <option><?php echo htmlspecialchars($row['status']); ?></option>
                                    <option>New</option>
                                    <option>Old</option>
                                    <option>Lost</option>
                                    <option>Damage</option>
                                    <option>Subject for Replacement</option>
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

<?php include('footer.php'); ?>
