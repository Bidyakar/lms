<?php
include('header.php');
include('session.php');
include('navbar_user.php');
include('dbcon.php');
?>

<div class="container">
    <div class="margin-top">
        <div class="row">
            <div class="span2">
                <ul class="nav nav-stacked">
                    <li><a href="#add_user" data-toggle="modal"><strong>Add User</strong></a></li>
                </ul>
                <?php include('modal_add_user.php'); ?>
            </div>

            <div class="span10">
                <div class="alert alert-danger">
                    <strong><i class="icon-user icon-large"></i> Users Table</strong>
                </div>

                <table class="table table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $conn->query("SELECT * FROM users") or die($conn->error);
                        while ($row = $query->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['password']) ?></td>
                            <td><?= htmlspecialchars($row['firstname']) ?></td>
                            <td><?= htmlspecialchars($row['lastname']) ?></td>
                            <td>
                                <!-- Edit/Delete buttons -->
                                <a href="#edit<?php echo $row['user_id']; ?>" data-toggle="modal" class="btn btn-default"><i class="icon-pencil"></i></a>
                                <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-default" onclick="return confirm('Are you sure?');"><i class="icon-trash"></i></a>
                                <?php include('modal_edit_user.php'); ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
