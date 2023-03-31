<div class="modal fade" id="edits<?php echo $ol_fetch['id']; ?>">
    <div class="modal-dialog modal-dialog-centered" style="border-radius: 0px !important;">
        <div class="modal-content bg-default">
            <div class="modal-header">
            <h4 class="modal-title">Edit Quantity</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="backend/void-edit-process.php?id=<?php echo $ol_fetch['id']; ?>" method="post">
              <div class="modal-body">
                  <label for="">New Quantity</label>
                  <input type="text" class="form-control" name="qty">
              </div>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 0px !important;">Close</button>
              <button class="btn btn-warning" name="test">Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>