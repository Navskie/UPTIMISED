<?php include 'include/header.php' ?>
<?php include 'include/navbar.php' ?>
<?php include 'include/topbar.php' ?>

<div class="page-wrapper">
<!-- Page-header start -->
<div class="page-header">
    <div class="page-header-title">
        <h4>Booking</h4>
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
                <?php
                  if (isset($_POST['test'])) {
                    // echo 'edelwais';
                    $HHcode = $_POST['villa'];

                    $newDate1 = $_POST['date1'];
                    $date1 = date("d-m-Y", strtotime($newDate1));
                    $date4 = date("Y-m-d", strtotime($newDate1));
                    
                    $newDate2 = $_POST['date2'];
                    $date2 = date("d-m-Y", strtotime($newDate2));

                    $text1 = date_create($date1);
                    $text2 = date_create($date2);

                    $sum = date_diff($text1, $text2);

                    $result = $sum->format("%a");

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
                          $insert_into = "INSERT INTO haven_date (book_date, book_ref, book_remarks) VALUES ('$date4', '$HHcode', 'Not Available')";
                          $insert_into_qry = mysqli_query($connect, $insert_into);
                        }

                      }

                      $date1 = date('d-m-Y', strtotime($date1 ."+1 days"));
                      $get_date = date('Y-m-d', strtotime($date1));

                      $validation_2 = mysqli_query($connect, "SELECT * FROM haven_date WHERE book_remarks = 'Not Available' AND book_ref = '$HHcode' AND book_date = '$get_date'");

                      if (mysqli_num_rows($validation_2) > 0) {
                        $nessy = $nessy + 1;
                      } else {
                        // echo 'blee';
                        $insert_into = "INSERT INTO haven_date (book_date, book_ref, book_remarks) VALUES ('$get_date', '$HHcode', 'Not Available')";
                        $insert_into_qry = mysqli_query($connect, $insert_into);
                      }
                      // echo '<br>';
                      $ok++;
                    }

                    if($newDate1 === $newDate2) {
                      $get_date = $date4;
                    }

                    if ($result == 0) {
                      $date_check = mysqli_query($connect, "SELECT * FROM haven_date WHERE book_date = '$get_date' AND book_remarks = 'Not Available'");

                      if (mysqli_num_rows($date_check)) {
                  ?>
                    <script>alert('Date is not available');window.location.href = 'booking.php'</script>
                  <?php
                      } else {
                        $insert_into = "INSERT INTO haven_date (book_date, book_ref, book_remarks) VALUES ('$get_date', '$HHcode', 'Not Available')";
                        $insert_qry = mysqli_query($connect, $insert_into);
                      }
                    }
                  }
                ?>
                  <form action="" method="post">
                    <h2>Block Dates</h2>
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Villa Style</label>
                          <select class="form-control" name="villa">
                            <option value="">Select Style</option>
                            <?php
                              $style_sql = mysqli_query($connect, "SELECT * FROM haven_product");
                              foreach ($style_sql as $style) {
                            ?>
                            <option value="<?php echo $style['product_code'] ?>"><?php echo $style['product_title'] ?></option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Date From</label>
                          <input type="date" class="form-control" name="date1">
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Date To</label>
                          <input type="date" class="form-control" name="date2">
                        </div>
                      </div>

                      <div class="col-12"><hr></div>

                      <div class="col-12"><button class="btn btn-danger float-right" name="test">Block</button></div>
                    </div>
                  </form>
                </div>                  
            </div>
            <!-- Language - Comma Decimal Place table end -->
        </div>
    </div>
</div>
<!-- Page-body end -->
<?php include 'include/footer.php' ?>