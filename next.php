<?php 
  include 'include/db.php';

  date_default_timezone_set('Asia/Manila');
  $date = date("m-d-Y");
  $time = date('h:i:sa');

  $qdl2 = "SELECT activities_poid FROM upti_activities WHERE activities_caption = 'Order Delivered' AND activities_date BETWEEN '04-01-2023' AND '04-11-2023'";
  $delivered_poid = mysqli_query($connect, $qdl2);

  foreach ($delivered_poid as $delivered) {
    $poid = $delivered['activities_poid'];
    // echo '<br>';

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
        
        // CROSS SELL
        $cross_sell_total = $direct_fetch['direct'] + $upsell_fetch['upsell'];
        // echo '<br>';
        $cross_sell = $cross_sell_total * $ten_percent;

        // REGULAR REBATES
        $rebates = $regular_fetch['regular'] * $fourty_percent;
        $rebates_total = $cross_sell + $rebates;
        $tax = $rebates_total * $five_percent;
        $earning = $rebates_total - $tax;
        $earning_2nd = $earning * $two_percent;
        $earning_3rd = $earning * $one_percent;

        $total_php = $direct_fetch['direct'] + $upsell_fetch['upsell'] + $regular_fetch['regular'];

    $earnings_sql = mysqli_query($connect, "SELECT * FROM upti_earning WHERE earning_poid = '$poid'");

    if (mysqli_num_rows($earnings_sql) == 0) {
      
      $get_transaction = mysqli_query($connect, "SELECT trans_remarks, trans_my_reseller, trans_country FROM upti_transaction WHERE trans_poid = '$poid'");
      $trans_fetch = mysqli_fetch_array($get_transaction);

      $remarks = $trans_fetch['trans_remarks'];
      $reseller = $trans_fetch['trans_my_reseller'];
      $country = $trans_fetch['trans_country'];

      if ($remarks == 'REGULAR') {

        // Reseller Earnings
        $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller'");
        $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

        $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $earning;

        $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller'");

        $wallet_remarks = 'You Received 40% Comission Product Worth of '.$earning.' ['.$country.']';

        $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller', '$poid', '$earning', '$tax', '$wallet_remarks', 'Sales', '$reseller')";
        $earn_history_sql = mysqli_query($connect, $earn_history);

      } elseif ($remarks == 'RESELLER') {

        $reseller_earning_10 = $rebates_total + $reseller_fetch['reseller'] * $ten_percent;

        // Reseller Earnings
        $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller'");
        $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

        $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $reseller_earning_10;

        $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller'");

        $wallet_remarks = 'You Received 10% Comission Reseller Creation Worth of '.$reseller_earning_10.' ['.$country.']';

        $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller', '$poid', '$reseller_earning_10', '$tax', '$wallet_remarks', 'Sales', '$reseller')";
        $earn_history_sql = mysqli_query($connect, $earn_history);

      }
      
    }

  }
?>