<?php include '../include/header.php'; ?>
<?php if ($_SESSION['role'] == 'MARKETING') { ?>
<?php include '../include/preloader.php'; ?>
<?php include '../include/navbar.php'; ?>
<?php include '../include/sidebar.php'; ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <!-- START HERE -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#add">
                  Announcement
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <?php 
                    $code_sql = "SELECT * FROM upti_announce";
                    $code_qry = mysqli_query($connect, $code_sql);
                    while ($code = mysqli_fetch_array($code_qry)) {
                        $stst = $code['announce_status'];
                  ?>
                  <tr>
                    <td class="text-center"><img src="../images/slide/<?php echo $code['announce_img'] ?>" class="img-responsive" width="100%"></td>
                    <th class="text-center">
                        <?php if ($stst == 'Active') { ?>
                        <span class="badge badge-success"><?php echo $code['announce_status'] ?></span>
                        <?php } else { ?>
                        <span class="badge badge-danger"><?php echo $code['announce_status'] ?></span>
                        <?php } ?>
                    </th>
                    <td width="100px">
                      <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?php echo $code['id']; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $code['id']; ?>"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                  <?php
                    include 'backend/slide/slide-edit.php';
                    include 'backend/slide/slide-delete.php';
                    }
                  ?>
                </table>
              </div>
            </div>
            <?php include 'backend/slide/slide-process.php'; ?>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php include '../include/footer.php'; ?>
<?php } else { echo "<script>window.location='../../login.php'</script>"; } ?>