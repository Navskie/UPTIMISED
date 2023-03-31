<?php include 'include/header.php'; ?>
<?php
    $SCode = $_SESSION['code'];
    
    $check_stockist = "SELECT * FROM stockist WHERE stockist_code = '$SCode'";
    $check_stockist_qry = mysqli_query($connect, $check_stockist);
    $check_stockist_num = mysqli_num_rows($check_stockist_qry);
    $check_stockist_f = mysqli_fetch_array($check_stockist_qry);
    
    if ($check_stockist_num > 0) {

      $code = $check_stockist_f['stockist_code'];
      $country = $check_stockist_f['stockist_country'];
      $s_role = $check_stockist_f['stockist_role']; 
?>
<?php include 'include/preloader.php'; ?>
<?php include 'include/navbar.php'; ?>
<?php include 'include/stockist-bar.php'; ?>
<?php
      $month = date('m');
      $year = date('Y');
      $date1 = $month.'-01-'.$year;
      $date2 = date('m-d-Y');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: #f8f8f8 !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-body login-card-body text-dark">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="float-left text-info">Delivered Orders</h4>
                             <!-- Order List Table Start -->
                            <table id="example1" class="table table-sm table-striped table-hover border border-info">
                                <thead>
                                    <tr>
                                      <th class="text-center">#</th>
                                      <th class="text-center">Poid</th>
                                      <th class="text-center">Reseller</th>
                                      <th class="text-center">Country</th>
                                      <th class="text-center">Name</th>
                                      <th class="text-center">Date & Time</th>
                                      <th class="text-center">Mode of Payment</th>
                                      <th class="text-center">Image</th>
                                      <th class="text-center">Total</th>
                                      <th class="text-center">Status</th>
                                      <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <?php

                                    $order_sql = "SELECT * FROM upti_transaction WHERE trans_status= 'Delivered' AND trans_country = '$country' AND trans_date BETWEEN '$date1' AND '$date2' ORDER BY trans_date ASC";
                                    $order_qry = mysqli_query($connect, $order_sql);
                                    $number =1;
                                    while ($order = mysqli_fetch_array($order_qry)) {
                                        $total = $order['trans_subtotal'];
                                        $status = $order['trans_status'];
                                        $reseller = $order['trans_my_reseller'];
                                        $seller = $order['trans_seller'];
                                        $poid = $order['trans_poid'];
                                        $state = $order['trans_state'];
                                        
                                        $get_name = "SELECT * FROM upti_users WHERE users_code = '$seller' AND users_employee = '' AND users_role = 'UPTIRESELLER'";
                                        $get_name_qry = mysqli_query($connect, $get_name);
                                        $get_num_name = mysqli_num_rows($get_name_qry);
                                        $get_name_fetch = mysqli_fetch_array($get_name_qry);
                                        
                                        if ($get_num_name >= 1) {
                                            $fullname = $get_name_fetch['users_name'];
                                        } else {
                                            if ($reseller == 'UPTIMAIN') {
                                                $fullname = 'Uptimised Corporation';
                                            } else {
                                                $get_name1 = "SELECT * FROM upti_users WHERE users_code = '$reseller' AND users_role = 'UPTIRESELLER'";
                                                $get_name_qry1 = mysqli_query($connect, $get_name1);
                                                $get_name_fetch1 = mysqli_fetch_array($get_name_qry1);
                                                
                                                $fullname = $get_name_fetch1['users_name'];
                                            }
                                            // $fullname = $reseller;
                                        }

                                        $territory_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$state' AND state_country = '$country'");
                                        $territory_fetch = mysqli_fetch_array($territory_sql);

                                        if (mysqli_num_rows($territory_sql) > 0) {
                                          $territory = $territory_fetch['state_territory'];
                                        } else {
                                          $territory = 'TERRITORY 1';
                                        }

                                        if ($s_role == $territory) {
                                ?>
                                <tr>
                                  <td class="text-center"><?php echo $number ?></td>
                                  <td class="text-center"><a class="btn-sm rounded-0 btn btn-dark" href="poid-list.php?id=<?php echo $order['id']; ?>" target="_blank"><?php echo $order['trans_poid']; ?></a></td>
                                  <td class="text-center">
                                      <?php echo $fullname; ?>
                                  </td>
                                  <td class="text-center"><?php echo $order['trans_country']; ?></td>
                                  <td class="text-center"><?php echo $order['trans_fname']; ?></td>
                                  <td class="text-center"><?php echo $order['trans_date']; ?></td>
                                  <td class="text-center"><?php echo $order['trans_mop']; ?></td>
                                  <td class="text-center"><button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#image<?php echo $order['id']; ?>"><i class="fas fa-image"></i></button></td>
                                  <td class="text-right"><?php echo number_format($total) ?></td>
                                  <td class="text-center">
                                      <span class="badge badge-primary"><?php echo $status ?></span>
                                  </td>
                                  <td class="text-center"><a href="generate-poid.php?poidgenerate=<?php echo $poid ?>" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                                </tr>
                                <?php
                                  include 'backend/admin-order-image-modal.php';
                                  $number++;
                                      }
                                  }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  </div>
<?php } else { echo "<script>window.location='index.php'</script>"; } ?>
<?php include 'include/footer.php'; ?>