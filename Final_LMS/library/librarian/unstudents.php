<?php
// Assuming $conn is your mysqli connection from dbcon.php
$query = "SELECT * FROM students WHERE status = 'unactive'";
if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['student_id'];
        ?>
        <tr class="del<?php echo $id; ?>">
            <td><?php echo htmlspecialchars($row['student_no']); ?></td>
            <!-- Removed password display -->
            <td><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></td>
            <td><?php echo htmlspecialchars($row['course']); ?></td>
            <td><?php echo htmlspecialchars($row['gender']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['contact']); ?></td>
            <td width="60">
                <img src="<?php echo htmlspecialchars($row['photo']); ?>" width="60" height="60" alt="Student Photo">
            </td>
            <?php include('toolttip_edit_delete.php'); ?>
            <td width="150">
                <a href="#confirm<?php echo $id; ?>" data-toggle="modal" class="btn btn-success">
                    <i class="icon-check"></i>&nbsp;Confirm Request
                </a>
                <?php include('confirm_request.php'); ?>
            </td>
        </tr>
        <?php
    }
    $result->free();
} else {
    echo "Query failed: " . $conn->error;
}
?>
