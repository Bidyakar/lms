<?php
include('header.php');
include('session.php');
include('navbar_borrow.php');
include('dbcon.php'); // must create $conn as mysqli connection

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
                            <label class="control-label" for="inputEmail">Borrower Name</label>
                            <div class="controls">
                                <select name="member_id" class="chzn-select" required>
                                    <option value=""></option>
                                    <?php
                                    $member_query = "SELECT member_id, firstname, lastname FROM member";
                                    if ($result = $conn->query($member_query)) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($row['member_id']) . '">' . 
                                                htmlspecialchars($row['firstname'] . " " . $row['lastname']) . '</option>';
                                        }
                                        $result->free();
                                    } else {
                                        echo '<option value="">No members found</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group"> 
                            <label class="control-label" for="inputEmail">Due Date</label>
                            <div class="controls">
                                <input type="text" class="w8em format-d-m-y highlight-days-67 range-low-today" name="due_date" id="sd" maxlength="10" style="border: 3px double #CCCCCC;" required />
                            </div>
                        </div>

                        <div class="control-group"> 
                            <div class="controls">
                                <button name="delete_student" class="btn btn-default">Borrow</button>
                            </div>
                        </div>
                    </div>

                    <div class="span8">
                        <div class="alert alert-success"><strong>Select Book</strong></div>
                        <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Acc No.</th>                                 
                                    <th>Book Title</th>                                 
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Publisher Name</th>
                                    <th>Status</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch books
                                $book_query = "SELECT book_id, book_title, category_id, author, publisher_name, status FROM book WHERE status != 'Archive'";
                                if ($result_books = $conn->query($book_query)) {
                                    // Prepare category stmt once outside loop
                                    $cat_stmt = $conn->prepare("SELECT classname FROM category WHERE category_id = ?");

                                    while ($book = $result_books->fetch_assoc()) {
                                        $cat_stmt->bind_param("i", $book['category_id']);
                                        $cat_stmt->execute();
                                        $cat_stmt->bind_result($classname);
                                        $cat_stmt->fetch();

                                        echo '<tr class="del' . htmlspecialchars($book['book_id']) . '">';
                                        echo '<td>' . htmlspecialchars($book['book_id']) . '</td>';
                                        echo '<td>' . htmlspecialchars($book['book_title']) . '</td>';
                                        echo '<td>' . htmlspecialchars($classname) . '</td>';
                                        echo '<td>' . htmlspecialchars($book['author']) . '</td>';
                                        echo '<td>' . htmlspecialchars($book['publisher_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($book['status']) . '</td>';

                                        include('toolttip_edit_delete.php'); // make sure this file does not expect $id but $book['book_id'] if needed

                                        echo '<td width="20">';
                                        echo '<input class="uniform_on" name="selector[]" type="checkbox" value="' . htmlspecialchars($book['book_id']) . '">';
                                        echo '</td>';
                                        echo '</tr>';
                                    }

                                    $cat_stmt->close();
                                    $result_books->free();
                                } else {
                                    echo '<tr><td colspan="7">No books found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>

        <script>
        $(".uniform_on").change(function(){
            var max= 3;
            if( $(".uniform_on:checked").length == max ){
                $(".uniform_on").attr('disabled', 'disabled');
                alert('3 Books are allowed per borrow');
                $(".uniform_on:checked").removeAttr('disabled');
            } else {
                $(".uniform_on").removeAttr('disabled');
            }
        })
        </script>      
    </div>
</div>

<?php include('footer.php'); ?>
