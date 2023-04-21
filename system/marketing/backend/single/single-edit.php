<div class="modal fade" id="edit<?php echo $item['id']; ?>">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Item Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="backend/single/edit-process.php?id=<?php echo $item['id']; ?>" method="post">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Item Code</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="code">
                            <option value="<?php echo $item['items_code']; ?>"><?php echo $item['items_code']; ?></option>
                            <?php
                            $product_sql = "SELECT * FROM upti_code WHERE code_status = 'Single'";
                            $product_qry = mysqli_query($connect, $product_sql);
                            while ($product = mysqli_fetch_array($product_qry)) {
                            ?>
                            <option value="<?php echo $product['code_name'] ?>"><?php echo $product['code_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
              
                <div class="col-6">
                    <div class="form-group">
                        <label>Item Status</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="stats">
                            <option value="<?php echo $item['items_status']; ?>"><?php echo $item['items_status']; ?></option>
                            <option value="Active">Active</option>
                            <option value="Deactive">Deactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-9">
                    <label for="">Description</label>
                    <input type="text" class="form-control" name="desc" autocomplete="off" required value="<?php echo $item['items_desc']; ?>">
                </div>
                <div class="col-3">
                    <label for="">Points</label>
                    <input type="text" class="form-control" name="points" autocomplete="off" required value="<?php echo $item['items_points']; ?>">
                </div>
                
            </div>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default border-info rounded-0" data-dismiss="modal">Close</button>
        <button class="btn btn-primary rounded-0" name="item">Submit</button>
        </form>
        </div>
        
    </div>
    </div>
</div>