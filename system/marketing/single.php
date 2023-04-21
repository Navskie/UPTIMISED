<?php include '../include/header.php'; ?>
<?php if ($_SESSION['role'] == 'MARKETING') { ?>
<?php include '../include/preloader.php'; ?>
<?php include '../include/navbar.php'; ?>
<?php include '../include/sidebar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: #f8f8f8 !important">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-body login-card-body text-dark">
                    <div class="row">
                        <div class="col-12">
                        <span class="float-left text-primary"><b>Single Item List</b></span>
                        <button type="button" class="btn btn-primary btn-sm rounded-0 float-right" data-toggle="modal" data-target="#add">
                          Add Single Item
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
                                    <th class="text-center">Points</th>
                                    <th class="text-center">Created</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                  </tr>
                                </thead>
                                <?php
                                  $item_sql = "SELECT * FROM upti_items ORDER BY id DESC";
                                  $item_qry = mysqli_query($connect, $item_sql);
                                  $number = 1;
                                  while ($item = mysqli_fetch_array($item_qry)) {
                                      $stats = $item['items_status'];
                                ?>
                                <tr>
                                  <td class="text-center"><?php echo $number ?></td>
                                  <td class="text-center"><b><?php echo $item['items_code']; ?></b></td>
                                  <td class="text-center"><?php echo $item['items_desc']; ?></td>
                                  <td class="text-center"><?php echo $item['items_points']; ?></td>
                                  <td class="text-center"><?php echo $item['items_created']; ?></td>
                                  <td class="text-center">
                                      <?php
                                          if ($stats == 'Active') {
                                      ?>
                                      <span class="badge badge-success">Active</span>
                                      <?php
                                          } else {
                                      ?>
                                      <span class="badge badge-danger">Deactive</span>
                                      <?php
                                          }
                                      ?>
                                  </td>
                                  <td class="text-center">
                                    <button class="btn btn-warning btn-sm rounded-0" data-toggle="modal" data-target="#edit<?php echo $item['id']; ?>">Update</button>
                                    <button class="btn btn-danger btn-sm rounded-0" data-toggle="modal" data-target="#delete<?php echo $item['id']; ?>">Delete</button>
                                  </td>
                                </tr>
                                <?php
                                  include 'backend/single/single-edit.php';
                                  include 'backend/single/single-delete.php';
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
    <?php include 'backend/single/single-process.php'; ?>
  </div>
<?php include '../include/footer.php'; ?>
<?php } else { echo "<script>window.location='../../login.php'</script>"; } ?>