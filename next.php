<?php 
  include 'include/db.php';

  // Column Name
  // $output = '
  // <table class="table" bordered="1">
  // <tr>
  //     <th>Date Ordered</th>
  //     <th>Poid</th>
  //     <th>Status Date</th>
  //     <th>Country</th>
  //     <th>Subtotal</th>
  //     <th>Tax</th>
  //     <th>Earning</th>
  //     <th>Remarks</th>
  // <tr>
  // ';

  date_default_timezone_set('Asia/Manila');
  $date = date("m-d-Y");
  $time = date('h:i:sa');

  $qdl2 = "SELECT trans_date, trans_poid, trans_country, trans_remarks, trans_my_reseller, trans_subtotal FROM upti_transaction WHERE trans_status = 'Delivered' AND trans_date BETWEEN '03-16-2023' AND '04-04-2023'";
  $delivered_poid = mysqli_query($connect, $qdl2);

  foreach ($delivered_poid as $delivered) {
    $poid = $delivered['trans_poid'];
    $reseller = $delivered['trans_my_reseller'];
    $country = $delivered['trans_country'];
    $trans_subtotal = $delivered['trans_subtotal'];

    $activities_sql = mysqli_query($connect, "SELECT earning_status FROM upti_earning WHERE earning_poid = '$poid'");

    $activities_fetch = mysqli_fetch_array($activities_sql);

    if (mysqli_num_rows($activities_sql) > 0) {
      $status = $activities_fetch['earning_status'];
    } else {
      $status = 'NONE';
    }

    if ($status == 'NONE') {
      $peso_sql = mysqli_query($connect, "SELECT SUM(ol_php) AS php FROM upti_order_list WHERE ol_poid = '$poid'");
      $peso_fetch = mysqli_fetch_array($peso_sql);

      $subtotal = $peso_fetch['php'];

      $fourty = $subtotal * 0.40;
      $tax = $fourty * 0.05;

      $total_earning = $fourty - $tax;

      $reseller_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller'");
      $reseller_fetch = mysqli_fetch_array($reseller_sql);

      $reseller_wallet = $reseller_fetch['reseller_earning'] + $total_earning;

      $desc = 'You Received 40% Commission Product Worth of '.$trans_subtotal.' ['.$country.']';

      // if ($status == 'NONE') {

        $text = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller'");

        // $insert_sql = mysqli_query($connect, "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller', '$poid', '$total_earning', '$tax', '$desc', 'Sales', '$reseller')");
      // }

      // echo $delivered['trans_date'];
      // echo ' = ';
      // echo $poid;
      // echo ' = ';
      // echo $status;
      // echo '<br>';

      // $output .='
      // <tr>
      //     <td>'.$delivered['trans_date'].'</td>
      //     <td>'.$poid.'</td>
      //     <td>'.$status.'</td>
      //     <td>'.$delivered['trans_country'].'</td>
      //     <td>'.$subtotal.'</td>
      //     <td>'.$tax.'</td>
      //     <td>'.$total_earning.'</td>
      //     <td>'.$delivered['trans_remarks'].'</td>
      // </tr>
      // ';
    }
    
  }

  // $output .= '</table>';
  // // Header for  Download
  // // if (! headers_sent()) {
  // header("Content-Type: application/xls");
  // header("Content-Disposition: attachment; filename=ERROR.xls");
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // // }
  // // Render excel data file
  // echo $output;
  // // ob_end_flush();
  // exit;
?>