<?php
   
    date_default_timezone_set('Asia/Manila');
    
    $my_name = $_SESSION['code'];

    if (isset($_POST['code'])) {

        $name = $_POST['name'];
        $status = $_POST['status'];
        $category = $_POST['category'];
        $main = $_POST['maincode'];

        $check_fee = "SELECT * FROM upti_code WHERE code_name = '$name'";
        $check_fee_qry = mysqli_query($connect, $check_fee);
        $check_num_row = mysqli_num_rows($check_fee_qry);

        if ($check_num_row == 0) {
            $epayment_process = "INSERT INTO upti_code (code_name, code_status, code_category, code_main) VALUES ('$name', '$status', '$category', '$main')";
            $epayment_process_qry = mysqli_query($connect, $epayment_process);
            
            $remarks = "CODE ".$name." HAS BEEN ADDED BY ".$my_name;
            
            $history = "INSERT INTO upti_activities 
                (
                activities_poid,
                activities_time,
                activities_date,
                activities_name,
                activities_caption,
                activities_desc
                ) VALUES (
                '$name',
                '$time',
                '$date',
                '$my_name',
                'CREATE',
                '$remarks'
                )";
                $history_qry = mysqli_query($connect, $history);

            echo "<script>alert('Data has been Added successfully.');window.location.href = 'code.php';</script>";
        } else {
            echo "<script>alert('Duplicate code is not allowed');window.location.href = 'code.php';</script>";
        }

    }
?>
<div class="modal fade" id="add">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Register Item Code</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="code" method="post">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Item Status</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="status">
                            <option value="">Select Status</option>
                            <option value="Single">Single</option>
                            <option value="Package">Package</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Item Category</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="category">
                            <option value="">Select Category</option>
                            <option value="PROMO">PROMO</option>
                            <option value="RESELLER">RESELLER</option>
                            <option value="UPSELL">UPSELL</option>
                            <option value="DIRECT">DIRECT</option>
                            <option value="PREMIUM">PREMIUM</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                  <label for="">Item Code</label>
                  <input type="text" class="form-control" name="name" autocomplete="off" required>
                  <br>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Main Code<i class="text-danger"> For Inventory</i></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="maincode">
                            <option value="">Select Item Code</option>
                            <?php
                                $product_sql = "SELECT * FROM upti_items WHERE items_code LIKE 'UP0%'";
                                $product_qry = mysqli_query($connect, $product_sql);
                                while ($product = mysqli_fetch_array($product_qry)) {
                            ?>
                            <option value="<?php echo $product['items_code'] ?>"><?php echo $product['items_desc'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default border-info rounded-0" data-dismiss="modal">Close</button>
            <button class="btn btn-primary rounded-0" name="code">Submit</button>
        </form>
        </div>
        
    </div>
    </div>
</div>