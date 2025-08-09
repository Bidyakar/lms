<?php
include('dbcon.php'); // Make sure this creates $conn as mysqli connection
include('session.php'); // User session check

// Handle returning a book if 'return_id' is set in GET
if (isset($_GET['return_id'])) {
    $borrow_details_id = intval($_GET['return_id']);
    $date_return = date('Y-m-d');

    $update_sql = "UPDATE borrowdetails 
                   SET date_return = ?, borrow_status = 'Returned' 
                   WHERE borrow_details_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $date_return, $borrow_details_id);

    if ($stmt->execute()) {
        header('Location: view_borrow.php?success=1');
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<?php include('header.php'); ?>
<?php include('navbar_borrow.php'); ?>

<div class="container">
    <div class="margin-top">
        <div class="row">  
            <div class="span12">      
                <div class="alert alert-info"><strong>Borrowed Books</strong></div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Book returned successfully.</div>
                <?php endif; ?>

                <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                    <thead>
                        <tr>
                            <th>Book Title</th>                                 
                            <th>Borrower</th>                                 
                            <th>Year Level</th>                                 
                            <th>Date Borrow</th>                                 
                            <th>Due Date</th>                                
                            <th>Date Returned</th>
                            <th>Borrow Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT borrow.borrow_id, borrow.member_id, borrow.date_borrow, borrow.due_date, 
                                       member.firstname, member.lastname, member.year_level,
                                       borrowdetails.borrow_details_id, borrowdetails.book_id, borrowdetails.date_return, borrowdetails.borrow_status,
                                       book.book_title
                                FROM borrow
                                LEFT JOIN member ON borrow.member_id = member.member_id
                                LEFT JOIN borrowdetails ON borrow.borrow_id = borrowdetails.borrow_id
                                LEFT JOIN book ON borrowdetails.book_id = book.book_id
                                ORDER BY borrow.borrow_id DESC";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['year_level']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_borrow']); ?></td>
                                    <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_return'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($row['borrow_status']); ?></td>
                                    <td>
                                        <?php if ($row['borrow_status'] != 'Returned') { ?>
                                            <a href="view_borrow.php?return_id=<?php echo $row['borrow_details_id']; ?>" 
                                               class="btn btn-success"
                                               onclick="return confirm('Mark this book as returned?');">
                                                Return
                                            </a>
                                        <?php } else {
                                            echo '<span class="text-success">Returned</span>';
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="8">No borrowed books found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>      
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
