<?php
    if (isset($_POST['package'])) {
        $itemcode = $_POST['itemcode'];
        $itemqty = $_POST['itemqty'];
        
        $pack_code = $_GET['id'];

        $get_package_sql = "SELECT * FROM upti_pack_sett WHERE p_s_code = '$pack_code' AND p_s_main = '$pack_code'";
        $get_package_qry = mysqli_query($connect, $get_package_sql);
        $get_num_code = mysqli_num_rows($get_package_qry);

        if ($get_num_code == 0) {
            if ($itemcode == '') {
              echo "<script>alert('Item Code is missing.');window.location.href = 'item-package-setting.php?id=".$pack_code."';</script>"; 
            } else {
              $desc_qry = "SELECT items_desc FROM upti_items WHERE items_code = '$itemcode'";
              $desc_sql = mysqli_query($connect, $desc_qry);
              $desc_fetch = mysqli_fetch_array($desc_sql);

              $desc = $desc_fetch['items_desc'];

              $packages = "INSERT INTO upti_pack_sett (p_s_code, p_s_desc, p_s_qty, p_s_main) VALUES ('$itemcode', '$desc' , '$itemqty', '$pack_code')";
              $package_qry = mysqli_query($connect, $packages);

              echo "<script>alert('Data has been Added successfully.');window.location.href = 'item-package-setting.php?id=".$pack_code."';</script>";
            }
        } else {
            echo "<script>alert('Duplicate code is not allowed.');window.location.href = 'item-package-setting.php?id=".$pack_code."';</script>";
        }

    }
?>
<div class="modal fade" id="add">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Package Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="item-package-setting.php?id=<?php echo $_GET['id'] ?>" method="post">
            <div class="row">
              <div class="col-9">
                <div class="form-group">
                  <label>Item Code</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="itemcode">
                    <option value="">Select Package Code</option>
                    <?php
                    $product_sql = "SELECT * FROM `upti_items` WHERE `items_code` LIKE '%UP0%'";
                    $product_qry = mysqli_query($connect, $product_sql);
                      while ($product = mysqli_fetch_array($product_qry)) {
                    ?>
                    <option value="<?php echo $product['items_code'] ?>"><?php echo $product['items_desc'] ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12">
                <label for="">Qty</label>
                <input type="number" class="form-control" name="itemqty" autocomplete="off" required>
              </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default rounded-0 border-info" data-dismiss="modal">Close</button>
        <button class="btn btn-primary rounded-0" name="package">Submit</button>
        </form>
        </div>
        
    </div>
    </div>
</div>