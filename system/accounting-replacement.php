<?php include 'include/header.php'; ?>
<?php if ($_SESSION['role'] == 'UPTIACCOUNTING') { ?>
<?php //include 'include/preloader.php'; ?>
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
                        <span class="float-left text-primary"><b>Replacement Purchase Orders</b></span> 
                        </div>
                        
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                             <!-- Order List Table Start -->
                            <table id="example1" class="table table-sm table-striped table-hover border border-info">
                                <thead>
                                    <tr>
                                        <th class="text-center">Reference Number</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Time</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                    $account = "SELECT * FROM stockist_replacement ORDER BY id DESC";
                                    $account_qry = mysqli_query($connect, $account);
                                    $number = 1;
                                    while ($account_fetch = mysqli_fetch_array($account_qry)) {
                                ?>
                                  <tr>
                                    <td class="text-center"><?php echo $account_fetch['ref_id']; ?></td>       
                                    <td class="text-center"><?php echo $account_fetch['rep_date']; ?></td>       
                                    <td class="text-center"><?php echo $account_fetch['rep_time']; ?></td>       
                                    <td class="text-center"><?php echo $account_fetch['rep_remarks']; ?></td>  
                                    <td class="text-center"><div class="badge badge-danger"><?php echo $account_fetch['ref_status']; ?></div></td>      
                                    <td class="text-center">
                                        <?php if ($account_fetch['ref_status'] == 'Replaced') { ?>
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rts<?php echo $account_fetch['ref_id'] ?>">RTS</button>
                                        <?php } elseif ($account_fetch['ref_status'] == 'On going') { ?>
                                            <button type="submit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#replace<?php echo $account_fetch['ref_id'] ?>">Replace</button>
                                        <?php } else { ?>
                                            <div class="badge badge-success">Done</div>
                                        <?php } ?>
                                    </td>                                    
                                  </tr>
                                <?php
                                    include 'backend/po-replacement-modal.php';
                                    include 'backend/po-rts-modal.php';
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

<?php include 'include/footer.php'; ?>
<script type="text/javascript">
    <?php if (isset($_SESSION['success'])) { ?>

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-center-right",
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

    toastr.success("<?php echo flash('success'); ?>");

    <?php } ?>
</script>
<?php } else { echo "<script>window.location='index.php'</script>"; } ?>