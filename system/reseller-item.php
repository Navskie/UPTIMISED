<?php

    session_start();

    include 'dbms/conn.php';
    include 'function.php';

    // user information
    $userCODE = $_SESSION['code'];
    $userID = $_SESSION['uid'];

    $upti_users = mysqli_query($connect, "SELECT users_count, users_name, users_level, users_main FROM upti_users WHERE users_code = '$userCODE'");
    $upti_users_fetch = mysqli_fetch_array($upti_users);

    $count = $upti_users_fetch['users_count'];
    $name = $upti_users_fetch['users_name'];
    $level = $upti_users_fetch['users_level'];
    $userMAIN = $upti_users_fetch['users_main'];

    date_default_timezone_set('Asia/Manila');
    $date = date("m-d-Y");
    $time = date('h:i:sa');

    $poid = 'RS'.$userID.'-'.$count;
    // Poid Number / Reference Number

    $get_country = "SELECT * FROM upti_transaction WHERE trans_poid = '$poid'";
    $get_country_qry = mysqli_query($connect, $get_country);
    $get_country_fetch = mysqli_fetch_array($get_country_qry);

    $customer_country = $get_country_fetch['trans_country'];
    $state = $get_country_fetch['trans_state'];

    $territory_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$state'");
    $territory_fetch = mysqli_fetch_array($territory_sql);

    if (mysqli_num_rows($territory_sql) > 0) {
      $c_state = $territory_fetch['state_territory'];
    } else {
      $c_state = 'TERRITORY 1';
    }

    if(isset($_POST['add_items'])) {  
      $item_code = $_POST['item_code'];
      $item_qty = $_POST['qty'];





      // ITEM DESCRIPTION / POINTS
      $ol_desc_sql = mysqli_query($connect, "SELECT * FROM upti_items WHERE items_code = '$item_code'");
      $ol_desc_fetch = mysqli_fetch_array($ol_desc_sql);

      if (mysqli_num_rows($ol_desc_sql) > 0) {
        $item_desc = $ol_desc_fetch['items_desc'];
        $item_points = $ol_desc_fetch['items_points'];
      } else {
        $ol_desc_sql = mysqli_query($connect, "SELECT * FROM upti_package WHERE package_code = '$item_code'");
        $ol_desc_fetch = mysqli_fetch_array($ol_desc_sql);
        $item_desc = $ol_desc_fetch['package_desc'];
        $item_points = $ol_desc_fetch['package_points'];
      }
      // ITEM DESCRIPTION / POINTS ENDDDDDDDDDDDDDDDDDDDDDDDDD

      // ITEM PRICE
      $item_price_sql = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_name = '$customer_country' AND country_code = '$item_code'");
      $item_price_fetch = mysqli_fetch_array($item_price_sql);

      $price = $item_price_fetch['country_price'];
      $php = $item_price_fetch['country_php'] * $item_qty;
      $subtotal = $price * $item_qty;
      // ITEM PRICE END





      $order_list_sql = mysqli_query($connect, "SELECT * FROM upti_order_list WHERE ol_poid = '$poid' AND ol_code = '$item_code'");

      if (mysqli_num_rows($order_list_sql) < 1) { // ORDER LIST DOUBLE

        // restriction qry
        $restriction_qry = mysqli_query($connect, "SELECT * FROM upti_code WHERE code_name = '$item_code'");
        $restriction_fetch = mysqli_fetch_array($restriction_qry);

        $restriction = $restriction_fetch['code_restrict'];

        $restriction_qry_2 = mysqli_query($connect, "SELECT * FROM upti_restrict WHERE res_code = '$item_code' AND res_country = '$customer_country'");
        // restriction end

        if (mysqli_num_rows($restriction_qry_2) > 0 && $restriction == 'ON' || $restriction == '') { // RESTRICTIONS

          $item_bundle = mysqli_query($connect, "SELECT * FROM upti_items INNER JOIN upti_code ON code_name = items_code WHERE items_code = '$item_code'");
          $item_bundle_fetch = mysqli_fetch_array($item_bundle);

          if (mysqli_num_rows($item_bundle) > 0) { // ITEM OR BUNDLE

            $main_code = $item_bundle_fetch['code_main'];

            $inventory_sql = mysqli_query($connect, "SELECT si_item_stock FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_role = '$c_state' AND si_item_code = '$main_code'");
            $inventory_fetch = mysqli_fetch_array($inventory_sql);
  
            $si_item_stocks = $inventory_fetch['si_item_stock'];
  
            if ($si_item_stocks >= $item_qty) { // Check Stocks
              
              $insert_item_sql = mysqli_query($connect, "INSERT INTO upti_order_list 
              (ol_seller, ol_reseller, ol_admin, ol_country, ol_poid, ol_code, ol_desc, ol_qty, ol_points, ol_php, ol_price, ol_subtotal, ol_status, ol_date) 
              VALUES 
              ('$userCODE', '$userMAIN', 'UPTIMAIN', '$customer_country', '$poid', '$item_code', '$item_desc', '$item_qty', '$item_points', '$php', '$price', '$subtotal', 'On Order', '$date')");


              flash("order", "Item has been added successfully");
              header('location: osr-reseller.php');
  
            } else {
              // echo '';
              flash("warning", "Insufficient Stocks to Process Your Order!! Please check again.");
              header('location: osr-reseller.php');
            } // Check Stocks END
  
  




          } else {






            $bundle_items_sql = mysqli_query($connect, "SELECT * FROM upti_pack_sett WHERE p_s_main = '$item_code'");

            foreach ($bundle_items_sql as $bundle_items) {
              $code = $bundle_items['p_s_code'];
              // echo '=';
              $qty = $bundle_items['p_s_qty'] * $item_qty;
              // echo '=';
              $loop_qty += $qty;

              $inventory_qry = "SELECT si_item_stock FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_role = '$c_state' AND si_item_code = '$code'";
              $inventory_sql = mysqli_query($connect, $inventory_qry);
              $inventory_fetch = mysqli_fetch_array($inventory_sql);
      
              $si_item_stocks = $inventory_fetch['si_item_stock'];
              // echo '<br>';
                if ($si_item_stocks >= $qty) {
                  $inv += $qty;
                  // echo '<br>';
                } else {
                  $inv = 0;
                  // echo '<br>';
                }

            }

            // echo $inv;
            // echo $loop_qty;

              if ($inv == $loop_qty) {

                $insert_item_sql = mysqli_query($connect, "INSERT INTO upti_order_list 
                (ol_seller, ol_reseller, ol_admin, ol_country, ol_poid, ol_code, ol_desc, ol_qty, ol_points, ol_php, ol_price, ol_subtotal, ol_status, ol_date) 
                VALUES 
                ('$userCODE', '$userMAIN', 'UPTIMAIN', '$customer_country', '$poid', '$item_code', '$item_desc', '$item_qty', '$item_points', '$php', '$price', '$subtotal', 'On Order', '$date')");

                flash("order", "Item has been added successfully");
                header('location: osr-reseller.php');

              } else {
                // echo '';
                flash("warning", "Insufficient Stocks to Process Your Order!! Please check again.");
                header('location: osr-reseller.php');
              }





          } // ITEM OR BUNDLE END

        } else {
          flash("warning", "The item you've selected is NOT available in your country! Please check again.");
          header('location: osr-reseller.php');
        } // RESTRICTIONS END
        
      } else { // ORDER LIST DOUBLE END
        flash("warning", "This product is already on the Order List, Please choose another product!");
        header('location: osr-reseller.php');
      } // ORDER LIST DOUBLE END

    }
?>