<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header"></div>
  <div class="modal-body">
    <form class="form-horizontal" method="post" action="advance_search.php">
      <div class="control-group">
        <div class="controls">
          <input type="text" name="title" id="search_title" placeholder="Title" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="text" name="author" id="search_author" placeholder="Author" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-default">Search</button>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
