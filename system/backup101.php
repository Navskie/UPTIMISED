<?php
    session_start();
    include 'dbms/conn.php';
    include 'function.php';
    include('smtp/PHPMailerAutoload.php');    

    date_default_timezone_set("Asia/Manila"); 
    $date_today = date('m-d-Y');
    $time = date('h:i A');

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

    $poid = 'PD'.$Uid.'-'.$Ucount;
    // Poid Number / Reference Number

    $get_transaction = "SELECT trans_mop, trans_country, trans_csid FROM upti_transaction WHERE trans_poid = '$poid'";
    $get_transaction_qry = mysqli_query($connect, $get_transaction);
    $get_transaction_fetch = mysqli_fetch_array($get_transaction_qry);
    $get_transaction_num = mysqli_num_rows($get_transaction_qry);

    if ($get_transaction_num == 1) {
        $mode_of_payment = $get_transaction_fetch['trans_mop'];
        $customer_country = $get_transaction_fetch['trans_country'];
        $csid = $get_transaction_fetch['trans_csid'];
    } else {
        $mode_of_payment = '';
        $customer_country = '';
        $csid = '';
    }

    $subtotal = $_SESSION['subtotal'];
    $surcharge = $_SESSION['surcharge'];
    $shipping = $_SESSION['shipping'];
    $total_amount = $_SESSION['total_amount'];

    if (isset($_POST['checkouts'])) { // isset if

      if ($mode_of_payment == 'E-Payment' || $mode_of_payment == 'Cash On Pick Up' && $customer_country == 'TAIWAN') {
        $img_name = $_FILES['file']['name'];
        $img_size = $_FILES['file']['size'];
        $img_tmp = $_FILES['file']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        // echo ($img_ex);
        $img_ex_lc = strtolower($img_ex);

        $new_name = $poid.'.'.$img_ex_lc;
        $img_path_sa_buhay_niya = './images/payment/'.$new_name;
        move_uploaded_file($img_tmp, $img_path_sa_buhay_niya);
      } else {
        $img_name = '';
        $new_name = '';
      }

      if ($img_name != '' && $mode_of_payment == 'E-Payment' || $img_name != '' && $mode_of_payment == 'Cash On Pick Up' || $mode_of_payment != 'E-Payment') { // img required
        
        $upsell_sql = mysqli_query($connect, "SELECT SUM(ol_qty) AS upsell FROM upti_order_list INNER JOIN upti_code ON code_name = ol_code WHERE ol_poid = '$poid' AND code_category = 'UPSELL'");
        $upsell_fetch = mysqli_fetch_array($upsell_sql);

        $direct_sql = mysqli_query($connect, "SELECT SUM(ol_qty) AS direct FROM upti_order_list INNER JOIN upti_code ON code_name = ol_code WHERE ol_poid = '$poid' AND code_category = 'DIRECT'");
        $direct_fetch = mysqli_fetch_array($direct_sql);

        $regular_sql = mysqli_query($connect, "SELECT SUM(ol_qty) AS regular FROM upti_order_list INNER JOIN upti_code ON code_name = ol_code WHERE ol_poid = '$poid' AND code_category = 'PROMO'");
        $regular_fetch = mysqli_fetch_array($regular_sql);

        // PREMIUM
        $premium_sql = mysqli_query($connect, "SELECT SUM(ol_qty) AS premium FROM upti_order_list INNER JOIN upti_code ON code_name = ol_code WHERE ol_poid = '$poid' AND code_category = 'PREMIUM'");
        $premium_fetch = mysqli_fetch_array($premium_sql);

        $upsell = $upsell_fetch['upsell'];
        // echo '<br>';
        $direct = $direct_fetch['direct'];
        // echo '<br>';
        $regular = $regular_fetch['regular'];
        // echo '<br>';
        $premium = $premium_fetch['premium'] ;

        if ($premium > 0) { // kung may premium start
          echo 'Regular : ';
          echo $regular;
          echo '<br>';
          echo 'Premium : ';
          echo $premium;
          echo '<br>';
          $premium_direct = $direct - $regular;
          $premium_upsell = $upsell - $regular;
          if ($direct == 0 && $regular > 0) {
            $premium_direct = 0;
          } elseif ($upsell == 0 && $regular > 0) {
            $premium_upsell = 0;
          }
          echo 'Direct : ';
          echo $premium_direct;
          echo '<br>';
          echo 'Upsell : ';
          echo $premium_upsell;
          echo '<br>';
          echo 'Total Upsell : ';
          echo $up2 = $premium * 2;
          echo '<br>';
          echo 'Total Direct : ';
          echo $dir2 = $premium * 2;
          echo '<br>';

          if ($premium_upsell >= $up2 || $premium_direct >= $dir2) {
            // flash("warning", "Too many cross item. checkout no more");
            // header('location: order-list.php');

            echo 'false';
          } else {

            // $regular_upsell = $premium * 2;
            // echo $cross_upsell = $up2 - $regular_upsell;
            // echo '<br>';
            // echo $cross_direct = $dir2 - $regular_upsell;
            // echo '<br>';

            // if ($cross_upsell >= $upsell || $cross_direct >= $direct) {
            //   echo 'TRUE';
            // } else {
            //   echo 'FALSE';
            // }
            
            echo 'true';

          }

        } else { // kung may premium end

          if ($upsell > 0 && $regular == '' || $direct > 0 && $regular == '' || $premium < 0) { // wag mo ilabas tie up mo boi
            flash("warning", "you only have cross sell and direct sell order. checkout no more");
            header('location: order-list.php');
          } else {                

          //   // include 'checkout.php';

          } // wag mo ilabas tie up mo boi

        } // kung may premium closing

      } else {
        flash("warning", "You forgot to attach your payment receipt Attach it now!");
        header('location: order-list.php');
      } // img require d end

    } // isset if 

?>