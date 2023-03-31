<?php

include 'dbms/conn.php';

session_start();

// echo 'test';
    $date1 = '';
    $date2 = '';

    // Column Name
    $output = '
    <table class="table" bordered="1">
    <tr>
        <th>Raffle Number</th>
        <th>Raffle Name</th>
        <th>Country</th>
    <tr>
    ';


    $export_sql = "SELECT raffle_name, raffle_number, raffle_code, raffle_poid FROM upti_raffle";
    $export_sql_qry = mysqli_query($connect, $export_sql);

    foreach ($export_sql_qry as $data) {
        $ol_seller = $data['raffle_code'];
        $ol_raffle = $data['raffle_poid'];
        $ol_number = $data['raffle_number'];

        if ($ol_raffle == '') {
          $username = mysqli_query($connect, "SELECT users_name FROM upti_users WHERE users_code = '$ol_seller'");
          $username_fetch = mysqli_fetch_array($username);

          $country = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$ol_seller'");
          $country_fetch = mysqli_fetch_array($country);

          $country_name = $country_fetch['reseller_country'];

          if ($country_name == '') {
            $trans_poid = $country_fetch['reseller_poid'];

            $country = mysqli_query($connect, "SELECT * FROM upti_transaction WHERE trans_poid = '$trans_poid'");
            $country_fetch = mysqli_fetch_array($country);

            $country_name = $country_fetch['trans_country'];
          }

          $users_name = $username_fetch['users_name'];
          $raffle_number = $ol_seller.'-'.$ol_number;
          // echo ' - ';
        } else {
          $country = mysqli_query($connect, "SELECT * FROM upti_transaction WHERE trans_poid = '$ol_raffle'");
          $country_fetch = mysqli_fetch_array($country);

          $country_name = $country_fetch['trans_country'];

          $users_name = $data['raffle_name'];
          $raffle_number = $ol_raffle.''.$ol_number;
          // echo ' - ';
        }

        // echo '<br>';
        $output .='
            <tr>
                <td>'.$users_name.'</td>
                <td>'.$raffle_number.'</td>
                <td>'.$country_name.'</td>
            </tr>
            ';
        }
        $output .= '</table>';
        // Header for  Download
        // if (! headers_sent()) {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=SALES_TIKTOK".$date1.'-'.$date2.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        // }
        // Render excel data file
        echo $output;
        // ob_end_flush();
        exit;


?>