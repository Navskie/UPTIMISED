<?php

  include '../database/dbconn.php';

  $id = $_GET['id'];

  $update_book = mysqli_query($connect, "UPDATE haven_booking SET booking_status = 'Success' WHERE booking_ref = '$id'");

  // Computation

  $get_info = mysqli_query($connect, "SELECT * FROM haven_details WHERE details_ref = '$id'");
  $get_info_fetch = mysqli_fetch_array($get_info);

  $details_code = $get_info_fetch['details_code'];
  $details_amount = $get_info_fetch['details_amount'];

  $eigth = $details_amount * 0.08;
  $get_tax_8 = $eigth * 0.05;
  $details_amount_5 = $eigth - $get_tax_8;
  // echo '<br>';
  $details_amount_admin = $details_amount * 0.02;

  $osr_sales = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$details_code'");
  $osr_sales_fetch = mysqli_fetch_array($osr_sales);

  // $osr_sales_fetch['users_role'];

  if ($osr_sales_fetch['users_role'] == 'UPTIRESELLER') {

    $seller = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$details_code'");
    $seller_fetch = mysqli_fetch_array($seller);
  
    $reseller_earning = $seller_fetch['reseller_haven'];

    $new_reseller_earn = $reseller_earning + $details_amount_5;

    $seller_sql = "UPDATE upti_reseller SET reseller_haven = '$new_reseller_earn' WHERE reseller_code = '$details_code'";
    $seller_update = mysqli_query($connect, $seller_sql);

    $admin = mysqli_query($connect, "SELECT * FROM main_wallet WHERE wallet_code = 'UPTIMAIN'");
    $admin_fetch = mysqli_fetch_array($admin);

    $admin_earning = $admin_fetch['wallet'];

    $new_admin_wallet = $admin_earning + $details_amount_admin;

    $admin_update = mysqli_query($connect, "UPDATE main_wallet SET wallet = '$new_admin_wallet' WHERE wallet_code = 'UPTIMAIN'");

  }
   elseif ($osr_sales_fetch['users_role'] == 'UPTIOSR') {

    $seller = mysqli_query($connect, "SELECT * FROM upti_osc_wallet WHERE osc_code = '$details_code'");
    $seller_fetch = mysqli_fetch_array($seller);
  
    $reseller_earning = $seller_fetch['osc_wallet'];

    $new_reseller_earn = $reseller_earning + $details_amount_5;

    $seller_update = mysqli_query($connect, "UPDATE upti_osc_waller SET osc_wallet = '$new_reseller_earn' WHERE osc_code = '$details_code'");

    $admin = mysqli_query($connect, "SELECT * FROM main_wallet WHERE wallet_code = 'UPTIMAIN'");
    $admin_fetch = mysqli_fetch_array($admin);

    $admin_earning = $admin_fetch['wallet'];

    $new_admin_wallet = $admin_earning + $details_amount_admin;

    $admin_update = mysqli_query($connect, "UPDATE main_wallet SET wallet = '$new_admin_wallet' WHERE wallet_code = 'UPTIMAIN'");

  }

  // // History

  $date = date('m-d-Y');
  $time = date('h:m:s');

  $date_time = $date. ' - ' .$time;

  $seller_remarks = 'You received 8% commission for successfully booking from Hidden Haven.';

  $seller_history = mysqli_query($connect, "INSERT INTO upti_earning
  (earning_code, earning_date, earning_poid, earning_earnings, earning_remarks, earning_status, earning_name, earning_tax)
  VALUES
  ('$details_code', '$date_time', '$id', '$details_amount_5', '$seller_remarks', 'HIDDEN HAVEN', '$details_code', '$get_tax_8')");

  $admin_remarks = 'You received 2% commission for successfully booking from Hidden Haven.';

  $admin_history = mysqli_query($connect, "INSERT INTO upti_earning
  (earning_code, earning_date, earning_poid, earning_earnings, earning_remarks, earning_status, earning_name)
  VALUES
  ('UPTIMAIN', '$date_time', '$id', '$details_amount_admin', '$admin_remarks', 'HIDDEN HAVEN', 'UPTIMAIN')");

  header('Location: ../reservation.php');
  
?>