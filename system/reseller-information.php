<?php
    session_start();
   
    include 'dbms/conn.php';
    include 'function.php';

    date_default_timezone_set("Asia/Manila"); 
    $date_today = date('m-d-Y');

    $Uid = $_SESSION['uid'];
    $Urole = $_SESSION['role'];
    $Ucode = $_SESSION['code'];
    $Ureseller = $_SESSION['code'];

    $count_sql = "SELECT * FROM upti_users WHERE users_code = '$Ucode'";
    $count_qry = mysqli_query($connect, $count_sql);
    $count_fetch = mysqli_fetch_array($count_qry);

    $Ucount = $count_fetch['users_count'];

    if($Urole == 'UPTIOSR') {
      $upline_sql = "SELECT * FROM upti_users WHERE users_code = '$Ucode'";
      $upline_qry = mysqli_query($connect, $upline_sql);
      $upline_fetch = mysqli_fetch_array($upline_qry);

      $Ucode = $upline_fetch['users_code'];
      $Ureseller = $upline_fetch['users_main'];
      $Ucount = $upline_fetch['users_count']; 
    }
    // Get Users Code & Users Upline Code

    $year = date('Y');

    $poid = 'RS'.$Uid.'-'.$Ucount;
    $csid = $year.$Uid.$Ucount;
    // Poid Number / Reference Number

    if (isset($_POST['saveinformation'])) {
        $fullnames = $_POST['fullname'];
        $fullname = strtoupper($fullnames);
        $sub_address = $_POST['address'];
        $addresss = str_replace("'", "\'", $sub_address);
        $address = strtoupper($addresss);
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $country = $_POST['country'];
        $states = $_POST['state'];
        $state = strtoupper($states);
        $offices = $_POST['asd'];
        $office = strtoupper($offices);
        $username = $_POST['username'];

        if ($country == 'CANADA' && $office == '' || $country == 'USA' && $office == '') {      
            flash("warning", "Please Select Direct Mail or Post Office");
            
            header('location: osr-reseller.php');
        } else {
            if ($state == '' && $country == 'CANADA' || $state == '' && $country == 'USA') {
              flash("warning", "Please Add State");
            
              header('location: osr-reseller.php');
            } else {

              if ($states == '' && $country != 'CANADA') {
                $states = 'ALL';
              }

            
              $username_check = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_username = '$username'");
              if (mysqli_num_rows($username_check) < 1) {
                  $user_info = mysqli_query($connect, "SELECT trans_fname FROM upti_transaction WHERE trans_poid = '$poid'");
                  $user = mysqli_fetch_array($user_info);

                  $name = $user['trans_fname'];

                  $creator_role = $count_fetch['users_role'];
                  if ($creator_role == 'UPTIRESELLER') {
                      $code = $count_fetch['users_code'];
                  } else {
                      $code = $count_fetch['users_main'];
                  }

                  $account = mysqli_query($connect, "INSERT INTO upti_users (
                      users_poid,
                      users_code,
                      users_level,
                      users_username,
                      users_password,
                      users_inviter,
                      users_name,
                      users_role,
                      users_status,
                      users_main,
                      users_creator
                  ) VALUES (
                      '$poid',
                      '$reseller_code',
                      '1',
                      '$username',
                      '123456',
                      '$Ucode',
                      '$fullnames',
                      'UPTIRESELLER',
                      'Deactive',
                      '$code',
                      '$code'
                  )");

                  $save_sql = "INSERT INTO upti_transaction (
                    trans_poid,
                    trans_date, 
                    trans_fname, 
                    trans_address, 
                    trans_email, 
                    trans_contact, 
                    trans_country,
                    trans_seller,
                    trans_my_reseller,
                    trans_status,
                    trans_admin,
                    trans_office,
                    trans_state,
                    trans_csid
                  ) VALUES (
                    '$poid',
                    '$date_today',
                    '$fullname',
                    '$address',
                    '$email',
                    '$phone',
                    '$country',
                    '$Ucode',
                    '$Ureseller',
                    'On Order',
                    'UPTIMAIN',
                    '$office',
                    '$states',
                    '$csid'
                  )";
                  $save_qry = mysqli_query($connect, $save_sql);

                  flash("success", "Information have been deleted successfully");
                  header('location: osr-reseller.php');
              } else {
                  flash("failed", "Username is not available, please try again");
                  header('location: osr-reseller.php');
              }

              
            }
        }
    }

    if(isset($_POST['delete_info'])) {
        
        $delete_sql = "DELETE FROM upti_transaction WHERE trans_poid = '$poid'";
        $delete_qry = mysqli_query($connect, $delete_sql);

        $delete_sql = "DELETE FROM upti_users WHERE users_poid = '$poid'";
        $delete_qry = mysqli_query($connect, $delete_sql);

        // echo "<script>alert('Customer Information has been Deleted Successfully');window.location='order-list.php'</script>";
        flash("save_info", "Customer Information has been Deleted Successfully");
        
        header('location: osr-reseller.php');
    }

    if(isset($_POST['update_info'])) {

        $fullnames = $_POST['fullname'];
        $fullname = strtoupper($fullnames);
        $sub_address = $_POST['address'];
        $addresss = str_replace("'", "\'", $sub_address);
        $address = strtoupper($addresss);
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $country = $_POST['country'];
        $offices = $_POST['asd'];
        $office = strtoupper($offices);
        $states = $_POST['state'];

        if ($states == '' && $country != 'CANADA') {
          $states = 'ALL';
        }

        $state = strtoupper($states);
        
        if ($state == '' && $country == 'CANADA') {
          flash("warning", "Please Add State");
        
          header('location: order-list.php');
        } else {
          $update_sql = "UPDATE upti_transaction SET
              trans_fname = '$fullname', 
              trans_address = '$address', 
              trans_email = '$email', 
              trans_contact = '$phone', 
              trans_country = '$country',
              trans_office = '$office',
              trans_state = '$states'
          WHERE trans_poid = '$poid'";
          $update_qry = mysqli_query($connect, $update_sql);

          // echo "<script>alert('Customer Information has been Updated Successfully');window.location='order-list.php'</script>";
          flash("save_info", "Customer Information has been Updated Successfully");
          
          header('location: osr-reseller.php');
        }
    }
?>