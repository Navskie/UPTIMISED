<div class="modal fade" id="edit<?php echo $package['id']; ?>">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Package Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="backend/bundle/edit-process?id=<?php echo $package['id']; ?>" method="post">
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label>Package Code</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="pack_code">
                          <option value="<?php echo $package['package_code']; ?>"><?php echo $package['package_code']; ?></option>
                          <?php
                          $product_sql = "SELECT * FROM upti_code WHERE code_status = 'Package'";
                          $product_qry = mysqli_query($connect, $product_sql);
                          while ($product = mysqli_fetch_array($product_qry)) {
                          ?>
                          <option value="<?php echo $product['code_name'] ?>"><?php echo $product['code_name'] ?></option>
                          <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                      <label>Package Code</label>
                      <select class="form-control select2bs4" style="width: 100%;" name="stats">
                        <option value="<?php echo $package['package_status']; ?>"><?php echo $package['package_status']; ?></option>
                        <option value="Active">Active</option>
                        <option value="Deactive">Deactive</option>
                      </select>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <label for="">Package Description</label>
                    <input type="text" class="form-control" name="pack_desc" autocomplete="off" required value="<?php echo $package['package_desc']; ?>">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <label for="">Points</label>
                    <input type="number" class="form-control" name="pack_points" autocomplete="off" required value="<?php echo $package['package_points']; ?>">
                </div>                
            </div>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default border-info rounded-0" data-dismiss="modal">Close</button>
        <button class="btn btn-primary rounded-0" name="package">Submit</button>
        </form>
        </div>
        
    </div>
    </div>
</div>