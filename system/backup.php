<?php
  include 'dbms/conn.php';

  $transaction_sql = mysqli_query($connect, "SELECT trans_poid FROM upti_transaction WHERE trans_status = 'Delivered' AND trans_date BETWEEN '04-20-2023' AND '04-24-2023'");

    // Column Name
    $output = '
    <table class="table" border="1">
    <tr>
        <th>Date Earning</th>
        <th>POid</th>
        <th>Computation</th> 
        <th>Total Earning</th> 
    <tr> 
';

  foreach ($transaction_sql as $data) {
    $data_poid = $data['trans_poid'];

    $order_list = mysqli_query($connect, "SELECT * FROM upti_order_list INNER JOIN upti_code ON ol_code = code_name WHERE code_category = 'PREMIUM'");
    $order_fetch = mysqli_fetch_array($order_list);

    if (mysqli_num_rows($order_list) > 0) {
      $poid = $data_poid;
      // echo ' + ';
      $peso = $order_fetch['ol_php'];
      $fourty = $peso * 0.40;
      $tax = $fourty * 0.5;
      $earning = $fourty - $tax;
      // echo ' = ';

      $earning_sql = mysqli_query($connect, "SELECT SUM(earning_earnings) as earn, earning_date FROM upti_earning WHERE earning_poid = '$poid'");
      $earning_fetch = mysqli_fetch_array($earning_sql);

      
      // echo '<br>';
      
      // echo '<br>';
      // echo '<br>';

    }

    $output .='
          <tr>
              <td>'.$earning_fetch['earning_date'].'</td>
              <td>'.$poid.'</td>
              <td>'.$earning.'</td>
              <td>'.$earning_fetch['earn'].'</td>
          </tr>
      ';

  }

  $output .= '</table>';
            // Header for  Download
            // if (! headers_sent()) {
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=ResellerSales.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            // }
            // Render excel data file
            echo $output;
            // ob_end_flush();
            exit;

?>