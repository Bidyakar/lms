<div id="returnBookModal<?php echo $borrow_details_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $borrow_details_id; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div class="alert alert-success">Do you want to Return this Book?</div>
      </div>

      <div class="modal-footer">
        <a class="btn btn-success" href="return_save.php?id=<?php echo $borrow_id; ?>&book_id=<?php echo $borrow_details_id; ?>">Yes</a>
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
      </div>

    </div>
  </div>
</div>
