<?php include 'include/header.php'; ?>
<?php include 'include/preloader.php'; ?>
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
                        <?php                          
                          if (isset($_POST['testing'])) {
                            $country = $_POST['country'];
                            $state = $_POST['state'];

                            if ($country != 'USA' || $country == '') {
                              $state = 'TERRITORY 1';
                            } else {
                              $state = $_POST['state'];
                            }

                            $code_sql = "SELECT * FROM stockist_inventory WHERE si_item_country = '$country' AND si_item_role = '$state' ORDER BY si_item_code ASC";
                            $code_qry = mysqli_query($connect, $code_sql);
                            $number = 1;
                          } else {
                            $country = '';

                            $code_sql = "SELECT * FROM stockist_inventory WHERE si_item_country = 'HAHA' AND si_item_role = 'HAHA' ORDER BY si_item_code ASC";
                            $code_qry = mysqli_query($connect, $code_sql);
                            $number = 1;
                          }
                        ?>
                        <div class="col-6">
                          <span class="float-left text-primary"><b><?php echo $country ?> INVENTORY</b></span>
                        </div>
                        
                        <div class="col-2">
                          <form action="" method="post">
                            <select class="form-control select2bs4" style="width: 100%;" name="country">
                              <option  value="">Select Country</option>
                              <?php
                                $lugar = "SELECT * FROM upti_country_currency";
                                $lugar_qry = mysqli_query($connect, $lugar);
                                while ($lugar_fetch = mysqli_fetch_array($lugar_qry)) {
                              ?>
                              <option value="<?php echo $lugar_fetch['cc_country'] ?>"><?php echo $lugar_fetch['cc_country'] ?></option>
                              <?php } ?>
                            </select>
                        </div>
                        <div class="col-2">
                          <select class="form-control select2bs4" style="width: 100%;" name="state">
                            <option  value="">Select state</option>
                            <?php
                              $lugar = "SELECT * FROM upti_state";
                              $lugar_qry = mysqli_query($connect, $lugar);
                              while ($lugar_fetch = mysqli_fetch_array($lugar_qry)) {
                            ?>
                            <option value="<?php echo $lugar_fetch['state_territory'] ?>"><?php echo $lugar_fetch['state_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-sm btn-info float-right rounded-0 form-control" name="testing">GENERATE</button>
                          </form>
                        </div>
                        
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                            <!-- Order List Table Start -->
                            <table id="example22" class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th class="text-center">#</th>
                                    <th colspan="2" class="text-center">Item Description</th>
                                    <th colspan="2" class="text-center">Stocks</th>
                                  </tr>
                                </thead>
                                <?php
                                  while ($code = mysqli_fetch_array($code_qry)) {
                                    $crtitical = $code['si_item_code'];
                                    if ($crtitical != '') {
                                ?>
                                <tr>
                                  <td class="text-center" width="20"><?php echo $number; ?></td>
                                  <td class="text-center" width="20"><b><?php echo $code['si_item_code'] ?></b></td>
                                  <td class="text-center"><?php echo $code['si_item_desc'] ?></td> 
                                  <td class="text-center"><?php echo $code['si_item_stock'] ?></td>
                                </tr>
                                <?php
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
<?php include 'include/footer.php'; ?>