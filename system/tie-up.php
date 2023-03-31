<?php

    session_start();

    include 'dbms/conn.php';
    include 'function.php';

    date_default_timezone_set("Asia/Manila"); 
    $date_today = date('m-d-Y');

    $Uid = $_SESSION['uid'];
    $Ucode = $_SESSION['code'];

    $count_sql = "SELECT users_reseller, users_role, users_main, users_code FROM upti_users WHERE users_code = '$Ucode'";
    $count_qry = mysqli_query($connect, $count_sql);
    $count_fetch = mysqli_fetch_array($count_qry);

    $reseller = $count_fetch['users_main'];

    $poid = $_GET['poid'];

    $get_country = mysqli_query($connect, "SELECT trans_country FROM upti_transaction WHERE trans_poid = '$poid'");
    $get_country_f = mysqli_fetch_array($get_country);

    $country = $get_country_f['trans_country'];
    $state = $get_country_f['trans_state'];

    if ($country == 'CANADA') {
      if ($state == 'ALBERTA') {
        $state = 'ALBERTA';
      } else {
        $state = 'ALL';
      }
    } else {
      $state = 'ALL';
    }

    if (isset($_POST['add'])) {
        $code = $_POST['item_code'];
        $qty = $_POST['qty'];

        $get_package_info = mysqli_query($connect, "SELECT * FROM upti_items WHERE items_code = '$code'");
        $packfetch = mysqli_fetch_array($get_package_info);

        $pack_desc = $packfetch['items_desc'];
        $pack_points = $packfetch['items_points'];

        $price_stmt = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_code = '$code' AND country_name = '$country'");
        $price_fetch = mysqli_fetch_array($price_stmt);

        $price = $price_fetch['country_price'];
        $php = $price_fetch['country_total_php'];

        $subtotal = $qty * $price;

        // get new code
        $get_new_code = "SELECT * FROM upti_code WHERE code_name = '$code'";
        $get_new_code_qry = mysqli_query($connect, $get_new_code);
        $get_new_code_fetch = mysqli_fetch_array($get_new_code_qry);

        $new_item_code = $get_new_code_fetch['code_main'];

        // Single Item Check
        $check_stock = "SELECT * FROM stockist_inventory WHERE si_item_code = '$new_item_code' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry = mysqli_query($connect, $check_stock);
        $check_stock_fetch = mysqli_fetch_array($check_stock_qry);
        $check_stock_num = mysqli_num_rows($check_stock_qry);

        if ($check_stock_num == 0) {
            $stockist_stock = 0;
        } else {
            $stockist_stock = $check_stock_fetch['si_item_stock'];
        }

      $get_package_info = mysqli_query($connect, "SELECT * FROM upti_package WHERE package_code = '$code'");

      if (mysqli_num_rows($get_package_info) > 0) {
        $get_package_fetch = mysqli_fetch_array($get_package_info);

        // Package Check
        $c1 = $get_package_fetch['package_one_code'];
        $oq1 = $get_package_fetch['package_one_qty'];
        $q1 = $item_qty * $oq1;

        $c2 = $get_package_fetch['package_two_code'];
        $oq2 = $get_package_fetch['package_two_qty'];
        $q2 = $item_qty * $oq2;

        $c3 = $get_package_fetch['package_three_code'];
        $oq3 = $get_package_fetch['package_three_qty'];
        $q3 = $item_qty * $oq3;

        $c4 = $get_package_fetch['package_four_code'];
        $oq4 = $get_package_fetch['package_four_qty'];
        $q4 = $item_qty * $oq4;

        $c5 = $get_package_fetch['package_five_code'];
        $oq5 = $get_package_fetch['package_five_qty'];
        $q5 = $item_qty * $oq5;
        
        $c6 = $get_package_fetch['package_six_code'];
        $oq6 = $get_package_fetch['package_six_qty'];
        $q6 = $item_qty * $oq6;

        // 1
        $check_stock1 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$c1' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry1 = mysqli_query($connect, $check_stock1);
        $check_stock_fetch1 = mysqli_fetch_array($check_stock_qry1);
        $check_stock_num1 = mysqli_num_rows($check_stock_qry1);
        if ($check_stock_num1 == 0) {
            $stockist_stock1 = 0;
        } else {
            $stockist_stock1 = $check_stock_fetch1['si_item_stock'];
        }
        // echo '<br>';
        // 2
        $check_stock2 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$c2' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry2 = mysqli_query($connect, $check_stock2);
        $check_stock_fetch2 = mysqli_fetch_array($check_stock_qry2);
        $check_stock_num2 = mysqli_num_rows($check_stock_qry2);
        if ($check_stock_num2 == 0) {
            $stockist_stock2 = 0;
        } else {
            $stockist_stock2 = $check_stock_fetch2['si_item_stock'];
        }
        // echo '<br>';
        // 3
        $check_stock3 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$c3' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry3 = mysqli_query($connect, $check_stock3);
        $check_stock_fetch3 = mysqli_fetch_array($check_stock_qry3);
        $check_stock_num3 = mysqli_num_rows($check_stock_qry3);
        if ($check_stock_num3 == 0) {
            $stockist_stock3 = 0;
        } else {
            $stockist_stock3 = $check_stock_fetch3['si_item_stock'];
        }
        // echo '<br>';
        // 4
        $check_stock4 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$c4' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry4 = mysqli_query($connect, $check_stock4);
        $check_stock_fetch4 = mysqli_fetch_array($check_stock_qry4);
        $check_stock_num4 = mysqli_num_rows($check_stock_qry4);
        if ($check_stock_num4 == 0) {
            $stockist_stock4 = 0;
        } else {
            $stockist_stock4 = $check_stock_fetch4['si_item_stock'];
        }
        // echo '<br>';
        // 5
        $check_stock5 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$c5' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry5 = mysqli_query($connect, $check_stock5);
        $check_stock_fetch5 = mysqli_fetch_array($check_stock_qry5);
        $check_stock_num5 = mysqli_num_rows($check_stock_qry5);
        if ($check_stock_num5 == 0) {
            $stockist_stock5 = 0;
        } else {
            $stockist_stock5 = $check_stock_fetch5['si_item_stock'];
        }

        $check_stock6 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$c6' AND si_item_country = '$country' AND si_item_state = '$state'";
        $check_stock_qry6 = mysqli_query($connect, $check_stock6);
        $check_stock_fetch6 = mysqli_fetch_array($check_stock_qry6);
        $check_stock_num6 = mysqli_num_rows($check_stock_qry6);
        if ($check_stock_num6 == 0) {
            $stockist_stock6 = 0;
        } else {
            $stockist_stock6 = $check_stock_fetch6['si_item_stock'];
        }

        if ($stockist_stock1 >= $q1 && $stockist_stock2 >= $q2 && $stockist_stock3 >= $q3 && $stockist_stock4 >= $q4 && $stockist_stock5 >= $q5 && $stockist_stock6 >= $q6) {
          $order_list = mysqli_query($connect, "INSERT INTO upti_order_list 
            (
              ol_country,
              ol_poid,
              ol_code,
              ol_seller,
              ol_reseller,
              ol_desc,
              ol_price,
              ol_php,
              ol_qty,
              ol_points,
              ol_subtotal,
              ol_status,
              ol_date
            ) VALUES (
              '$country',
              '$poid',
              '$code',
              '$Ucode',
              '$reseller',
              '$pack_desc',
              '$price',
              '$php',
              '$qty',
              '$pack_points',
              '$subtotal',
              'Pending',
              '$date_today'
            )");

          flash("success", "Tie Up has been added successfully");
          header('location: osr-reseller.php');
        } else {
          flash("failed", "Insufficient stocks to process your order");
          header('location: osr-reseller.php');
        }
      } else {
        if ($stockist_stock > $qty) {
          $order_list = mysqli_query($connect, "INSERT INTO upti_order_list 
          (
            ol_country,
            ol_poid,
            ol_code,
            ol_seller,
            ol_reseller,
            ol_desc,
            ol_price,
            ol_php,
            ol_qty,
            ol_points,
            ol_subtotal,
            ol_status,
            ol_date
          ) VALUES (
            '$country',
            '$poid',
            '$code',
            '$Ucode',
            '$reseller',
            '$pack_desc',
            '$price',
            '$php',
            '$qty',
            '$pack_points',
            '$subtotal',
            'Pending',
            '$date_today'
          )");

          flash("success", "Tie Up has been added successfully");
          header('location: osr-reseller.php');
        } else {
          flash("failed", "Insufficient stocks to process your order");
          header('location: osr-reseller.php');
        }
      } 
    }
    
?>