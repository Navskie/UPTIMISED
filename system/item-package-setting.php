<?php include 'include/header.php'; ?>
<?php if ($_SESSION['role'] == 'UPTIMAIN' || $_SESSION['role'] == 'UPTIMAINS') { ?>
<?php //include 'include/preloader.php'; ?>
<?php include 'include/navbar.php'; ?>
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
                        <span class="float-left text-primary"><b><?php echo $_GET['id'] ?></b></span>
                        <button type="button" class="btn btn-primary btn-sm rounded-0 float-right" data-toggle="modal" data-target="#add">
                          Add Item
                        </button>
                        </div>
                        
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                             <!-- Order List Table Start -->
                            <table id="example1" class="table table-sm table-striped table-hover border border-info">
                                <thead>
                                  <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Item Code</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Action</th>
                                  </tr>
                                </thead>
                                <?php
                                  $set = $_GET['id'];
                                  $package_sql = "SELECT * FROM upti_pack_sett WHERE p_s_main = '$set'";
                                  $package_qry = mysqli_query($connect, $package_sql);
                                  $number = 1;
                                  while ($package = mysqli_fetch_array($package_qry)) {
                                ?>
                                <tr>
                                  <td class="text-center"><?php echo $number ?></td>
                                  <td class="text-center"><?php echo $package['p_s_code']; ?></td>
                                  <td class="text-center"><?php echo $package['p_s_desc']; ?></td>
                                  <td class="text-center"><?php echo $package['p_s_qty']; ?></td>
                                  <td class="text-center">
                                    <button class="btn btn-danger btn-sm rounded-0" data-toggle="modal" data-target="#delete2<?php echo $package['id']; ?>">Delete</button>
                                  </td>
                                </tr>
                                <?php
                                  // include 'backend/setting-edit-modal.php';
                                  include 'backend/setting-delete-modal.php';
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
    <?php include 'backend/setting-add-modal.php'; ?>
  </div>
  <?php } else { echo "<script>window.location='../login.php'</script>"; } ?>
<?php include 'include/footer.php'; ?>