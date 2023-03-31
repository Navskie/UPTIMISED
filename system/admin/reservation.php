<?php include 'include/header.php' ?>
<?php include 'include/navbar.php' ?>
<?php include 'include/topbar.php' ?>

<div class="page-wrapper">
<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4>Reservation Page</h4>
        <span>Manage Pending & On Process Status</span>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">Hidden Haven Resort
            </li>
            <li class="breadcrumb-item">Reservation Page
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
                    <div class="dt-responsive table-responsive">
                        <table id="lang-dt" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Encoder</th>
                                  <th class="text-center">Book Reference</th>
                                  <th class="text-center">Book Date</th>
                                  <th class="text-center">Reservation Date</th>
                                  <th class="text-center">Amount</th>
                                  <th class="text-center">Status</th>
                                  <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                                $booking_qry = "SELECT * FROM haven_details INNER JOIN haven_booking ON details_ref = booking_ref WHERE booking_status != 'Success' AND booking_status != 'Canceled' ORDER BY booking_date DESC";
                                $booking = mysqli_query($connect, $booking_qry);
                                $number = 1;
                                foreach ($booking as $data) {
                                  $codeko = $data['details_code'];

                                  $codename_qry = "SELECT * FROM upti_users WHERE users_code = '$codeko'";
                                  $codename = mysqli_query($connect, $codename_qry);
                                  $codename_fetch = mysqli_fetch_array($codename);
                                  if (mysqli_num_rows($codename) > 0) {
                                    $myName = $codename_fetch['users_name'];
                                  } else {
                                    $myName = 'Guest';
                                  }

                              ?>
                                <tr>
                                    <td class="text-center"><?php echo $number ?></td>
                                    <td class="text-center"><?php echo $myName ?></td>
                                  <td class="text-center"><button class="btn  waves-effect btn-success btn-sm md-trigger" data-modal="view-1<?php echo $data['details_ref'] ?>">
                                    <?php echo $data['details_ref'] ?>
                                    </button>
                                  </td>
                                    <td class="text-center"><?php echo $data['booking_date'] ?></td>
                                    <td class="text-center"><?php echo $data['booking_start'] ?> - <?php echo $data['booking_end'] ?></td>
                                    <td class="text-center"><?php echo $data['details_amount'] ?></td>
                                    <td class="text-center"><?php echo $data['booking_status'] ?></td>
                                    <td class="text-center">
                                      <?php
                                        $status = $data['booking_status'];

                                        if ($status == 'Pending') {
                                      ?>
                                        <button type="button" class="btn btn-sm btn-default waves-effect md-trigger" data-modal="modal-1<?php echo $data['details_ref'] ?>">On Process</button>
                                        <button type="button" class="btn-sm btn btn-danger waves-effect md-trigger" data-modal="cancel-1<?php echo $data['details_ref'] ?>">Cancel</button>
                                      <?php
                                        } elseif ($status == 'On Process') {
                                      ?>
                                        <button type="button" class="btn btn-success waves-effect md-trigger" data-modal="success-1<?php echo $data['details_ref'] ?>">Success</button>
                                      <?php
                                        } elseif ($status == 'Success') {
                                      ?>
                                        <span class="badge badge-danger">No Action</span>
                                      <?php
                                        }
                                      ?>
                                    </td>
                                </tr>
                              <?php
                                include 'backend/view-on-modal.php';
                                include 'backend/cancel-on-modal.php';
                                include 'backend/reserve-on-modal.php';
                                include 'backend/success-modal.php';
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
<!-- Page-body end -->
<?php include 'include/footer.php' ?>