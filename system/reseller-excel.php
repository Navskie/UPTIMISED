<?php
  include 'dbms/conn.php';

  if (isset($_POST['res_info'])) {
    $country = $_POST['country'];
    // Column Name
    $output = '
    <table class="table" bordered="1">
    <tr>
        <th>Reseller Name</th>
        <th>Reseller Country</th>
        <th>Date Added</th>
        <th>Seller</th>
        <th>Reseller Code</th>
        <th>Reseller Mobile</th>
        <th>Reselelr Address</th>
        <th>Reselelr Status</th>
    <tr>
    ';

    // Display Column Names as First Row
    // $excelData = implode('\t', array_values($fields)).'\n';

    // Fetch Records From Database
    $export_sql = "SELECT trans_date, trans_seller, trans_country, reseller_name, reseller_country, reseller_code, reseller_mobile, reseller_address, users_status FROM upti_users INNER JOIN upti_reseller ON reseller_code = users_code INNER JOIN upti_transaction ON trans_poid = reseller_poid WHERE users_status = 'Active' AND trans_country = '$country' AND users_role = 'UPTIRESELLER' GROUP BY reseller_code";
    // echo '<br>';
    $export_qry = mysqli_query($connect, $export_sql);
    $export_num = mysqli_num_rows($export_qry);

    if($export_num > 0) {
      while($row = mysqli_fetch_array($export_qry)) {  
        
          $seller = $row['trans_seller'];

          $name_sql = mysqli_query($connect, "SELECT users_name FROM upti_users WHERE users_code = '$seller'");
          $name_fetch = mysqli_fetch_array($name_sql);

          $output .='
              <tr>
                  <td>'.$row['reseller_name'].'</td>
                  <td>'.$row['trans_country'].'</td>
                  <td>'.$row['trans_date'].'</td>
                  <td>'.$name_fetch['users_name'].'</td>
                  <td>'.$row['reseller_code'].'</td>
                  <td>'.$row['reseller_mobile'].'</td>
                  <td>'.$row['reseller_address'].'</td>
                  <td>'.$row['users_status'].'</td>
              </tr>
          ';
      }
      $output .= '</table>';
      // Header for  Download
      // if (! headers_sent()) {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=ResellerInformation_FOR_".$country.".xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      // }
      // Render excel data file
      echo $output;
      // ob_end_flush();
      exit;
    }                
  }
?>