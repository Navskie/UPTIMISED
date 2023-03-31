<?php include 'include/header.php' ?>
<?php include 'include/navbar.php' ?>
<?php include 'include/topbar.php' ?>

<div class="page-wrapper">
<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4>Homepage</h4>
        <span>Admin Dashboard</span>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">Hidden Haven Resort
            </li>
            <li class="breadcrumb-item">Hidden Products
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->
<!-- Page-body start -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Language - Comma Decimal Place table start -->
            <div class="card">
                <div class="card-block">
                  <button type="button" class="btn btn-sm btn-primary waves-effect md-trigger" data-modal="details-1">Add Villa Style</button>
                  <br><br>
                    <div class="dt-responsive table-responsive">
                        <table id="lang-dt" class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Title</th>
                                  <!-- <th class="text-center">Description</th> -->
                                  <th colspan="2" class="text-center">8 Hours (weekday/weekend)</th>
                                  <th colspan="2" class="text-center">22 Hours (weekday/weekend)</th>
                                  <th class="text-center">Code</th>
                                  <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                                $booking_qry = "SELECT * FROM haven_product WHERE product_status != 'Trash' ORDER BY id DESC";
                                $booking = mysqli_query($connect, $booking_qry);
                                $number = 1;
                                foreach ($booking as $data) {
                              ?>
                                <tr>
                                    <td class="text-center"><?php echo $number ?></td>
                                    <td class="text-center"><?php echo $data['product_title'] ?></td>
                                    <td class="text-center"><?php echo $data['weekday_eight'] ?></td>
                                    <td class="text-center"><?php echo $data['weekend_eight'] ?></td>
                                    <td class="text-center"><?php echo $data['weekday_two'] ?></td>
                                    <td class="text-center"><?php echo $data['weekend_two'] ?></td>
                                    <td class="text-center"><?php echo $data['product_code'] ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning waves-effect md-trigger" data-modal="edit-1<?php echo $data['product_code'] ?>">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger waves-effect md-trigger" data-modal="trash-1<?php echo $data['product_code'] ?>">Trash</button>
                                    </td>
                                </tr>
                              <?php
                                  include 'backend/details-edit-modal.php';
                                  include 'backend/details-delete-modal.php';
                                  $number++;
                                }
                              ?>
                            </tbody>
                        </table>
                    </div>
                </div>                  
            </div>
            <!-- Language - Comma Decimal Place table end -->
        </div>
    </div>
</div>
<?php include 'backend/details-add-modal.php'; ?>
<!-- Page-body end -->
<?php include 'include/footer.php' ?>