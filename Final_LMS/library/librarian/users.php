<?php
include('dbcon.php');  // Make sure this defines $conn as mysqli connection

// Fetch users securely
$user_query = $conn->query("SELECT user_id, username, firstname, lastname FROM users");
if (!$user_query) {
    die("Query failed: " . $conn->error);
}

while ($row = $user_query->fetch_assoc()) {
    $id = $row['user_id'];
    echo "<tr class='del$id'>
            <td>{$row['username']}</td>
            <td>********</td>  <!-- Hide password -->
            <td>{$row['firstname']}</td>
            <td>{$row['lastname']}</td>
            <td width='100'>
                <div class='span2'>
                <a rel='tooltip' title='Delete' id='$id' href='#delete_user$id' data-toggle='modal' class='btn-default'>
                    <i class='icon-trash icon-large'></i></a>";
                include('delete_user_modal.php');
    echo       "<div class='span1'>
                <a rel='tooltip' title='Edit' id='e$id' href='#edit$id' data-toggle='modal' class='btn-default'>
                    <i class='icon-pencil icon-large'></i></a>";
                include('modal_edit_user.php');
    echo       "</div></div>
            </td>
          </tr>";
}
?>
