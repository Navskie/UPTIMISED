<?php 
  include 'dbms/conn.php';

  session_start();
  
  $code = $_SESSION['code'];
  
  $my_account = mysqli_query($connect, "SELECT * FROM stockist WHERE stockist_code = '$code'");
  $account_f = mysqli_fetch_array($my_account);
  
  $country = $account_f['stockist_country'];
  $s_role = $account_f['stockist_role'];

  // require 'vendor/autoload.php';

  // use PhpOffice\PhpSpreadsheet\Spreadsheet;
  // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  if (isset($_POST['export_sales'])) {
    $newDate1 = $_POST['date1'];
    $date1 = date("m-d-Y", strtotime($newDate1));
    $newDate2 = $_POST['date2'];
    $date2 = date("m-d-Y", strtotime($newDate2));

    
    // Column Name
    $output = '
    <table class="table" bordered="1">
    <tr>
        <th>Date Order</th>
        <th>Date Triggered</th>
        <th>Reseller ID</th>
        <th>Reseller Name</th>
        <th>Poid</th>
        <th>Country</th>
        <th>State</th>
        <th>$ Sales Amount</th>
        <th>Php Sales Amount</th>
        <th>Status</th>
    <tr>
';


  $export_sql = "SELECT trans_state, activities_date, ol_date, ol_seller, ol_poid, ol_country, ol_subtotal, ol_php, ol_status FROM upti_order_list INNER JOIN upti_activities ON ol_poid = activities_poid INNER JOIN upti_transaction ON trans_poid = ol_poid WHERE activities_caption = 'Order Delivered' AND ol_country = '$country' AND activities_date BETWEEN '$date1' AND '$date2' ORDER BY activities_date ASC";


    // echo '<br>';
    $export_qry = mysqli_query($connect, $export_sql);
    $export_num = mysqli_num_rows($export_qry);

    if($export_num > 0) {
        while($row = mysqli_fetch_array($export_qry)) {
            $seller = $row['ol_seller'];
            $state = $row['trans_state'];

            $territory_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$state' AND state_country = '$country'");
            $territory_fetch = mysqli_fetch_array($territory_sql);

            if (mysqli_num_rows($territory_sql) > 0) {
              $territory = $territory_fetch['state_territory'];
            } else {
              $territory = 'TERRITORY 1';
            }

            if ($s_role == $territory) {
            
            $get_name = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$seller'");
            $get_fetch = mysqli_fetch_array($get_name);
            $name = $get_fetch['users_name'];
            $output .='
                <tr>
                    <td>'.$row['ol_date'].'</td>
                    <td>'.$row['activities_date'].'</td>
                    <td>'.$seller.'</td>
                    <td>'.$name.'</td>
                    <td>'.$row['ol_poid'].'</td>
                    <td>'.$row['ol_country'].'</td>
                    <td>'.$row['trans_state'].'</td>
                    <td>'.$row['ol_subtotal'].'</td>
                    <td>'.$row['ol_php'].'</td>
                    <td>'.$row['ol_status'].'</td>
                </tr>
            ';
            }
        }
        $output .= '</table>';
        // Header for  Download
        // if (! headers_sent()) {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=Sales_Report.xls");
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