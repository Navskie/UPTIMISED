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
                        <span class="float-left text-primary"><b>Territories</b></span>
                        <button type="button" class="btn btn-primary btn-sm rounded-0 float-right" data-toggle="modal" data-target="#add">
                          Add Territory
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
                                  <th class="text-center">Territory</th>
                                  <th class="text-center">Action</th>
                                </tr>
                              </thead>
                              <?php
                                $country_sql = "SELECT * FROM upti_territory ORDER BY id DESC";
                                $country_qry = mysqli_query($connect, $country_sql);
                                $number = 1;
                                while ($country = mysqli_fetch_array($country_qry)) {
                              ?>
                              <tr>
                                <td class="text-center"><?php echo $number; ?></td>
                                <td class="text-center"><?php echo $country['territory_name'] ?></td>
                                <td class="text-center">
                                  <button class="btn btn-warning btn-sm rounded-0" data-toggle="modal" data-target="#edit<?php echo $country['id']; ?>">Update</button>
                                  <button class="btn btn-danger btn-sm rounded-0" data-toggle="modal" data-target="#delete<?php echo $country['id']; ?>">Delete</button>
                                </td>
                              </tr>
                              <?php
                                include 'backend/territory/territory-edit.php';
                                include 'backend/territory/territory-delete.php';
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
    <?php include 'backend/territory/territory-process.php' ?>
  </div>
<?php include '../include/footer.php'; ?>
<?php } else { echo "<script>window.location='../../login.php'</script>"; } ?>