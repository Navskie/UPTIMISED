<?php include 'include/header.php' ?>
<?php 
  session_start();

  $year = date('Y');
  $month = date('m'); 
  $HHcode = $_GET['HHCode'];

  $product = mysqli_query($connect, "SELECT * FROM haven_product WHERE product_code = '$HHcode'");
  $product_fetch = mysqli_fetch_array($product);

  $myCode = $_SESSION['code'];
  $myID = $_SESSION['uid'];

  $get_ID = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$myCode'");
  $get_ID_fetch = mysqli_fetch_array($get_ID);

  $count = $get_ID_fetch['users_haven'];

  $poid = 'HH'.$year.$month.$myID.$count;

  // $text1 = date_create('19-01-2023');
  // $text2 = date_create('28-02-2023');

  // $sum = date_diff($text1, $text2);

  // $result = $sum->format("%a");

  // echo $_SESSION['diff'];

  if ($_SESSION['guest'] == 'Guest') {
    $poid = $_SESSION['poid'];
  }

  $pax_product = "SELECT * FROM haven_details WHERE details_ref = '$poid'";
  $pakpok = mysqli_query($connect, $pax_product);
  if (mysqli_num_rows($pakpok) <= 0) {
    $pax_total = 0;
    $days_stay = '';
  } else {
    $pax_fetchs = mysqli_fetch_array($pakpok);
    $pax_total = $pax_fetchs['details_pax'];
    $det_time = $pax_fetchs['details_time'];
    $days_stay = $pax_fetchs['details_days'];
    $days_amount = $pax_fetchs['details_amount'];
  }
?>
  <br>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12" style="border-right: 1px solid #333">
      <img class="img-section" src="../system/admin/images/<?php echo $product_fetch['product_img'] ?>" alt="" /> <br><br>
      <h2 class="text-center"><?php echo $product_fetch['product_title'] ?></h2> <br>
      <h1 class="text-center font-weight-bold">
        <div class="row">
          <div class="col-12">
            <div style="border-radius: 10px; border: #f3f3f3 1px solid; padding: 10px 0">
              <h5 class="text-center"></h5>
              <h3 class="text-center">
                <?php echo $pax_fetchs['details_amount'] ?>
              </h3>
            </div>
          </div>
        </div>
      </h1>
      <br>
      <span style="font-size: 18px"><?php echo $product_fetch['product_desc'] ?></span>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12">
      <?php

        if (isset($_POST['validate'])) {
          if ($_SESSION['guest'] == '' && $myCode == '') {
            $random_number = rand(1, 9999);
            $random_number_2 = rand(1, 9999);

            $_SESSION['poid'] = 'HH'.$random_number.'-'.$random_number_2;

            $poid = $_SESSION['poid'];

            $_SESSION['guest'] = 'Guest';

          } 

          $newDate1 = $_POST['date1'];
          $date1 = date("d-m-Y", strtotime($newDate1));
          $date4 = date("Y-m-d", strtotime($newDate1));
          
          $newDate2 = $_POST['date2'];
          $date2 = date("d-m-Y", strtotime($newDate2));

          $text1 = date_create($date1);
          $text2 = date_create($date2);

          $sum = date_diff($text1, $text2);

          $result = $sum->format("%a");

          if ($result == 0) {
            $_SESSION['diff'] = 'day';
          }

          $ok = 0;
          $nessy = 0;

          while ($ok != $result) {
            // echo 'one';
            // echo '<br>';
            if ($ok == 0) {
              // echo $date4;
              // echo '<br>';

              $validation_1 = mysqli_query($connect, "SELECT * FROM haven_date WHERE book_remarks = 'Not Available' AND book_ref = '$HHcode' AND book_date = '$date4'");

              if (mysqli_num_rows($validation_1) > 0) {
                $nessy = $nessy + 1;
              } else {
                // echo 'blee';
                $insert_into = mysqli_query($connect, "INSERT INTO haven_date (book_poid, book_date, book_ref) VALUES ('$poid', '$date4', '$HHcode')");
              }

            }

            $date1 = date('d-m-Y', strtotime($date1 ."+1 days"));
            $get_date = date('Y-m-d', strtotime($date1));

            $validation_2 = mysqli_query($connect, "SELECT * FROM haven_date WHERE book_remarks = 'Not Available' AND book_ref = '$HHcode' AND book_date = '$get_date'");

            if (mysqli_num_rows($validation_2) > 0) {
              $nessy = $nessy + 1;
            } else {
              // echo 'blee';
              $insert_into = mysqli_query($connect, "INSERT INTO haven_date (book_poid, book_date, book_ref) VALUES ('$poid', '$get_date', '$HHcode')");
            }
            // echo '<br>';
            $ok++;
          }

          if($newDate1 === $newDate2) {
            $get_date = $date4;
          }

          if ($result == 0) {
            $insert_into = "INSERT INTO haven_date (book_poid, book_date, book_ref) VALUES ('$poid', '$get_date', '$HHcode')";
            $insert_qry = mysqli_query($connect, $insert_into);
          }

          // echo $nessy;

          if ($nessy > 0) {
            $_SESSION['date1banene'] = '';
            $_SESSION['date2banene'] = '';

            // echo 'ble';
            ?>
            <script>alert('Date from <?php echo $date4. ' to ' .$get_date ?> is not available');window.location.href = 'booking.php?HHCode=<?php echo $HHcode ?>'</script>
            <?php
          } else {
            $_SESSION['date1banene'] = $date4;
            $_SESSION['date2banene'] = $get_date;
          }

          header('booking.php?HHCode='.$HHcode.'');
        }
      ?>
      <?php
        if ($_SESSION['date1banene'] == '' && $_SESSION['date2banene'] == '') {
      ?>
        <form action="" method="post">
          <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
              <h2 class="text-center">Date Not Available</h2>
            </div>
            <?php
              $not_avail = mysqli_query($connect, "SELECT * FROM haven_date WHERE book_ref = '$HHcode' AND book_remarks = 'Not Available' ORDER BY book_date DESC");
              foreach ($not_avail as $data) {
                $date_not = $data['book_date'];
                // $change_date = date('M', strtotime($date_not));
            ?>
            <div class="col-lg-4 col-md-4 col-sm-4" style="margin: 2px 0">
              <div style="padding: 10px 7px;
                          border: 1px solid red;
                          text-align: center;">
                <!-- <h1 style="font-size: 18px">Not Available</h1> -->
                <span  style="font-size: 16px">Date <b><?php echo $date_not ?></b></span>
              </div>
            </div>
            <?php
              }
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12"><hr></div>
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <h2>Date From</h2>
                <input type="date" name="date1" id="" class="form-control" style="padding: 10px 14px; font-size: 12px">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <h2>Date To</h2>
                <input type="date" name="date2" id="" class="form-control" style="padding: 10px 14px; font-size: 12px">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <h2 style="color: #fff">Action</h2>
                <button class="btn btn-success form-control" name="validate" style="padding: 10px 14px; font-size: 12px">Check Date</button>
              </div>
            </div>
          </div>
        </form>
      <?php
        } else {
          $new_date_booking1 = $_SESSION['date1banene'];
          $new_date_booking2 = $_SESSION['date2banene'];
          // unset($_SESSION['BookDate']);
          // unset($_SESSION['BookDate2']);
      ?>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <h2 class="text-center">Booking Date</h2>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12"><hr></div>
        <div class="col-lg-4 col-md-6 col-sm-4">
          <div class="form-group">
            <h3 class="text-center">DATE FROM</h2>
            <h1 class="text-center"><?php echo $new_date_booking1 ?></h1>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <h3 class="text-center">DATE TO</h2>
            <h1 class="text-center"><?php echo $new_date_booking2 ?></h1>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <h2 style="color: #fff">Action</h2>
            <a href="booking-cancel.php?id=<?php echo $poid ?>&&HHcode=<?php echo $HHcode ?>" class="btn btn-danger form-control" name="validate" style="padding: 10px 14px; font-size: 12px">Clear</a>
          </div>
        </div>
      </div>
      <hr>
      <form action="booking-process.php?HHcodes=<?php echo $HHcode ?>&&poid=<?php echo $poid ?>" method="post">
        <h2>INFORMATION SHEET</h2>
        <br>
        <?php
          $get_booking = "SELECT * FROM haven_details WHERE details_ref = '$poid'";
          $get_booking_qry = mysqli_query($connect, $get_booking);
          $booking_fetch = mysqli_fetch_array($get_booking_qry);
          $testingo1 = "SELECT * FROM haven_name WHERE hh_code = '$poid'";
          $get_name = mysqli_query($connect, $testingo1);
          $name_fetch = mysqli_fetch_array($get_name);
          if (mysqli_num_rows($get_booking_qry) < 1) {
        ?>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
              <br>
              <label for="" style="font-size: 15px">Full Name</label>
              <input type="text" name="fname1" class="form-control" style="border: 1px solid #000; border-radius: 0; padding: 12px 15px; font-size: 12px" autocomplete="OFF" required>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <br>
              <label for="" style="font-size: 15px">Contact Number</label>
              <input type="text" name="contact" class="form-control" style="border: 1px solid #000; border-radius: 0; padding: 12px 15px; font-size: 12px" autocomplete="OFF" required>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
              <br>
              <label for="" style="font-size: 15px">Total Pax</label>
              <input type="text" name="totalpax" class="form-control" style="border: 1px solid #000; border-radius: 0; padding: 12px 15px; font-size: 12px" autocomplete="OFF" required>
            </div>
            <div class="col-12">
              <div class="form-group">
                <h2 style="color: #fff">Action</h2>
                <button class="btn btn-success form-control" name="process" style="padding: 10px 14px; font-size: 12px">Save Information</button>
              </div>
            </div>
          </div>
        <?php
          } else {
        ?>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
              <br>
              <label for="" style="font-size: 15px">Full Name</label>
              <input type="text" name="fname1" class="form-control" style="border: 1px solid #000; border-radius: 0; padding: 12px 15px; font-size: 12px" autocomplete="OFF" required value="<?php echo $name_fetch['pangalan'] ?>">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <br>
              <label for="" style="font-size: 15px">Contact Number</label>
              <input type="text" name="contact" class="form-control" style="border: 1px solid #000; border-radius: 0; padding: 12px 15px; font-size: 12px" autocomplete="OFF" required value="<?php echo $booking_fetch['details_contact'] ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
              <br>
              <label for="" style="font-size: 15px">Total Pax</label>
              <input type="text" name="totalpax" class="form-control" style="border: 1px solid #000; border-radius: 0; padding: 12px 15px; font-size: 12px" autocomplete="OFF" required value="<?php echo $booking_fetch['details_pax'] ?>">
            </div>
            <div class="col-12">
              <div class="form-group">
                <h2 style="color: #fff">Action</h2>
                <button class="btn btn-primary form-control" name="update" style="padding: 10px 14px; font-size: 12px">Update Information</button>
              </div>
            </div>
          </div>
        <?php
          }
        ?>
        <br>
      </form>
      <hr>
      <br>
      <h2>PAYMENT METHOD</h2>
      <form action="booking-process.php?HHcodes=<?php echo $HHcode ?>&&poid=<?php echo $poid ?>" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="form-group">
              <br>
              <table class="table table-sm table-bordered" style="font-size: 14px">
                <tr>
                  <th class="text-center bg-primary text-white">Bank Name</th>
                  <th class="text-center bg-primary text-white">Account Name</th>
                  <th class="text-center bg-primary text-white">Account Number</th>
                </tr>
                <tr>
                  <th class="text-center">GCASH</th>
                  <th class="text-center">MICHELLE COSTALES KIM</th>
                  <th class="text-center">0968-035-3418</th>
                </tr>
                <tr>
                  <th class="text-center">BPI</th>
                  <th class="text-center">MICHELLE COSTALES</th>
                  <th class="text-center">06900 10275</th>
                </tr>
                <tr>
                  <th class="text-center">BPI</th>
                  <th class="text-center">MICHELLE COSTALES</th>
                  <th class="text-center">06930 52459</th>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <!-- <div class="form-group">
                <img src="no_img_250.jpg" style="width: 100px; hieght: 200px" alt="" class="" id="preview">
              </div> -->
            <div class="form-group">
              <br>
              <h3 class="text-right">Upload Payment here</h3>
              <input type="file" class="form-control" name="file" onchange="getImagePreview(event)" style="padding: 10px 14px; font-size: 12px">
            </div>
            <div class="form-group">
              <h2 style="color: #fff">Action</h2>
              <button class="btn btn-success form-control" name="book" style="padding: 10px 14px; font-size: 12px">Book Now!</button>
            </div>
          </div>
        </div>
        <br><br>
      </form>
      <?php
        }
      ?>
    </div>
  </div>
<?php include 'include/footer.php' ?>

<script>
  	// $(function(){
    //   $("#fileupload").change(function(event) {
    //     var x = URL.createObjectURL(event.target.files[0]);
    //     $("#upload-img").attr("src",x);
    //     console.log(event);
    //   });
    // })

    function getImagePreview(event)
    {
      var image=URL.createObjectURL(event.target.files[0]);
      var imagediv= document.getElementById('preview');
      var newimg=document.createElement('img');
      imagediv.innerHTML='';
      newimg.src=image;
      newimg.width="300";
      imagediv.appendChild(newimg);
    }
</script>