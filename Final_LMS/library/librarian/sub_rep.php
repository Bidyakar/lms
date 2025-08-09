<?php 
include('dbcon.php'); // Make sure this creates a $conn = new mysqli(...) connection

$query = "SELECT book.*, category.classname FROM book 
          LEFT JOIN category ON book.category_id = category.category_id
          WHERE book.status = 'Subject for Replacement'";

if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['book_id'];
        ?>
        <tr class="del<?php echo $id ?>">
            <td><?php echo htmlspecialchars($row['book_id']); ?></td>
            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
            <td><?php echo htmlspecialchars($row['classname']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td class="action"><?php echo htmlspecialchars($row['book_copies']); ?></td>
            <td><?php echo htmlspecialchars($row['book_pub']); ?></td>
            <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
            <td><?php echo htmlspecialchars($row['copyright_year']); ?></td>
            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
            <?php include('toolttip_edit_delete.php'); ?>
            <td class="action">
                <div class="span2">
                    <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal" class="btn-default">
                        <i class="icon-trash icon-large"></i>
                    </a>
                    <?php include('delete_book_modal.php'); ?>
                    <div class="span1">
                        <a rel="tooltip" title="Edit" id="e<?php echo $id; ?>" href="edit_book.php?id=<?php echo $id; ?>" class="btn-default">
                            <i class="icon-pencil icon-large"></i>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <?php
    }
    $result->free();
} else {
    echo "Error: " . $conn->error;
}
?>
