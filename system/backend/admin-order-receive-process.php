<?php
    include '../dbms/conn.php';

    session_start();
    $uid = $_SESSION['code'];
    // echo '<br>';
    $date = date('m-d-Y');

    $id = $_GET['id'];

    if (isset($_POST['receive'])) {

        // // Stockist Refund
        $percentage_sql = "SELECT p_amount FROM stockist_percentage WHERE p_code = '$uid' AND p_poid = '$id'";
        $percentage_qry = mysqli_query($connect, $percentage_sql);
        $percentage = mysqli_fetch_array($percentage_qry);

        $p_amount = $percentage['p_amount'];

        $refund_sql = "SELECT SUM(e_refund) AS e_refs FROM stockist_earning WHERE e_id = '$uid' AND e_poid = '$id'";
        $refund_qry = mysqli_query($connect, $refund_sql);
        $refund = mysqli_fetch_array($refund_qry);

        $r_amount = $refund['e_refs'];

        $deduct = $p_amount + $r_amount;

        $get_wallet_qry = mysqli_query($connect, "SELECT w_earning FROM stockist_wallet WHERE w_id = '$uid'");
        $get_wallet = mysqli_fetch_array($get_wallet_qry);

        $balance = $get_wallet['w_earning'];

        $remain_balance = $balance - $deduct;

        $update_wallet_sql = "UPDATE stockist_wallet SET w_earning = '$remain_balance' WHERE w_id = '$uid'";
        $update_wallet_qry = mysqli_query($connect, $update_wallet_sql);

        $delete_percentage = mysqli_query($connect, "DELETE FROM stockist_percentage WHERE p_poid = '$id'");

        $delete_earning = mysqli_query($connect, "DELETE FROM stockist_earning WHERE e_poid = '$id'");
        // End Refund

        $get_order_list = "SELECT * FROM upti_order_list INNER JOIN upti_transaction ON ol_poid = trans_poid WHERE ol_poid = '$id'";
        $get_order_list_sql = mysqli_query($connect, $get_order_list);

        while ($get_order_list_fetch = mysqli_fetch_array($get_order_list_sql)) {
            $code = $get_order_list_fetch['ol_code'];
            $qty = $get_order_list_fetch['ol_qty'];
            $country = $get_order_list_fetch['ol_country'];
            $date_order = $get_order_list_fetch['ol_date'];
            $c_state = $get_order_list_fetch['trans_state'];

            $territory_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$c_state' AND state_country = '$country'");
            $territory_fetch = mysqli_fetch_array($territory_sql);

            if (mysqli_num_rows($territory_sql) > 0) {
              $state = $territory_fetch['state_territory'];
            } else {
              $state = 'TERRITORY 1';
            }
            // echo $state;

            $check_package = "SELECT * FROM upti_pack_sett WHERE p_s_main = '$code'";
            $check_package_qry = mysqli_query($connect, $check_package);
            $check_package_sql = mysqli_num_rows($check_package_qry);
            
            // if ($date_order > '07-03-2022') {
                if ($check_package_sql == 0) {
                  // echo '<br>';
                  $get_main_code = mysqli_query($connect, "SELECT * FROM upti_code WHERE code_name = '$code'");
                  $get_main_code_fetch = mysqli_fetch_array($get_main_code);

                  $code_main = $get_main_code_fetch['code_main'];

                  if ($code_main == '') {
                    $code = $code;
                  } else {
                    $code = $code_main;
                  }

                  $get_remain_sql = "SELECT * FROM stockist_inventory WHERE si_item_code = '$code' AND si_item_country = '$country' AND si_item_role = '$state'";
                  $get_remain_qry = mysqli_query($connect, $get_remain_sql);
                  $get_remain_fetch = mysqli_fetch_array($get_remain_qry);
                  
                  $remain_stock_code = $get_remain_fetch['si_item_code'];
                  $remain_stock_qty = $get_remain_fetch['si_item_stock'];
                  // echo '<br>';
                  
                  $new_stocks = $remain_stock_qty + $qty;
                  
                  $receive_sql = "UPDATE stockist_inventory SET si_item_stock = '$new_stocks' WHERE si_item_code = '$code' AND si_item_country = '$country' AND si_item_role = '$state'";
                  $receive_qry = mysqli_query($connect, $receive_sql);

                  $re_sql = "INSERT INTO stockist_return (re_poid, re_code, re_qty, re_date, re_status) VALUES ('$id', '$remain_stock_code', '$qty', '$date', 'Received')";
                  $re_qry = mysqli_query($connect, $re_sql);
                    // }
                  $change_status = "UPDATE upti_transaction SET trans_stockist = 'Received' WHERE trans_poid = '$id'";
                  $change_status_qry = mysqli_query($connect, $change_status);

                } else {

                  foreach ($check_package_qry as $pack_data) {

                    $lamanngcode = $pack_data['p_s_code'];
                    $tot_qty = $pack_data['p_s_qty'] * $qty;

                    $get_remain_sql6 = "SELECT * FROM stockist_inventory WHERE si_item_code = '$lamanngcode' AND si_item_country = '$country' AND si_item_role = '$state'";
                    $get_remain_qry6 = mysqli_query($connect, $get_remain_sql6);
                    $get_remain_fetch6 = mysqli_fetch_array($get_remain_qry6);
                    
                    $remain_stock_qty6 = $get_remain_fetch6['si_item_stock'];
                    // echo '<br>';

                    $new_stocks6 = $remain_stock_qty6 + $tot_qty;
                  
                    $receive_sql6 = "UPDATE stockist_inventory SET si_item_stock = '$new_stocks6' WHERE si_item_code = '$lamanngcode' AND si_item_country = '$country' AND si_item_role = '$state'";
                    $receive_qry6 = mysqli_query($connect, $receive_sql6);

                  }

                  $re_sql = "INSERT INTO stockist_return (re_poid, re_code, re_qty, re_date, re_status) VALUES ('$id', '$remain_stock_code', '$qty', '$date', 'Received')";
                  $re_qry = mysqli_query($connect, $re_sql);
                    // }
                  $change_status = "UPDATE upti_transaction SET trans_stockist = 'Received' WHERE trans_poid = '$id'";
                  $change_status_qry = mysqli_query($connect, $change_status);

                }
            // }
        }
    
        if ($_SESSION['role'] != 'LOGISTIC') {
            echo "<script>alert('Transfered Successfully');window.location.href = '../incoming-rts-order.php';</script>";
        } else {
            echo "<script>alert('Transfered Successfully');window.location.href = '../ph-rts.php';</script>";
        }
    }
?>