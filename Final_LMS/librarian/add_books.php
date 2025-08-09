<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_books.php'); ?>
<?php include('dbcon.php'); ?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">    
                <div class="alert alert-danger">Add Books</div>
                <p><a href="books.php" class="btn-default"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a></p>

                <div class="addstudent">
                    <div class="details">Please Enter Details Below</div>        
                    <form class="form-horizontal" method="POST" action="books_save.php" enctype="multipart/form-data">

                        <div class="control-group">
                            <label class="control-label">Book Title:</label>
                            <div class="controls">
                                <input type="text" class="span4" name="book_title" placeholder="Book Title" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Category:</label>
                            <div class="controls">
                                <select name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $cat_query = $conn->query("SELECT * FROM category");
                                    while ($cat_row = $cat_query->fetch_assoc()) {
                                        echo '<option value="' . $cat_row['category_id'] . '">' . $cat_row['classname'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Author:</label>
                            <div class="controls">
                                <input type="text" class="span4" name="author" placeholder="Author" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Book Copies:</label>
                            <div class="controls">
                                <input type="number" class="span1" name="book_copies" placeholder="Copies" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Book Publication:</label>
                            <div class="controls">
                                <input type="text" class="span4" name="book_pub" placeholder="Publication" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Publisher Name:</label>
                            <div class="controls">
                                <input type="text" class="span4" name="publisher_name" placeholder="Publisher Name" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">ISBN:</label>
                            <div class="controls">
                                <input type="text" class="span4" name="isbn" placeholder="ISBN" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Copyright Year:</label>
                            <div class="controls">
                                <input type="text" name="copyright_year" placeholder="e.g. 2025" required>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Status:</label>
                            <div class="controls">
                                <select name="status" required>
                                    <option value="">Select Status</option>
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
                                <button name="submit" type="submit" class="btn btn-default">
                                    <i class="icon-save icon-large"></i>&nbsp;Save
                                </button>
                            </div>
                        </div>

                    </form>                    
                </div>        
            </div>        
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
