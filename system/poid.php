
<?php
    date_default_timezone_set("Asia/Manila"); 
    $date = date('m-d-Y');
    $time = date('h:i A');

    $usercode = $_SESSION['code'];
    $id = $_GET['id'];
    $name = $get_info_fetch['users_name'];

    $transact_sql = "SELECT * FROM upti_transaction WHERE id = '$id'";
    $transact_qry = mysqli_query($connect, $transact_sql);
    $transact = mysqli_fetch_array($transact_qry);

    $mypoid = $transact['trans_poid'];
    $images = $transact['trans_img'];

    $order_sql = "SELECT * FROM upti_order_list WHERE ol_poid = '$mypoid'"; 
    $order_qry = mysqli_query($connect, $order_sql);
    $order = mysqli_fetch_array($order_qry);
    
    $myid = $_SESSION['uid'];
    $phpprice = $order['ol_php'];

    $get_country_sql = "SELECT * FROM upti_users WHERE users_id = '$myid'";
    $get_country_qrys = mysqli_query($connect, $get_country_sql);
    $get_country_fetch = mysqli_fetch_array($get_country_qrys);

    $employee = $get_country_fetch['users_employee'];

    $cc = $transact['trans_country'];
    $states = $transact['trans_state'];

    if ($states == '') {
      $states = 'ALL';
    }
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- START HERE -->
    <section class="content">
        <div class="container-fluid">             
              <!-- /.card-header -->
            <div class="card-body"> 
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                Order Information
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Reference Number:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $transact['trans_poid'] ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Customer Name:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $transact['trans_fname'] ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Mobile Number:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $transact['trans_contact'] ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Complete Address:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $transact['trans_address'] ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Delivery Options:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $transact['trans_office'] ?> (<?php echo $transact['trans_office_status'] ?>)</p>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Order Date & Time:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $transact['trans_date'] ?> <?php echo $transact['trans_time'] ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Payment Method:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                    <?php echo $transact['trans_mop'] ?><br>
                                    <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#image<?php echo $id; ?>"><i class="fas fa-image"></i>&nbsp;&nbsp; Receipt</button>
                                    </div>
                                </div>
                                <hr>
                                <span>Transaction Information:</span>
                                <br><br>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>State :</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $states ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Country :</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p><?php echo $cc ?></p>
                                    </div>
                                </div>
                                <hr>
                                <span class="">Transaction Information:</span>
                                <br><br>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Shipping Fee:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p class="text-right"><?php echo $transact['trans_ship'] ?></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Subtotal:</b>
                                        <?php $total_amount = $transact['trans_subtotal'] ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p class="text-right text-success font-weight-bold"><?php echo number_format($total_amount, '2') ?></p>
                                    </div>
                                    <?php if ($_SESSION['uid'] == '774') { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Peso Kier:</b>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <!-- <p class="text-right"><?php //echo $phpprice ?></p> -->
                                        <?php 
                                          $ph_price = mysqli_query($connect, "SELECT * FROM upti_order_list WHERE ol_poid = '$mypoid'");
                                          echo '<p class="text-right">';  
                                          echo '=';
                                          foreach ($ph_price as $data) {
                                            
                                            $codedata =  $data['ol_code'];
                                            $codeqty =  $data['ol_qty'];
                                            // echo ' ';
                                            $sum_price = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_code = '$codedata' AND country_name = 'PHILIPPINES'");
                                            $sum_fetch = mysqli_fetch_array($sum_price);
                                            $php = $sum_fetch['country_price'] * $codeqty;
                                            echo $php.'+';
                                            // echo '<br>';
                                            // $total = 
                                          }
                                          echo '</p>';
                                          // echo $php;
                                        ?>
                                    </div>
                                    <?php } ?>
                                    <div class="col-12">
                                        <span>Order Status:</span>
                                        <br><br>
                                        <?php
                                            $status = $transact['trans_status'];
                                            if ($status == 'Pending') {
                                        ?>
                                        <img src="images/process/pending.png" alt="" class="image-responsive" width="100%">
                                        <?php } elseif ($status == 'In Transit') { ?>
                                        <img src="images/process/intransit.png" alt="" class="image-responsive" width="100%">
                                        <?php } elseif ($status == 'Delivered') { ?>
                                        <img src="images/process/delivered.png" alt="" class="image-responsive" width="100%">
                                        <?php } elseif ($status == 'Canceled') { ?>
                                        <img src="images/process/canceled.png" alt="" class="image-responsive" width="100%">
                                        <?php } elseif ($status == 'On Process') { ?>
                                        <img src="images/process/onprocess.png" alt="" class="image-responsive" width="100%">
                                        <?php } elseif ($status == 'RTS') { ?>
                                        <img src="images/process/rts.png" alt="" class="image-responsive" width="100%">
                                        <?php } ?>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <span>Inclusions</span>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $items_sql = "SELECT * FROM upti_order_list WHERE ol_poid = '$mypoid'";
                                        $items_qry = mysqli_query($connect, $items_sql);
                                        while ($items = mysqli_fetch_array($items_qry)) {
                                            $presyo = $items['ol_price'];
                                            $buo = $items['ol_subtotal'];
                                            $code = $items['ol_code'];
                                            $country_pack = $items['ol_country'];

                                            $realme_num_sql = mysqli_query($connect, "SELECT * FROM upti_package WHERE package_code = '$code'");
                                            $realme_num_row = mysqli_num_rows($realme_num_sql);
                                                        
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                                if ($realme_num_row == 1) {
                                            ?>
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#pack<?php echo $items['id']; ?>"><?php echo $code; ?></button>
                                            <?php
                                                } else {
                                                    echo $code;
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $items['ol_desc'] ?></td>
                                        <td class="text-center"><?php echo number_format($presyo, '2', '.', ',') ?></td>
                                        <td class="text-center"><?php echo $items['ol_qty'] ?></td>
                                        <td class="text-center"><?php echo number_format($buo, '2', '.', ',') ?></td>
                                    </tr>
                                    <?php include 'backend/bundle.php'; } ?>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <span>ORDER TRACKING</span>
                            </div>
                            <div class="card-body">
                                <?php
                                    if (isset($_POST['comment'])) {
                                        $comment_mo = $_POST['comment_text'];

                                        $role = $_SESSION['role'];
                                        
                                        if ($role == 'BRANCH' || $role == 'UPTIMAIN') {
                                            $remarks_sql = "INSERT INTO upti_remarks (remark_time, remark_date, remark_poid, remark_name, remark_content, remark_reseller) VALUES ('$time', '$date', '$mypoid', '$name', '$comment_mo', 'Unread')";
                                            $remarks_qry = mysqli_query($connect, $remarks_sql);
                                        } else {
                                            $remarks_sql = "INSERT INTO upti_remarks (remark_time, remark_date, remark_poid, remark_name, remark_content, remark_csr) VALUES ('$time', '$date', '$mypoid', '$name', '$comment_mo', 'Unread')";
                                            $remarks_qry = mysqli_query($connect, $remarks_sql);
                                        }

                                        ?>
                                            <script>window.location='poid-list.php?id=<?php echo $id; ?>'</script>";
                                        <?php

                                    }
                                ?>
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <textarea name="comment_text" id="" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                              <?php if ($role == 'RESELLER' || $role == 'OSR' || $role == 'STOCKIST') { ?>
                                                <button class="btn btn-success btn-sm" name="comment">Submit</button>
                                              <?php } ?>
                                            </div>
                                        </div>
                                </form>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <div class="card p-3" style="border: 1px solid #333">
                                                <div class="row">
                                                <?php

                                                    $id = $_GET['id'];

                                                    $transact_sql = "SELECT * FROM upti_transaction WHERE id = '$id'";
                                                    $transact_qry = mysqli_query($connect, $transact_sql);
                                                    $transact = mysqli_fetch_array($transact_qry);

                                                    $mypoid = $transact['trans_poid'];

                                                    $comment_sql = "SELECT * FROM upti_remarks WHERE remark_poid = '$mypoid' ORDER BY id DESC";
                                                    $comment_qry = mysqli_query($connect, $comment_sql);
                                                    $comment_num = mysqli_num_rows($comment_qry);
                                                    if ($comment_num > 0) {
                                                    while ($comment = mysqli_fetch_array($comment_qry)) {
                                                ?>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <b><?php echo $comment['remark_name'] ?></b> <br>
                                                        <i><?php echo $comment['remark_date'] ?> <?php echo $comment['remark_time'] ?></i>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                                        <?php echo $comment['remark_content'] ?>
                                                    </div>
                                                    <div class="col-12">
                                                        <hr>
                                                    </div>
                                                <?php } ?>
                                                <?php } else { ?>
                                                    <div class="col-12">
                                                        <i>No Comment</i>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
  </div>
<?php 
  include 'backend/receipt.php';
  include 'include/footer.php';
?>
<script type="text/javascript">
    <?php if (isset($_SESSION['poid'])) { ?>

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-bottom",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr.success("<?php echo flash('poid'); ?>");

    <?php } ?>

    <?php if (isset($_SESSION['warning'])) { ?>

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        toastr.error("<?php echo flash('warning'); ?>");

    <?php } ?>
</script>