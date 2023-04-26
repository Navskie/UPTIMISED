<?php
    session_start();
    include 'function.php';
    include 'include/db.php';

    if ($_SESSION['replicate_code'] === '') {
      $replicate_code = '';
    } else {
      $replicate_code = $_SESSION['replicate_code'];
    }

    if(isset($_POST['sign-in'])) {
      $us = $_POST['us'];
      $pw = $_POST['pw'];

      if(empty($us) && empty($pw)) {
        flash("warn", "All fields are required.");
        header('location: login.php');
      } else {
        $check_account = "SELECT * FROM upti_users WHERE users_username = '$us' AND users_password = '$pw' AND users_status = 'Active'";
        $check_account_qry = mysqli_query($connect, $check_account);
        $check_account_fetch = mysqli_fetch_array($check_account_qry);
        $check_account_num = mysqli_num_rows($check_account_qry);

        if($check_account_num == 1) {
          $role = $check_account_fetch['users_role'];
          if($role == 'UPTIMAIN') {
            include 'login-role.php';
            header('Location: system/uptimain.php');
          } elseif($role == 'MARKETING') {
            include 'login-role.php';
            header('Location: system/marketing/marketing');
          } elseif($role == 'HR') {
            include 'login-role.php';
            header('Location: system/uptimain.php');
          } elseif($role == 'UPTIRESELLER') {
            include 'login-role.php';
            header('Location: system/reseller.php');
          } elseif($role == 'UPTIMANAGER') {
            include 'login-role.php';
            header('Location: system/manager.php');
          } elseif($role == 'UPTILEADER') {
            include 'login-role.php';
            header('Location: system/teamleader.php');
          } elseif($role == 'UPTIOSR') {
            include 'login-role.php';
            header('Location: system/osr.php');
          } elseif($role == 'UPTICREATIVES') {
            include 'login-role.php';
            header('Location: creatives.php');
          } elseif($role == 'UPTICSR') {
            include 'login-role.php';
            header('Location: system/branch.php');
          } elseif($role == 'SPECIAL') {
            include 'login-role.php';
            header('Location: system/admin-reseller.php');
          } elseif($role == 'UPTIACCOUNTING') {
            include 'login-role.php';
            header('Location: system/accounting.php');
          } elseif($role == 'IT/Sr Programmer') {
            include 'login-role.php';
            header('Location: system/navskie.php');
          } elseif($role == 'BRANCH') {
            include 'login-role.php';
            header('Location: system/branch.php');
          } elseif($role == 'ADS') {
            include 'login-role.php';
            header('Location: system/ads.php');
          }  elseif($role == 'LOGISTIC') {
            include 'login-role.php';
            header('Location: system/logistic.php');
          }  elseif($role == 'DHL') {
            include 'login-role.php';
            header('Location: system/dhl.php');
          }  elseif($role == 'Customer') {
            include 'login-role.php';
            header('Location: shop.php');
          } elseif($role == 'WEBSITE') {
            include 'login-role.php';
            header('Location: system/cs-onprocess-order.php');
          } elseif($role == 'HAVEN CSR') {
            include 'login-role.php';
            header('Location: system/admin/index.php');
          } elseif($role == 'HAVEN ADMIN') {
            include 'login-role.php';
            header('Location: system/admin/admin.php');
          } 
        } else {
        flash('warn', 'Username and Password not match.');
        header('location: login.php');
        }
      }
    }

    if (isset($_POST['signup'])) {
      $myuid = uniqid('CS-');
      $us = $_POST['us'];
      $pw = $_POST['pw'];
      $pw2 = $_POST['pw2'];
      $fn = $_POST['fn'];
      $ln = $_POST['ln'];
      $ea = $_POST['ea'];
      $mn = $_POST['mn'];
      $bday = $_POST['bday'];

      $date = date('m-d-Y');

      if ($pw == $pw2) {
        $user_check = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_username = '$us' AND users_status = 'Active'");
        if (mysqli_num_rows($user_check) > 0) {
          flash('warn', 'Username already taken');
          header('location: login.php');
        } else {
          $info_stmt = mysqli_query($connect, "INSERT INTO upti_customer (
            cs_uid,
            cs_fname,
            cs_lname,
            cs_email,
            cs_mobile,
            cs_bday,
            cs_date,
            cs_upper
          ) VALUES (
            '$myuid',
            '$fn',
            '$ln',
            '$ea',
            '$mn',
            '$bday',
            '$date',
            '$replicate_code'
          )
          ");
    
          $fln = $fn.' '.$ln;
    
          $login_stmt = mysqli_query($connect, "INSERT INTO upti_users (
            users_code,
            users_name,
            users_username,
            users_password,
            users_position,
            users_role,
            users_status
          ) VALUES (
            '$myuid',
            '$fln',
            '$us',
            '$pw',
            'Online',
            'Customer',
            'Active'
          )
          ");

          flash('success', 'Account has been registered successfully');
          header('location: login.php');
        }
      } else {
        flash('warn', 'Password not match');
        header('location: login.php');
      }
    }
  ?>