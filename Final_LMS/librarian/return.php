<?php
include('header.php');
include('session.php');
include('navbar_borrow.php');
include('dbcon.php'); // Your mysqli connection

// Query to fetch returned books with joins
$sql = "
    SELECT 
        b.book_title, 
        m.firstname, m.lastname, m.year_level,
        br.date_borrow, br.due_date, bd.date_return,
        br.borrow_id
    FROM borrow br
    LEFT JOIN member m ON br.member_id = m.member_id
    LEFT JOIN borrowdetails bd ON br.borrow_id = bd.borrow_id
    LEFT JOIN book b ON bd.book_id = b.book_id
    WHERE bd.borrow_status = 'returned'
    ORDER BY br.borrow_id DESC
";

$result = $conn->query($sql) or die($conn->error);
?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">        
                <div class="alert alert-danger"><strong>Returned Books</strong></div>

                <div class="pull-right" style="margin-bottom:10px;">
                    <a href="#" onclick="window.print()" class="btn btn-default">Print</a>
                </div>

                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>Book Title</th>                                 
                            <th>Borrower</th>                                 
                            <th>Year Level</th>                                 
                            <th>Date Borrowed</th>                                 
                            <th>Due Date</th>                                
                            <th>Date Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['year_level']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_borrow']); ?></td>
                            <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_return']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
