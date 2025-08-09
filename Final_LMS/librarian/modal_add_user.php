<div id="add_user" class="modal hide fade" tabindex="-1" role="dialog">
    <form method="POST" action="add_user.php">
        <div class="modal-header">
            <h4>Add User</h4>
        </div>
        <div class="modal-body">
            <input type="text" name="username" placeholder="Username" required class="form-control"><br>
            <input type="password" name="password" placeholder="Password" required class="form-control"><br>
            <input type="text" name="firstname" placeholder="First Name" required class="form-control"><br>
            <input type="text" name="lastname" placeholder="Last Name" required class="form-control"><br>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit" name="submit">Save</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </form>
</div>
