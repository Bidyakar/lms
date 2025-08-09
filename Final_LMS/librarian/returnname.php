<form class="form-horizontal" method="post">
    <div class="control-group">
        <label class="control-label" for="returnee_name">Member Name</label>
        <div class="controls">
            <select name="returnee_name" id="returnee_name" required>
                <option value="">Select member</option>
                <?php 
                $result = $conn->query("SELECT member_id, firstname, lastname FROM member") or die($conn->error);
                while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($row['member_id']); ?>">
                        <?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="due_date">Due Date</label>
        <div class="controls">
            <input type="text" class="w8em format-d-m-y highlight-days-67 range-low-today" name="due_date" id="due_date" maxlength="10" style="border: 3px double #CCCCCC;" required/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="return_date">Return Date</label>
        <div class="controls">
            <input type="text" class="w8em format-d-m-y highlight-days-67 range-low-today" name="return_date" id="return_date" maxlength="10" style="border: 3px double #CCCCCC;" required/>
        </div>
    </div>
</form>
