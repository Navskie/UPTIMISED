<?php include 'include/header.php'; ?>

<?php
    $SCode = $_SESSION['code'];
    $osrID = $_SESSION['code'];
    
    $check_stockist = "SELECT * FROM stockist WHERE stockist_code = '$SCode'";
    $check_stockist_qry = mysqli_query($connect, $check_stockist);
    $check_stockist_num = mysqli_num_rows($check_stockist_qry);
    
    if ($check_stockist_num > 0) {
      header('location: stockist.php');
  } else {  ?>
<?php include 'include/preloader.php'; ?>
<?php include 'include/navbar.php'; ?>
<?php include 'include/sidebar.php'; ?>
<!-- Pop Up Image -->
<?php } ?>
<style>
  .popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    z-index : 50;
  }
  .contentBox {
    background: #fff;
    border-radius: 20px;
    padding: 20px;
    
  } 
  .contentBox > img {
    position: relative;
    width: 500px;
    height: 500px;
    background-color: #fff;
    display:flex;
  }
  .close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    cursor: pointer;
    /* border-radius: 50%; */
    z-index: 100;
  }
  .close > img {
    background-color: #fff;
  } 

  @media (max-width: 768px) {
    .contentBox > img {
      width: 350px;
      height: 350px;
    }
    .contentBox {
    background: #fff;
    border-radius: 10px;
    padding: 10px;
    
  }
  }
</style>

<?php
  date_default_timezone_set('Asia/Manila');
  $month = date('m');
  $monthName = date("F", mktime(0, 0, 0, $month, 10));
  $year = date('Y');
  $day = date('d');
  $date1 = $month.'-01-'.$year;
  $date2 = date('m-d-Y'); 
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      
    <?php 
      $myid = $_SESSION['code'];
      
      $check_position = "SELECT * FROM upti_users WHERE users_code = '$myid'";
      $check_position_qry = mysqli_query($connect, $check_position);
      $check_fetch = mysqli_fetch_array($check_position_qry);

      $emp_position = $check_fetch['users_position'];

    ?>
        <!-- START HERE -->
    <div class="container-fluid">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <?php
          //$date2 = date('m-d-Y');
            $slide_sql = "SELECT * FROM upti_announce WHERE announce_status = 'Active'";
            $slide_qry = mysqli_query($connect, $slide_sql);
            $number = 1;
            while ($row = mysqli_fetch_array($slide_qry)) {
          ?>
              <?php
                  if($number == 1) {
              ?>
                  <div class="carousel-item active">
                      <img src="images/slide/<?php echo $row['announce_img']; ?>" alt="..." class="img-fluid">
                      <div class="carousel-caption d-none d-md-block">
                          <h5></h5>
                          <p><?php echo $number; ?></p>
                      </div>
                  </div>
              <?php
                  } else {
              ?>
                  <div class="carousel-item">
                      <img src="images/slide/<?php echo $row['announce_img']; ?>" alt="..." class="img-fluid">
                      <div class="carousel-caption d-none d-md-block">
                          <h5></h5>
                          <p><?php echo $number; ?></p>
                      </div>
                  </div>
              <?php
                  }
              ?>
          <?php $number++; } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    <br>
    <h5 class="mb-2"><br></h5>
    <?php
      $qry_test = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$SCode'");

      $qry_test_fetch = mysqli_fetch_array($qry_test);
      $positions = $qry_test_fetch['users_position'];
      if ($positions == '') {

      $january = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' OR upti_order_list.ol_reseller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '01-01-2023' AND '01-31-2023'";
      $january_01 = mysqli_query($connect, $january);
      $january_2023 = mysqli_fetch_array($january_01);

      $february = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' OR upti_order_list.ol_reseller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '02-01-2023' AND '02-28-2023'";
      $february_01 = mysqli_query($connect, $february);
      $february_2023 = mysqli_fetch_array($february_01);

      $march = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '03-01-2023' AND '03-31-2023'";
      $march_01 = mysqli_query($connect, $march);
      $march_2023 = mysqli_fetch_array($march_01);

      $april = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '04-01-2023' AND '04-30-2023'";
      $april_01 = mysqli_query($connect, $april);
      $april_2023 = mysqli_fetch_array($april_01);

      $may = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '05-01-2023' AND '05-31-2023'";
      $may_01 = mysqli_query($connect, $may);
      $may_2023 = mysqli_fetch_array($may_01);

      $june = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '06-01-2023' AND '06-30-2023'";
      $june_01 = mysqli_query($connect, $june);
      $june_2023 = mysqli_fetch_array($june_01);

      $july = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '07-01-2023' AND '07-31-2023'";
      $july_01 = mysqli_query($connect, $july);
      $july_2023 = mysqli_fetch_array($july_01);

      $august = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '08-01-2023' AND '08-31-2023'";
      $august_01 = mysqli_query($connect, $august);
      $august_2023 = mysqli_fetch_array($august_01);

      $september = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '09-01-2023' AND '09-30-2023'";
      $september_01 = mysqli_query($connect, $september);
      $september_2023 = mysqli_fetch_array($september_01);

      $october = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_seller = '$osrID' AND upti_activities.activities_caption = 'Order Delivered' AND upti_activities.activities_date BETWEEN '10-01-2023' AND '10-31-2023'";
      $october_01 = mysqli_query($connect, $october);
      $october_2023 = mysqli_fetch_array($october_01);

      // echo $total_fetch_points_sql_2['total'];
      // echo '<br>';
      // echo $total_fetch_points_sql_0['total'];
      $reward_sales = $january_2023['total'] + $february_2023['total'];
                      // $march_2023['total'] +
                      // $april_2023['total'] +
                      // $may_2023['total'] +
                      // $june_2023['total'] +
                      // $july_2023['total'] +
                      // $august_2023['total'] +
                      // $september_2023['total'] +
                      // $october_2023['total'];
      // echo $january_2023['total']; 
      // echo '<br>';
      // echo $february_2023['total']; 
      // echo '<br>';
      // echo $march_2023['total'];
      // echo '<br>';
      // echo $april_2023['total'];
      // echo '<br>';
      // echo $may_2023['total'];
      // echo '<br>';
      // echo $june_2023['total'];
      // echo '<br>';
      // echo $july_2023['total'];
      // echo '<br>';
      // echo $august_2023['total'];
      // echo '<br>';
      // echo $september_2023['total'];
      // echo '<br>';
      // echo $october_2023['total'];
      } else {
        $reward_sales = 0;
      }
    ?>
    <div class="row">

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="course">
        <div class="preview bg-primary">
          <h2 class="text-center text-light"><i class="uil uil-user-exclamation"></i></h2>
        </div>

        <div class="info">
          <h6>My Replicated Website</h6>
          <h2><b><?php echo $_SESSION['code'] ?></b></h2>
          <div class="copy-text">
            <input type="text" id="myInput" value="https://upticorporationph.com/replicate.php?id=<?php echo $_SESSION['code'] ?>" style="display: none">
            <button class="btn btn-success" onclick="myFunction()"><i class="uil uil-copy"></i> Get Link</button>
            <br><br>
          </div>
        </div>
      </div>
      <br>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="course">
        <div class="preview" style="background: #2771D0;">
          <h2 class="text-center text-light"><i class="uil uil-plane-departure"></i></h2>
        </div>

        <div class="info">
          <h6>Korea Travel Incentive</h6>
          <h2><b><?php echo number_format($reward_sales) ?> / 2,000,000</b></h2>
          <p class="text-danger pt-2">January 1, 2023 - October 31, 2023</p>
        </div>
      </div>
      <br>
    </div>

    </div>
    <div class="row">
      <?php
        $total_points = "SELECT reseller_points FROM upti_reseller WHERE reseller_code = '$myid'";
        $total_sql_points = mysqli_query($connect, $total_points);
        $total_fetch_points = mysqli_fetch_array($total_sql_points);
      ?>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-info">
            <h2 class="text-center"><i class="uil uil-coins"></i></h2>
          </div>

          <div class="info">
            <h6>Reseller Points</h6>
            <h2><b><?php echo $total_fetch_points['reseller_points'] ?></b></h2>
            <!-- <a href="branch-rts-order.php" class="text-info">MORE INFO </a> -->
          </div>
        </div>
        <br>
      </div>
      <?php
        

        
      if ($positions == '') { 
        $total_points_sql = "SELECT SUM(upti_order_list.ol_php) AS total FROM upti_order_list INNER JOIN upti_activities ON upti_order_list.ol_poid = upti_activities.activities_poid WHERE upti_order_list.ol_reseller = '$myid' AND upti_activities.activities_caption = 'Order Delivered'";
        $total_sql_points_sql = mysqli_query($connect, $total_points_sql);
        $total_fetch_points_sql = mysqli_fetch_array($total_sql_points_sql);
      ?>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-success">
            <h2 class="text-center"><i class="uil uil-dollar-sign-alt"></i></h2>
          </div>

          <div class="info">
            <h6>total sales</h6>
            <h2><b>₱ <?php echo $tote = $total_fetch_points_sql['total'] ?></b></h2>
            <!-- <a href="branch-rts-order.php" class="text-info">MORE INFO </a> -->
          </div>
        </div>
        <br>
      </div>
      <?php } ?>
    </div>
    <hr><br>
    <div class="row">
      <?php
        if ($emp_position != '') {
          $total = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid'";
          $total_sql = mysqli_query($connect, $total);
          $total_fetch = mysqli_fetch_array($total_sql);
        } else {
          $total = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' OR trans_my_reseller = '$myid'";
          $total_sql = mysqli_query($connect, $total);
          $total_fetch = mysqli_fetch_array($total_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-warning">
            <h2 class="text-center"><i class="uil uil-shopping-cart-alt"></i></h2>
          </div>

          <div class="info">
            <h6>TOTAL ORDERS</h6>
            <h2><b><?php echo $total_fetch['total'] ?></b></h2>
            <a href="my-order.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

      <?php
        if ($emp_position != '') {
          $pending = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid' AND trans_status = 'Pending'";
          $pending_sql = mysqli_query($connect, $pending);
          $pending_fetch = mysqli_fetch_array($pending_sql);
        } else {
          $pending = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' AND trans_status = 'Pending'";
          $pending_sql = mysqli_query($connect, $pending);
          $pending_fetch = mysqli_fetch_array($pending_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-secondary">
            <h2 class="text-center"><i class="uil uil-clock-five"></i></h2>
          </div>

          <div class="info">
            <h6>PENDING ORDERS</h6>
            <h2><b><?php echo $pending_fetch['total'] ?></b></h2>
            <a href="order-pending.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

      <?php
        if ($emp_position != '') {
          $process = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid' AND trans_status = 'On Process'";
          $process_sql = mysqli_query($connect, $process);
          $process_fetch = mysqli_fetch_array($process_sql);
        } else {
          $process = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' AND trans_status = 'On Process'";
          $process_sql = mysqli_query($connect, $process);
          $process_fetch = mysqli_fetch_array($process_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-info">
            <h2 class="text-center"><i class="uil uil-process"></i></h2>
          </div>

          <div class="info">
            <h6>ON PROCESS ORDERS</h6>
            <h2><b><?php echo $process_fetch['total'] ?></b></h2>
            <a href="order-on-process.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

      <?php
        if ($emp_position != '') {
          $transit = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid' AND trans_status = 'In Transit'";
          $transit_sql = mysqli_query($connect, $transit);
          $transit_fetch = mysqli_fetch_array($transit_sql);
        } else {
          $transit = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' AND trans_status = 'In Transit'";
          $transit_sql = mysqli_query($connect, $transit);
          $transit_fetch = mysqli_fetch_array($transit_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-primary">
            <h2 class="text-center"><i class="uil uil-truck"></i></h2>
          </div>

          <div class="info">
            <h6>IN TRANSIT ORDERS</h6>
            <h2><b><?php echo $transit_fetch['total'] ?></b></h2>
            <a href="order-on-transit.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

      <?php
        if ($emp_position != '') {
          $delivered = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid' AND trans_status = 'Delivered'";
          $delivered_sql = mysqli_query($connect, $delivered);
          $delivered_fetch = mysqli_fetch_array($delivered_sql);
        } else {
          $delivered = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' AND trans_status = 'Delivered'";
          $delivered_sql = mysqli_query($connect, $delivered);
          $delivered_fetch = mysqli_fetch_array($delivered_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-success">
            <h2 class="text-center"><i class="uil uil-check-circle"></i></h2>
          </div>

          <div class="info">
            <h6>DELIVERED ORDERS</h6>
            <h2><b><?php echo $delivered_fetch['total'] ?></b></h2>
            <a href="order-delivered.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

      <?php
        if ($emp_position != '') {
          $canceled = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid' AND trans_status = 'Canceled'";
          $canceled_sql = mysqli_query($connect, $canceled);
          $canceled_fetch = mysqli_fetch_array($canceled_sql);
        } else {
          $canceled = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' AND trans_status = 'Canceled'";
          $canceled_sql = mysqli_query($connect, $canceled);
          $canceled_fetch = mysqli_fetch_array($canceled_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-danger">
            <h2 class="text-center"><i class="uil uil-times-circle"></i></h2>
          </div>

          <div class="info">
            <h6>CANCELED ORDERS</h6>
            <h2><b><?php echo $canceled_fetch['total'] ?></b></h2>
            <a href="order-cancel.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

      <?php
        if ($emp_position != '') {
          $rts = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_my_reseller = '$myid' AND trans_status = 'RTS'";
          $rts_sql = mysqli_query($connect, $rts);
          $rts_fetch = mysqli_fetch_array($rts_sql);
        } else {
          $rts = "SELECT COUNT(trans_poid) AS total FROM upti_transaction WHERE trans_seller = '$myid' AND trans_status = 'RTS'";
          $rts_sql = mysqli_query($connect, $rts);
          $rts_fetch = mysqli_fetch_array($rts_sql);
        }
      ?>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="course">
          <div class="preview bg-danger">
            <h2 class="text-center"><i class="uil uil-corner-up-left-alt"></i></h2>
          </div>

          <div class="info">
            <h6>RTS ORDERS</h6>
            <h2><b><?php echo $rts_fetch['total'] ?></b></h2>
            <a href="order-rts.php" class="text-info">MORE INFO </a>
          </div>
        </div>
        <br>
      </div>

    </div>
    <!-- /.row -->
    </div>
        
    </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
      
  </div>
      <!-- <div class="popup">
        <div class="contentBox">
          <div class="clos"><img src="images/close.png" class="close"/></div>
          <img src="images/manual/announces.jpg" class="img-responsive" alt="">
        </div>
      </div> -->
<script type="text/javascript">
  const popup = document.querySelector('.popup');
  const close = document.querySelector('.close');

  window.onload = function() {
    setTimeout(function() {
      popup.style.display = 'block';
    }, 1000)
  }

  close.addEventListener('click', () => popup.style.display = 'none');
</script>
<?php include 'include/footer.php'; ?>
<script>
function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  
}
</script>