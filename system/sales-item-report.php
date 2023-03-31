<?php

include 'dbms/conn.php';

session_start();

if (isset($_POST['export'])) {
    $newDate1 = $_POST['date1'];
    $date1 = date("m-d-Y", strtotime($newDate1));
    $year1 = date("Y", strtotime($newDate1));
    $newDate2 = $_POST['date2'];
    $date2 = date("m-d-Y", strtotime($newDate2));
    $year2 = date("Y", strtotime($newDate2));
    $status = $_POST['status'];

    // Column Name
    $output = '
    <table class="table" bordered="1">
    <tr>
        <th>Date Ordered</th>
        <th>Date Delivered</th>
        <th>Signed By</th>
        <th>Seller ID</th>
        <th>Seller Name</th>
        <th>Address</th>
        <th>Country</th>
        <th>State</th>
        <th>POID</th>
        <th>Item Code</th>
        <th>Item Description</th>
        <th>Item Qty</th>
        <th>Price ($)</th>
        <th>Price (P)</th>
        <th>Status</th>
    <tr>
    ';

    // Fetch Records From Database
    if ($status === 'Delivered') {
        $export_sql = "SELECT ol_poid, ol_php, ol_price, ol_country, ol_seller, ol_code, ol_qty, ol_desc, activities_date FROM upti_order_list INNER JOIN upti_activities ON ol_poid = activities_poid WHERE activities_caption = 'Order Delivered' AND activities_date BETWEEN '$date1' AND '$date2'";
        $export_sql_qry = mysqli_query($connect, $export_sql);
    } elseif ($status === 'handover') {
        $export_sql = "SELECT 
        ol_poid, ol_php, ol_price, ol_country, ol_seller, ol_code, ol_qty, ol_desc, trans_date FROM upti_order_list 
        INNER JOIN upti_transaction
        ON ol_poid = trans_poid 
        WHERE
        trans_status = 'Pending' AND
        trans_date BETWEEN '$date1' AND '$date2' OR
        trans_status = 'On Process' AND
        trans_date BETWEEN '$date1' AND '$date2' OR
        trans_status = 'In Transit' AND
        trans_date BETWEEN '$date1' AND '$date2'";
        $export_sql_qry = mysqli_query($connect, $export_sql);
    } elseif ($status === 'RTS') {
        $export_sql = "SELECT 
        ol_poid, ol_php, ol_price, ol_country, ol_seller, ol_code, ol_qty, ol_desc, trans_date FROM upti_order_list 
        INNER JOIN upti_transaction
        ON ol_poid = trans_poid 
        WHERE
        trans_status = 'RTS' AND
        trans_date BETWEEN '$date1' AND '$date2' OR
        trans_status = 'Canceled' AND
        trans_date BETWEEN '$date1' AND '$date2'";
        $export_sql_qry = mysqli_query($connect, $export_sql);
    }

    foreach ($export_sql_qry as $data) {        
        
        $ol_poid = $data['ol_poid'];
        // echo ' - ';
        $ol_php = $data['ol_php'];
        // echo ' - ';
        $ol_price = $data['ol_price'];
        // echo '<br>';
        $ol_seller = $data['ol_seller'];
        $get_reseller2 = mysqli_query($connect, "SELECT trans_seller FROM upti_transaction WHERE trans_seller = '$ol_seller'");
        $fetch_reseller2 = mysqli_fetch_array($get_reseller2);

        $trans_poid = $fetch_reseller2['trans_seller'];

        $get_reseller = mysqli_query($connect, "SELECT users_inviter FROM upti_users WHERE users_code = '$trans_poid'");
        $fetch_reseller = mysqli_fetch_array($get_reseller);

        $code = $fetch_reseller['users_inviter'];
        // echo ' ==== ';
        // echo $ol_poid;
        // echo '<br>';
        if ($code == '') {
          $code = "UPTIMAIN";
          // echo ' ==== ';
          // echo $ol_poid;
          // echo '<br>';
        }

        $get_code_name = mysqli_query($connect, "SELECT users_name FROM upti_users WHERE users_code = '$code'");
        $get_code_fetch = mysqli_fetch_array($get_code_name);

        $sign = $get_code_fetch['users_name'];
    
        $ol_country = $data['ol_country'];
        $ol_seller = $data['ol_seller'];
        $ol_code = $data['ol_code'];
        $ol_desc = $data['ol_desc'];
        $ol_qty = $data['ol_qty'];

        if ($status === 'handover' || $status === 'RTS') {
            $activities_date = $data['trans_date'];
        } else {
            $activities_date = $data['activities_date'];
        }

        $username = mysqli_query($connect, "SELECT users_name FROM upti_users WHERE users_code = '$ol_seller'");
        $username_fetch = mysqli_fetch_array($username);

        $users_name = $username_fetch['users_name'];

        $transaction = mysqli_query($connect, "SELECT trans_address, trans_status, trans_state, trans_date FROM upti_transaction WHERE trans_poid = '$ol_poid'");
        $transaction_fetch = mysqli_fetch_array($transaction);

        $trans_status = $transaction_fetch['trans_status'];
        $trans_date = $transaction_fetch['trans_date'];
        $trans_state = $transaction_fetch['trans_state'];
        $trans_address = $transaction_fetch['trans_address'];

        $output .='
            <tr>
                <td>'.$trans_date.'</td>
                <td>'.$activities_date.'</td>
                <td>'.$sign.'</td>
                <td>'.$ol_seller.'</td>
                <td>'.$users_name.'</td>
                <td>'.$trans_address.'</td>
                <td>'.$ol_country.'</td>
                <td>'.$trans_state.'</td>
                <td>'.$ol_poid.'</td>
                <td>'.$ol_code.'</td>
                <td>'.$ol_desc.'</td>
                <td>'.$ol_qty.'</td>
                <td>'.$ol_price.'</td>
                <td>'.$ol_php.'</td>
                <td>'.$trans_status.'</td>
            </tr>
            ';
          
        }
        $output .= '</table>';
        // Header for  Download
        // if (! headers_sent()) {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=SALES_REPORT".$date1.'-'.$date2.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        // }
        // Render excel data file
        echo $output;
        // ob_end_flush();
        exit;
}  