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
                        <span class="float-left text-primary"><b>States</b></span>
                        <button type="button" class="btn btn-primary btn-sm rounded-0 float-right" data-toggle="modal" data-target="#add">
                          Add State
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
                                  <th class="text-center">State</th>
                                  <th class="text-center">Country</th>
                                  <th class="text-center">Assigned</th>
                                  <th class="text-center">Action</th>
                                </tr>
                              </thead>
                              <?php
                                $state_sql = "SELECT * FROM upti_state ORDER BY id DESC";
                                $state_qry = mysqli_query($connect, $state_sql);
                                $number = 1;
                                while ($state = mysqli_fetch_array($state_qry)) {
                              ?>
                              <tr>
                                <td class="text-center"><?php echo $number; ?></td>
                                <td class="text-center"><?php echo $state['state_name'] ?></td>
                                <td class="text-center"><?php echo $state['state_country'] ?></td>
                                <td class="text-center"><?php echo $state['state_territory'] ?></td>
                                <td class="text-center">
                                  <button class="btn btn-warning btn-sm rounded-0" data-toggle="modal" data-target="#edit<?php echo $state['id']; ?>">Update</button>
                                  <button class="btn btn-danger btn-sm rounded-0" data-toggle="modal" data-target="#delete<?php echo $state['id']; ?>">Delete</button>
                                </td>
                              </tr>
                              <?php
                                include 'backend/state/state-edit.php';
                                include 'backend/state/state-delete.php';
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
    <?php include 'backend/state/state-process.php' ?>
  </div>
<?php include '../include/footer.php'; ?>
<?php } else { echo "<script>window.location='../../login.php'</script>"; } ?>