<?php 
include('header.php'); 
include('session.php'); 
include('navbar_member.php'); 
include('dbcon.php'); // Your mysqli connection ($conn)
?>

<div class="container">
    <div class="margin-top">
        <div class="row">    
            <div class="span12">    
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="icon-user icon-large"></i>&nbsp;Member Table</strong>
                </div>

                <p><a href="add_member.php" class="btn-default">&nbsp;Add Member</a></p>

                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>Name</th>                                 
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Year level</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Prepare and execute query
                        $stmt = $conn->prepare("SELECT member_id, firstname, lastname, gender, address, contact, type, year_level, status FROM member");
                        $stmt->execute();
                        $stmt->bind_result($id, $firstname, $lastname, $gender, $address, $contact, $type, $year_level, $status);

                        while ($stmt->fetch()) {
                        ?>
                            <tr class="del<?php echo htmlspecialchars($id); ?>">
                                <td><?php echo htmlspecialchars($firstname . " " . $lastname); ?></td>
                                <td><?php echo htmlspecialchars($gender); ?></td>
                                <td><?php echo htmlspecialchars($address); ?></td>
                                <td><?php echo htmlspecialchars($contact); ?></td>
                                <td><?php echo htmlspecialchars($type); ?></td>
                                <td><?php echo htmlspecialchars($year_level); ?></td>
                                <td><?php echo htmlspecialchars($status); ?></td>
                                <?php include('toolttip_edit_delete.php'); ?>
                                <td width="100">
                                    <div class="span2">
                                        <a rel="tooltip" title="Delete" id="<?php echo htmlspecialchars($id); ?>" href="#delete_student<?php echo htmlspecialchars($id); ?>" data-toggle="modal" class="btn-default"><i class="icon-trash icon-large"></i></a>
                                        <?php include('delete_student_modal.php'); ?>
                                        <div class="span1">
                                            <a rel="tooltip" title="Edit" id="e<?php echo htmlspecialchars($id); ?>" href="edit_member.php?id=<?php echo htmlspecialchars($id); ?>" class="btn-default"><i class="icon-pencil icon-large"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
            </div>      
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
