<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0">Account List</h1> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Item</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
    $mycode = $_SESSION['code'];       

    if (isset($_POST['country'])) {
        $newDate1 = $_POST['date1'];
        $date1 = date("m-d-Y", strtotime($newDate1));
        $newDate2 = $_POST['date2'];
        $date2 = date("m-d-Y", strtotime($newDate2));
        $country = $_POST['bansa'];
        $status = $_POST['status'];

        if (!empty($country) AND $status == 'Delivered') {
            $order_sql = "SELECT * FROM upti_transaction INNER JOIN upti_activities ON upti_transaction.trans_poid = upti_activities.activities_poid WHERE upti_activities.activities_caption = 'Order Delivered' AND upti_transaction.trans_country = '$country' AND upti_activities.activities_date BETWEEN '$date1' AND '$date2' ORDER BY upti_activities.activities_date DESC";
            $order_qry = mysqli_query($connect, $order_sql);

            $total = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_activities.activities_caption = 'Order Delivered' AND upti_order_list.ol_country = '$country' AND upti_activities.activities_date BETWEEN '$date1' AND '$date2'";
            $total_sql = mysqli_query($connect, $total);
            $total_fetch = mysqli_fetch_array($total_sql);
        } elseif (empty($country) AND $status == 'Delivered') {
            $order_sql = "SELECT * FROM upti_transaction WHERE trans_status= '[uptimised]'";
            $order_qry = mysqli_query($connect, $order_sql);
    
            $sum = 0;

            $total = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '$date1' AND '$date2'";
            $total_sql = mysqli_query($connect, $total);
            $total_fetch = mysqli_fetch_array($total_sql);
        } elseif (!empty($country) AND $status != 'Delivered') {
            $order_sql = "SELECT * FROM upti_transaction WHERE trans_country = '$country' AND trans_status = '$status' AND trans_date BETWEEN '$date1' AND '$date2' ORDER BY trans_date DESC";
            $order_qry = mysqli_query($connect, $order_sql);

            $total = "SELECT SUM(ol_php) AS total FROM upti_order_list INNER JOIN upti_transaction ON trans_poid = ol_poid WHERE trans_status = '$status' AND ol_country = '$country' AND ol_date BETWEEN '$date1' AND '$date2'";
            $total_sql = mysqli_query($connect, $total);
            $total_fetch = mysqli_fetch_array($total_sql);
        } elseif (empty($country) AND $status != 'Delivered') {
            $order_sql = "SELECT * FROM upti_transaction WHERE trans_status = '$status' AND trans_status = '$status' AND trans_date BETWEEN '$date1' AND '$date2' ORDER BY trans_date DESC";
            $order_qry = mysqli_query($connect, $order_sql);

            $total = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_transaction ON upti_order_list.ol_poid = upti_transaction.trans_poid WHERE upti_transaction.trans_status = '$status' AND upti_transaction.trans_date BETWEEN '$date1' AND '$date2'";
            $total_sql = mysqli_query($connect, $total);
            $total_fetch = mysqli_fetch_array($total_sql);
        } elseif (empty($country) AND empty($status)) {
            $order_sql = "SELECT * FROM upti_transaction WHERE trans_date BETWEEN '$date1' AND '$date2' ORDER BY trans_date DESC";
            $order_qry = mysqli_query($connect, $order_sql);

            $total = "SELECT SUM(ol_php) AS total FROM upti_order_list WHERE ol_date BETWEEN '$date1' AND '$date2'";
            $total_sql = mysqli_query($connect, $total);
            $total_fetch = mysqli_fetch_array($total_sql);
        } elseif (!empty($country) AND !empty($status)) {
            $order_sql = "SELECT * FROM upti_transaction WHERE trans_status = '$status' AND  trans_country = '$country' AND trans_date BETWEEN '$date1' AND '$date2' ORDER BY trans_date DESC";
            $order_qry = mysqli_query($connect, $order_sql);

            $total = "SELECT SUM(ol_php) AS total FROM upti_order_list WHERE ol_country = '$country' AND ol_status = '$status' AND ol_date BETWEEN '$date1' AND '$date2'";
            $total_sql = mysqli_query($connect, $total);
            $total_fetch = mysqli_fetch_array($total_sql);
        }

        $sum = $total_fetch['total'];

    } else {
        $order_sql = "SELECT * FROM upti_transaction WHERE trans_status= '[uptimised]'";
        $order_qry = mysqli_query($connect, $order_sql);

        $sum = 0;
    }
    ?>
    <!-- START HERE -->
    <section class="content">
        <div class="container-fluid">
            <!-- Generate Sales -->
            <div class="card p-3">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form action="" method="post">
                            <div class="row">
                                <!-- 1st row -->
                                <div class="col-12">
                                    <div class="small-box bg-info pt-2">
                                        <div class="inner">
                                            <h3><?php echo number_format($sum) ?></h3>

                                            <p>Total Sales</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- 1st Row -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Date From</label>
                                        <input type="date" name="date1" class="form-control" min="1997-01-01" max="2300-12-31">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Date To</label>
                                        <input type="date" name="date2" class="form-control" min="1997-01-01" max="2300-12-31">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="bansa">
                                            <option value="">All Country</option>
                                            <?php
                                            $product_sql = "SELECT * FROM upti_country_currency";
                                            $product_qry = mysqli_query($connect, $product_sql);
                                            while ($product = mysqli_fetch_array($product_qry)) {
                                            ?>
                                            <option value="<?php echo $product['cc_country'] ?>"><?php echo $product['cc_country'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Order Status</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="status">
                                            <option value="">All Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="In Transit">In Transit</option>
                                            <option value="On Process">On Process</option>
                                            <option value="RTS">RTS</option>
                                            <option value="Canceled">Canceled</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><i class="fas fa-excel"></i></label><br>
                                        <button class="btn btn-success form-control" name="country">Generate</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form action="../backend/sales-report.php" method="post">
                            <div class="row">
                                <!-- First Row -->
                                <div class="col-12">
                                    <!-- <img src="images/icon/excel.png" alt="" class="image-fluid"> -->
                                    <h1 class="text-center pt-4 pb-3">Export Total Sales</h1>
                                    <br><br>
                                </div>

                                <!-- Second Row -->
                                <!-- 1st Row -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Date From</label>
                                        <input type="date" name="date1" class="form-control" min="1997-01-01" max="2300-12-31">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Date To</label>
                                        <input type="date" name="date2" class="form-control" min="1997-01-01" max="2300-12-31">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Order Status</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="status">
                                            <option value="Delivered">Delivered</option>
                                            <option value="handover">Non Delivered</option>
                                            <option value="RTS">RTS & Canceled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><i class="fas fa-excel"></i></label><br>
                                        <button class="btn btn-dark form-control" name="export">Export</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
        </div>
        </section>
  </div>