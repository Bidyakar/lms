<!-- Return Book Modal -->
<div id="delete_book<?php echo $borrow_details_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
		<div class="alert alert-success">Do you want to return this book?</div>
	</div>
	<div class="modal-footer">
		<!-- Use URL parameters properly encoded -->
		<a class="btn btn-success" href="return_save.php?id=<?php echo urlencode($id); ?>&book_id=<?php echo urlencode($book_id); ?>">Yes</a>
		<button class="btn" data-dismiss="modal" aria-hidden="true">
			<i class="icon-remove icon-large"></i>&nbsp;Close
		</button>
	</div>
</div>
