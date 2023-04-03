<?php
    include '../dbms/conn.php';
    include '../function.php';
    
    session_start();
    $uid = $_SESSION['uid'];
    $id = $_GET['id'];

    $getnamex = "SELECT * FROM upti_users WHERE users_id = '$uid'";
    $getnamex_qry = mysqli_query($connect, $getnamex);
    $getnamex_fetch = mysqli_fetch_array($getnamex_qry);
    
    $namex = $getnamex_fetch['users_name'];

    if (isset($_POST['delivered'])) {
        // DATE TIME
        date_default_timezone_set('Asia/Manila'); 
        $time = date("h:i A");
        $datenow = date('m-d-Y');

        // order info
        $poid_sql = mysqli_query($connect, "SELECT trans_poid, trans_mop, trans_country, trans_state, trans_my_reseller, trans_remarks FROM upti_transaction WHERE id = '$id'");
        $poid_fetch = mysqli_fetch_array($poid_sql);

        $poid = $poid_fetch['trans_poid'];
        $mop = $poid_fetch['trans_mop'];
        $country = $poid_fetch['trans_country'];
        $c_state = $poid_fetch['trans_state'];
        $reseller = $poid_fetch['trans_my_reseller'];
        $remarks = $poid_fetch['trans_remarks'];




        // LEVEL
        $reseller_sql = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$reseller'");
        $reseller_sql_fetch = mysqli_fetch_array($reseller_sql);



        $reseller_first = $reseller_sql_fetch['users_creator'];
        $reseller_level1 = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$reseller_first'");
        $reseller_level1_fetch = mysqli_fetch_array($reseller_level1);
        $first_level = $reseller_level1_fetch['users_level'];


        $reseller_second = $reseller_level1_fetch['users_creator'];
        $reseller_level2 = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$reseller_second'");
        $reseller_level2_fetch = mysqli_fetch_array($reseller_level2);
        $second_level = $reseller_level2_fetch['users_level'];


        $reseller_third = $reseller_level2_fetch['users_creator'];
        $reseller_level3 = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$reseller_third'");
        $reseller_level3_fetch = mysqli_fetch_array($reseller_level3);
        $third_level = $reseller_level3_fetch['users_level'];
        // LEVEL ENDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD




        $territory_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$c_state'");
        $territory_fetch = mysqli_fetch_array($territory_sql);
    
        if (mysqli_num_rows($territory_sql) > 0) {
          $state = $territory_fetch['state_territory'];
        } else {
          $state = 'TERRITORY 1';
        }

        $stockist_stmt = mysqli_query($connect, "SELECT * FROM stockist WHERE stockist_country = '$country' AND stockist_role = '$state'");
        $stockist_f = mysqli_fetch_array($stockist_stmt);
        $stockist = $stockist_f['stockist_code'];

        // activities check
        $activities_sql = mysqli_query($connect, "SELECT * FROM upti_activities WHERE activities_poid = '$poid' AND activities_caption = 'Order Delivered'");

        $direct_sql = mysqli_query($connect, "SELECT SUM(ol_php) AS direct FROM upti_order_list INNER JOIN upti_code ON ol_code = code_name WHERE code_category = 'DIRECT' AND ol_poid = '$poid'");
        $direct_fetch = mysqli_fetch_array($direct_sql);

        $upsell_sql = mysqli_query($connect, "SELECT SUM(ol_php) AS upsell FROM upti_order_list INNER JOIN upti_code ON ol_code = code_name WHERE code_category = 'UPSELL' AND ol_poid = '$poid'");
        $upsell_fetch = mysqli_fetch_array($upsell_sql);

        $regular_sql = mysqli_query($connect, "SELECT SUM(ol_php) AS regular FROM upti_order_list INNER JOIN upti_code ON ol_code = code_name WHERE code_category = 'PROMO' AND ol_poid = '$poid'");
        $regular_fetch = mysqli_fetch_array($regular_sql);

        $reseller_sql = mysqli_query($connect, "SELECT SUM(ol_php) AS reseller FROM upti_order_list INNER JOIN upti_code ON ol_code = code_name WHERE code_category = 'RESELLER' AND ol_poid = '$poid'");
        $reseller_fetch = mysqli_fetch_array($reseller_sql);

        $ten_percent = 0.10;
        $fourty_percent = 0.40;
        $five_percent = 0.05;
        $three_percent = 0.03;
        $two_percent = 0.02;
        $one_percent = 0.01;
        

        // RESELLER
        $reseller_rbt = $reseller_fetch['reseller'];

        
        // CROSS SELL
        $cross_sell_total = $direct_fetch['direct'] + $upsell_fetch['upsell'];
        $cross_sell = $cross_sell_total * $ten_percent;

        // REGULAR REBATES
        $rebates = $regular_fetch['regular'] * $fourty_percent;
        $rebates_total = $cross_sell + $rebates;
        $tax = $rebates_total * $five_percent;
        $earning = $rebates_total - $tax;
        $earning_2nd = $earning * $two_percent;
        $earning_3rd = $earning * $one_percent;

        $reseller_earning_10 = $reseller_rbt * $ten_percent;
        $reseller_tax = $reseller_earning_10 * 0.05;
        $reseller_total = $reseller_earning_10 - $reseller_tax;

        $total_php = $direct_fetch['direct'] + $upsell_fetch['upsell'] + $regular_fetch['regular'];

        if (mysqli_num_rows($activities_sql) < 1) { //double tap issue


          if ($remarks == 'REGULAR') {

            // STOCKIST PERCENTAGE
            $percentage = $total_php * $three_percent;

            $stockist_wallet = "SELECT * FROM stockist_wallet WHERE w_id = '$stockist'";
            $stockist_wallet_qry = mysqli_query($connect, $stockist_wallet);
            $stockist_balance = mysqli_fetch_array($stockist_wallet_qry);

            $s_wallet = $stockist_balance['w_earning'] + $percentage;
  
            $update_stockist_wallet = mysqli_query($connect, "UPDATE stockist_wallet SET w_earning = '$s_wallet' WHERE w_id = '$stockist'");

            $remarks_wallet = "Stockist Percentage for POID ".$poid." amount of ".$percentage;

            $history_wallet = mysqli_query($connect, "INSERT INTO stockist_percentage (
              p_poid,
              p_code,
              p_amount,
              p_desc,
              p_time,
              p_date,
              p_pack
            ) VALUES (
              '$poid',
              '$stockist',
              '$percentage',
              '$remarks_wallet',
              '$time',
              '$datenow',
              'Regular Order'
            )");


            // Reseller Earnings
            $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller'");
            $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

            $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $earning;

            $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller'");

            $wallet_remarks = 'You Received 40% Comission Product Worth of '.$earning.' ['.$country.']';

            $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller', '$poid', '$earning', '$tax', '$wallet_remarks', 'Sales', '$reseller')";
            $earn_history_sql = mysqli_query($connect, $earn_history);

            // Reseller Earnings ENDDDDDDDDDDDDDDDDDDDDDDDDDDDD

            // LEVEL 1 EARNINGS
            if ($first_level > 1) {
              $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller_first'");
              $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

              $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $earning_2nd;

              $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller_first'");

              $wallet_remarks = 'You Received 2% Comission Product Worth of '.$earning.' ['.$country.']';

              $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller_first', '$poid', '$earning_2nd', '0', '$wallet_remarks', 'Level 1', '$reseller_first')";
              $earn_history_sql = mysqli_query($connect, $earn_history);
            }

            // LEVEL 2 EARNINGS
            if ($second_level > 1) {
              $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller_second'");
              $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

              $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $earning_2nd;

              $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller_second'");

              $wallet_remarks = 'You Received 2% Comission Product Worth of '.$earning.' ['.$country.']';

              $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller_second', '$poid', '$earning_2nd', '0', '$wallet_remarks', 'Level 2', '$reseller_second')";
              $earn_history_sql = mysqli_query($connect, $earn_history);
            }

            // LEVEL 3 EARNINGS
            if ($third_level > 1) {
              $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller_third'");
              $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

              $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $earning_3rd;

              $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller_third'");

              $wallet_remarks = 'You Received 1% Comission Product Worth of '.$earning.' ['.$country.']';

              $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller_third', '$poid', '$earning_3rd', '0', '$wallet_remarks', 'Level 3', '$reseller_third')";
              $earn_history_sql = mysqli_query($connect, $earn_history);
            }
            
          } elseif ($remarks == 'RESELLER') {

            // STOCKIST PERCENTAGE
            $percentage = $total_php * $five_percent;

            $stockist_wallet = "SELECT * FROM stockist_wallet WHERE w_id = '$stockist'";
            $stockist_wallet_qry = mysqli_query($connect, $stockist_wallet);
            $stockist_balance = mysqli_fetch_array($stockist_wallet_qry);

            $s_wallet = $stockist_balance['w_earning'] + $percentage;
  
            $update_stockist_wallet = mysqli_query($connect, "UPDATE stockist_wallet SET w_earning = '$s_wallet' WHERE w_id = '$stockist'");

            $remarks_wallet = "Stockist Percentage for POID ".$poid." amount of ".$percentage;

            $history_wallet = mysqli_query($connect, "INSERT INTO stockist_percentage (
              p_poid,
              p_code,
              p_amount,
              p_desc,
              p_time,
              p_date,
              p_pack
            ) VALUES (
              '$poid',
              '$stockist',
              '$percentage',
              '$remarks_wallet',
              '$time',
              '$datenow',
              'Reseller Package Order'
            )");
            
            // Reseller Earnings
            $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller'");
            $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

            $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $reseller_total;

            $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller'");

            $wallet_remarks = 'You Received 10% Comission Reseller Creation Worth of '.$reseller_total.' ['.$country.']';

            $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller', '$poid', '$reseller_earning_10', '$tax', '$wallet_remarks', 'Sales', '$reseller')";
            $earn_history_sql = mysqli_query($connect, $earn_history);

            // Reseller Earnings ENDDDDDDDDDDDDDDDDDDDDDDDDDDDD

          }

        
          // Inventory Check Qty
          $get_qty_code = "SELECT * FROM upti_order_list WHERE ol_poid = '$poid'";
          $get_qty_code_qry = mysqli_query($connect, $get_qty_code);
          while ($get_qty_code_fetch = mysqli_fetch_array($get_qty_code_qry)) {
              $code_code = $get_qty_code_fetch['ol_code'];
              $code_qty = $get_qty_code_fetch['ol_qty'];

              // CHECK MOD AND COUNTRY
              if ($mop == 'Cash On Pick Up') {
                  $check_package = "SELECT * FROM upti_pack_sett WHERE p_s_main = '$code_code'";
                  $check_package_sql = mysqli_query($connect, $check_package);
                  $check_package_num = mysqli_num_rows($check_package_sql);
            
                  // PACKAGE CHECK
                  if ($check_package_num > 0) {
                      foreach ($check_package_sql as $data_pack) {
                        $iCode = $data_pack['p_s_code'];
                        $iQty = $data_pack['p_s_qty'] * $code_qty;

                        $inv_stock = "SELECT * FROM stockist_inventory WHERE si_item_country = '$country' AND si_item_code = '$iCode' AND si_item_role = '$state'";
                        $inv_stock_qry = mysqli_query($connect, $inv_stock);
                        $inv_stock_fetch = mysqli_fetch_array($inv_stock_qry);

                        $total_stock = $inv_stock_fetch['si_item_stock'];

                        $new_total_stock = $total_stock - $iQty;

                        $update_inventory = "UPDATE stockist_inventory SET si_item_stock = '$new_total_stock' WHERE si_item_country = '$country' AND si_item_code = '$iCode' AND si_item_role = '$state'";
                        $update_inventory_qry = mysqli_query($connect, $update_inventory);
                      }
                  }
                  // PACKAGE CHECK
                  else
                  // SINGLE CHECK
                  {

                      $get_new_code = "SELECT * FROM upti_code WHERE code_name = '$code_code'";
                      $get_new_code_qry = mysqli_query($connect, $get_new_code);
                      $get_new_code_fetch = mysqli_fetch_array($get_new_code_qry);

                      $code_codes = $get_new_code_fetch['code_main'];

                      $inv_stock = "SELECT * FROM stockist_inventory WHERE si_item_country = '$country' AND si_item_code = '$code_codes' AND si_item_role = '$state'";
                      $inv_stock_qry = mysqli_query($connect, $inv_stock);
                      $inv_stock_fetch = mysqli_fetch_array($inv_stock_qry);

                      $total_stock = $inv_stock_fetch['si_item_stock'];

                      $new_total_stock = $total_stock - $code_qty;

                      $update_inventory = "UPDATE stockist_inventory SET si_item_stock = '$new_total_stock' WHERE si_item_country = '$country' AND si_item_code = '$code_codes' AND si_item_role = '$state'";
                      $update_inventory_qry = mysqli_query($connect, $update_inventory);
                  }
                  // SINGLE CHECK

              }
              // CHECK MOD AND COUNTRY
          }
          // Inventory Check Qty

          if ($country == 'CANADA' || $country == 'USA' || $country == 'TAIWAN') { // refund money
            $order_list = mysqli_query($connect, "SELECT * FROM upti_order_list WHERE ol_poid = '$poid'");

            while ($order = mysqli_fetch_array($order_list)) {
              $item_code = $order['ol_code'];
              $item_qty = $order['ol_qty'];
              $item_php = $order['ol_php'];
              $subtotal = $order['ol_subtotal'];

              $pack_stmt = mysqli_query($connect, "SELECT * FROM upti_pack_sett WHERE p_s_main = '$item_code'");
              if (mysqli_num_rows($pack_stmt) > 0) { 


                foreach ($pack_stmt as $data_refund) {
                  $pack_iCode = $data_refund['p_s_code'];
                  $pack_iQty = $data_refund['p_s_qty'] * $item_qty;

                  // price
                  $price_stmt = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_name = '$country' AND country_code = '$pack_iCode'");
                  $price_f6 = mysqli_fetch_array($price_stmt);
                  $stockist_price = $price_f6['country_stockist'];

                  $buy += $stockist_price * $pack_iQty;

                }

                $refund = $buy - $item_php;

                $desc = $item_code;

              $earning_list = mysqli_query($connect, "INSERT INTO stockist_earning (
                e_id,
                e_poid,
                e_code,
                e_desc,
                e_country,
                e_qty,
                e_price,
                e_subtotal,
                e_refund,
                e_date,
                e_time,
                e_state
              ) VALUES (
                '$stockist',
                '$poid',
                '$item_code',
                '$desc',
                '$country',
                '$item_qty',
                '$item_php',
                '$buy',
                '$refund',
                '$datenow',
                '$time',
                '$state'
              )");

              $stockist_w_stmt = mysqli_query($connect, "SELECT * FROM stockist_wallet WHERE w_id = '$stockist'");
              $stockist_w_f = mysqli_fetch_array($stockist_w_stmt);

              $stockist_wallet = $stockist_w_f['w_earning'] + $refund;

              $stockist_w = mysqli_query($connect, "UPDATE stockist_wallet SET w_earning = '$stockist_wallet' WHERE w_id = '$stockist'");

              } else { 


                $single_stmt = mysqli_query($connect, "SELECT * FROM upti_code WHERE code_name = '$item_code'");
                $single_f = mysqli_fetch_array($single_stmt);

                $single_code = $single_f['code_main'];
                $category = $single_f['code_category'];
                
                // price
                $single_qry = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_name = '$country' AND country_code = '$single_code'");
                $single_f = mysqli_fetch_array($single_qry);

                $single_qry2 = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_name = 'PHILIPPINES' AND country_code = '$item_code'");
                $single_f2 = mysqli_fetch_array($single_qry2);

                $item_php = $single_f2['country_price'] * $item_qty;
                
                $stockist_price = $single_f['country_php'];
                // echo '<br>';
                $buy = $stockist_price * $item_qty;

                $refund = $buy - $item_php;

                // echo '<br>';

                $earning_list = mysqli_query($connect, "INSERT INTO stockist_earning (
                  e_id,
                  e_poid,
                  e_code,
                  e_desc,
                  e_country,
                  e_state,
                  e_qty,
                  e_price,
                  e_subtotal,
                  e_refund,
                  e_date,
                  e_time
                ) VALUES (
                  '$stockist',
                  '$poid',
                  '$item_code',
                  '$single_code',
                  '$country',
                  '$state',
                  '$item_qty',
                  '$item_php',
                  '$buy',
                  '$refund',
                  '$datenow',
                  '$time'
                )");

                $stockist_w_stmt = mysqli_query($connect, "SELECT * FROM stockist_wallet WHERE w_id = '$stockist'");
                $stockist_w_f = mysqli_fetch_array($stockist_w_stmt);

                $stockist_wallet = $stockist_w_f['w_earning'] + $refund;

                $stockist_w = mysqli_query($connect, "UPDATE stockist_wallet SET w_earning = '$stockist_wallet' WHERE w_id = '$stockist'");


              }// package check 


            } // while poid list


          } // refund money


          // INVENTORY HISTORY
          $inv_history = "UPDATE stockist_history SET history_status = 'Delivered' WHERE history_poid = '$poid'";
          $inv_history_qry = mysqli_query($connect, $inv_history);
          
          // INVENTORY REPORT
          $inv_report = "UPDATE stockist_report SET rp_status = 'Delivered' WHERE rp_poid = '$poid'";
          $inv_report_qry = mysqli_query($connect, $inv_report);

          $desc = $namex.' Approve '.$poid.' set Ordered Status into Delivered';

          // HISTORY
          $act = "INSERT INTO upti_activities (activities_poid, activities_time, activities_date, activities_name, activities_caption, activities_desc) VALUES ('$poid', '$time', '$datenow', '$namex', 'Order Delivered', '$desc')";
          $act_qry = mysqli_query($connect, $act);

          // UPDATE ACCOUNT
          $users_report = "UPDATE upti_users SET users_status = 'Active' WHERE users_poid = '$poid'";
          $users_report_qry = mysqli_query($connect, $users_report);

          $epayment_process = "UPDATE upti_transaction SET trans_status = 'Delivered' WHERE id = '$id'";
          $epayment_process_qry = mysqli_query($connect, $epayment_process);
          
          $ol_sql = "UPDATE upti_order_list SET ol_status = 'Delivered' WHERE ol_poid = '$poid'";
          $ol_qry = mysqli_query($connect, $ol_sql);

          flash("poid", "Poid has been delivered successfully");
          header('location: ../poid-list.php?id='.$id.'');

        } else {
          flash("warning", "This poid already delivered. System Error");
          header('location: ../poid-list.php?id='.$id.'');
        }// double top issue
    }
  
?>