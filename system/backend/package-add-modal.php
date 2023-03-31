<?php
    if (isset($_POST['package'])) {
        $pack_type = $_POST['pack_type'];
        $pack_code = $_POST['pack_code'];
        $pack_desc = $_POST['pack_desc'];
        $pack_points = $_POST['pack_points'];

        $get_package_sql = "SELECT * FROM upti_package WHERE package_code = '$pack_code'";
        $get_package_qry = mysqli_query($connect, $get_package_sql);
        $get_num_code = mysqli_num_rows($get_package_qry);

        if ($get_num_code == 0) {
            if ($pack_code == '') {
                echo "<script>alert('Package Code is missing.');window.location.href = 'item-package.php';</script>"; 
            } else {
                $packages = "INSERT INTO upti_package (package_code, package_desc, package_points, package_status) VALUES ('$pack_code', '$pack_desc' , '$pack_points', 'Active')";
                $package_qry = mysqli_query($connect, $packages);

                echo "<script>alert('Data has been Added successfully.');window.location.href = 'item-package.php';</script>";
            }
        } else {
            echo "<script>alert('Duplicate Package code is not allowed.');window.location.href = 'item-package.php';</script>";
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
        <form action="item-package.php" method="post">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Package Code</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="pack_code">
                    <option value="">Select Package Code</option>
                    <?php
                    $product_sql = "SELECT * FROM upti_code WHERE code_status = 'Package' ORDER BY id DESC";
                    $product_qry = mysqli_query($connect, $product_sql);
                      while ($product = mysqli_fetch_array($product_qry)) {
                    ?>
                    <option value="<?php echo $product['code_name'] ?>"><?php echo $product['code_name'] ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-12">
                <label for="">Package Description</label>
                <input type="text" class="form-control" name="pack_desc" autocomplete="off" required>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12">
                <label for="">Points</label>
                <input type="number" class="form-control" name="pack_points" autocomplete="off" required>
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