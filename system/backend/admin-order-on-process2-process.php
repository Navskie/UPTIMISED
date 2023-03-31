<?php
    include '../dbms/conn.php';

    session_start();
    $uid = $_SESSION['uid'];

    $id = $_GET['id'];
    
    $get_poid = "SELECT * FROM upti_transaction WHERE id = '$id'";
    $get_poid_qry = mysqli_query($connect, $get_poid);
    $get_poid_fetch = mysqli_fetch_array($get_poid_qry);
    
    $poid = $get_poid_fetch['trans_poid'];
    $customer_country = $get_poid_fetch['trans_country'];
    $mode_of_payment = $get_poid_fetch['trans_mop'];
    $state = $get_poid_fetch['trans_state'];
    
    $getnamex = "SELECT * FROM upti_users WHERE users_id = '$uid'";
    $getnamex_qry = mysqli_query($connect, $getnamex);
    $getnamex_fetch = mysqli_fetch_array($getnamex_qry);
    
    $namex = $getnamex_fetch['users_name'];

    $territory_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$state'");
    $territory_fetch = mysqli_fetch_array($territory_sql);

    if (mysqli_num_rows($territory_sql) > 0) {
      $c_state = $territory_fetch['state_territory'];
    } else {
      $c_state = 'TERRITORY 1';
    }

    if (isset($_POST['onprocess'])) {
        // $track = $_POST['tracking'];
        
        date_default_timezone_set('Asia/Manila');
        $time = date("h:m:i");
        $datenow = date('m-d-Y');
        
        $desc = $namex.' Update '.$poid.' set Ordered Status into On Process'; 

        // HISTORY
        $act = "INSERT INTO upti_activities (activities_poid, activities_time, activities_date, activities_name, activities_caption, activities_desc) VALUES ('$poid', '$time', '$datenow', '$namex', 'On Process', '$desc')";
        $act_qry = mysqli_query($connect, $act);
        
        // INVENTORY REPORT
        $inv_report = "UPDATE stockist_report SET rp_status = 'On Process' WHERE rp_poid = '$poid'";
        $inv_report_qry = mysqli_query($connect, $inv_report);
        
        // INVENTORY HISTORY
        $inv_history = "UPDATE stockist_history SET history_status = 'On Process' WHERE history_poid = '$poid'";
        $inv_history_qry = mysqli_query($connect, $inv_history);

        $epayment_process = "UPDATE upti_transaction SET trans_status = 'On Process' WHERE id = '$id'";
        $epayment_process_qry = mysqli_query($connect, $epayment_process);

        $epayment_process1 = "UPDATE upti_order_list SET ol_status = 'On Process' WHERE ol_poid = '$poid'";
        $epayment_process_qry1 = mysqli_query($connect, $epayment_process1);

        $remarks_sql = "INSERT INTO upti_remarks (remark_poid, remark_content, remark_name, remark_reseller, remark_date, remark_time) VALUES ('$poid', 'Your Order is being Processed', '$namex', 'Unread', '$datenow', '$time')";
        $remarks_qry = mysqli_query($connect, $remarks_sql);

        // Inventory Check Qty
        $get_qty_code = "SELECT * FROM upti_order_list WHERE ol_poid = '$poid'";
        $get_qty_code_qry = mysqli_query($connect, $get_qty_code);
        while ($get_qty_code_fetch = mysqli_fetch_array($get_qty_code_qry)) {
            $code_code = $get_qty_code_fetch['ol_code'];
            $code_qty = $get_qty_code_fetch['ol_qty'];

            // CHECK MOD AND COUNTRY
            if ($mode_of_payment != 'Cash On Pick Up') {
                $check_package = "SELECT * FROM upti_pack_sett WHERE p_s_main = '$code_code'";
                $check_package_sql = mysqli_query($connect, $check_package);
                $check_package_num = mysqli_num_rows($check_package_sql);
          
                // PACKAGE CHECK
                if ($check_package_num > 0) {
                    foreach ($check_package_sql as $data_pack) {
                      $iCode = $data_pack['p_s_code'];
                      $iQty = $data_pack['p_s_qty'] * $code_qty;

                      $inv_stock = "SELECT * FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_code = '$iCode' AND si_item_role = '$c_state'";
                      $inv_stock_qry = mysqli_query($connect, $inv_stock);
                      $inv_stock_fetch = mysqli_fetch_array($inv_stock_qry);

                      $total_stock = $inv_stock_fetch['si_item_stock'];

                      $new_total_stock = $total_stock - $iQty;

                      $update_inventory = "UPDATE stockist_inventory SET si_item_stock = '$new_total_stock' WHERE si_item_country = '$customer_country' AND si_item_code = '$iCode' AND si_item_role = '$c_state'";
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

                    $inv_stock = "SELECT * FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_code = '$code_codes' AND si_item_role = '$c_state'";
                    $inv_stock_qry = mysqli_query($connect, $inv_stock);
                    $inv_stock_fetch = mysqli_fetch_array($inv_stock_qry);

                    $total_stock = $inv_stock_fetch['si_item_stock'];

                    $new_total_stock = $total_stock - $code_qty;

                    $update_inventory = "UPDATE stockist_inventory SET si_item_stock = '$new_total_stock' WHERE si_item_country = '$customer_country' AND si_item_code = '$code_codes' AND si_item_role = '$c_state'";
                    $update_inventory_qry = mysqli_query($connect, $update_inventory);
                }
                // SINGLE CHECK

                // INVENTORY HISTORY
                $inv_history = "INSERT INTO stockist_history (history_date, history_poid, history_status) VALUES ('$datenow', '$poid', 'Pending')";
                $inv_history_qry = mysqli_query($connect, $inv_history);
            }
            // CHECK MOD AND COUNTRY
        }
        // Inventory Check Qty
        
        

          if($_SESSION['role'] == 'BRANCH') {
      ?>
          <script>alert('Order Status has been changed to On Process Successfully');window.location.href = '../poid-list.php?id=<?php echo $id ?>';</script>
      <?php
          } else {
      ?>
          <script>alert('Order Status has been changed to On Process Successfully');window.location.href = '../poid-list.php?id=<?php echo $id ?>';</script>
      <?php
          }
        }
    ?>