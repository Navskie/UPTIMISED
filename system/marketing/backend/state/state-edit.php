<div class="modal fade" id="edit<?php echo $state['id']; ?>">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">States</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="backend/state/edit-process?id=<?php echo $state['id']; ?>" method="post">
            <div class="row">
                <div class="col-12">
                    <label for="">State</label>
                    <input type="text" class="form-control" name="state" autocomplete="off" required value="<?php echo $state['state_name']; ?>">
                </div>
                <div class="col-12">
                  <br>
                    <label for="">Country</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="country">
                      <option value="<?php echo $state['state_country']; ?>"><?php echo $state['state_country']; ?></option>
                      <?php
                          $lugar = "SELECT DISTINCT cc_country FROM upti_country_currency";
                          $lugar_qry = mysqli_query($connect, $lugar);
                          while ($lugar_fetch = mysqli_fetch_array($lugar_qry)) {
                      ?>
                      <option value="<?php echo $lugar_fetch['cc_country'] ?>"><?php echo $lugar_fetch['cc_country'] ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="col-12">
                  <br>
                    <label for="">Territory</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="territory">
                      <option value="<?php echo $state['state_territory']; ?>"><?php echo $state['state_territory']; ?></option>
                      <?php
                          $lugar = "SELECT * FROM upti_territory";
                          $lugar_qry = mysqli_query($connect, $lugar);
                          while ($lugar_fetch = mysqli_fetch_array($lugar_qry)) {
                      ?>
                      <option value="<?php echo $lugar_fetch['territory_name'] ?>"><?php echo $lugar_fetch['territory_name'] ?></option>
                      <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default border-info rounded-0" data-dismiss="modal">Close</button>
        <button class="btn btn-primary rounded-0" name="editbansa">Submit</button>
        </form>
        </div>
        
    </div>
    </div>
</div>