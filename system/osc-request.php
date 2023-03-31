<?php include 'include/header.php'; ?>
<?php include 'include/preloader.php'; ?>
<?php include 'include/stockist-navbar.php'; ?>
<?php include 'include/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: #f8f8f8 !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-body login-card-body text-dark">
                    <div class="row">
                        <div class="col-12">
                        <span class="float-left text-primary"><b>E-Wallet Request</b></span>
                        </div>
                        
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                             <!-- Order List Table Start -->
                            <table id="example1" class="table table-sm table-striped table-hover border border-info">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Bank</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Number</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                    $account = "SELECT * FROM upti_osr_withdraw WHERE withdraw_status = 'Pending' ORDER BY id DESC";
                                    $account_qry = mysqli_query($connect, $account);
                                    $number = 1;
                                    while ($account_fetch = mysqli_fetch_array($account_qry)) {
                                      $acc_name = $account_fetch['withdraw_name'];
                                      $amount = $account_fetch['withdraw_amount'];
                                      $remark = $account_fetch['withdraw_remarks'];
                                      $status = $account_fetch['withdraw_status'];
                                      $get_name = "SELECT * FROM upti_users WHERE users_code = '$acc_name'";
                                      $get_qry = mysqli_query($connect, $get_name);
                                      $get_fetch = mysqli_fetch_array($get_qry);
                                      $name = $get_fetch['users_name'];
                                ?>
                                  <tr>
                                    <td class="text-center"><?php echo $name; ?></td>
                                    <td class="text-center"><?php echo $account_fetch['withdraw_date'] ?></td>
                                    <td class="text-center"><?php echo number_format($amount) ?></td>
                                    <td class="text-center"><?php echo $account_fetch['withdraw_bank']; ?></td>
                                    <td class="text-center"><?php echo $account_fetch['withdraw_acc_name']; ?></td>
                                    <td class="text-center"><?php echo $account_fetch['withdraw_number']; ?></td>
                                    <td class="text-center">
                                        <?php if($status == 'Pending') { ?>
                                        <button class="btn btn-sm btn-success rounded-0" data-toggle="modal" data-target="#check<?php echo $account_fetch['id']; ?>"><i class="fas fa-check"></i> Check</button>
                                        <?php } else { ?>
                                        <span class="badge badge-info"><?php echo $status; ?></span>
                                        <?php } ?>
                                    </td>
                                  </tr>
                                <?php
                                    include 'backend/osr-withdraw-check-modal.php';
                                    // include 'backend/osr-withdraw-reject-modal.php';
                                    $number++;
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
<?php include 'backend/po-stockist-modal.php'; ?>
<?php include 'include/footer.php'; ?>