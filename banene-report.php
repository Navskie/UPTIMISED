<?php

    include 'include/db.php';
    
    session_start();
    
     // Column Name
     $output = '
     <table class="table" bordered="1">
     <tr>
         <th>ID</th>
         <th>Earning Poid</th>
         <th>Earning Code</th>
         <th>Earning Desc</th>
         <th>Earning Country</th>
         <th>Earning Qty</th>
         <th>Earning Price</th>
         <th>Earning Subtotal</th>
         <th>Earning Refund</th>
         <th>Earning Date</th>
         <th>Earning Time</th>
     <tr>
    ';

// Fetch Records From Database
    $export_sql = "SELECT * FROM stockist_earning WHERE e_id = 'S1116'";
    $export_sql_qry = mysqli_query($connect, $export_sql);

      foreach ($export_sql_qry as $data) {
    
        $output .='
            <tr>
                <td>'.$data['e_id'].'</td>
                <td>'.$data['e_poid'].'</td>
                <td>'.$data['e_code'].'</td>
                <td>'.$data['e_desc'].'</td>
                <td>'.$data['e_country'].'</td>
                <td>'.$data['e_qty'].'</td>
                <td>'.$data['e_price'].'</td>
                <td>'.$data['e_subtotal'].'</td>
                <td>'.$data['e_refund'].'</td>
                <td>'.$data['e_date'].'</td>
                <td>'.$data['e_time'].'</td>
            </tr>
            ';
        }
        $output .= '</table>';
        // Header for  Download
        // if (! headers_sent()) {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=REFUND-REPORT.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        // }
        // Render excel data file
        echo $output;
        // ob_end_flush();
        exit;

    // // Column Name
    // $output = '
    // <table class="table" bordered="1">
    // <tr>
    //     <th>Poid</th>
    //     <th>Percentage Code</th>
    //     <th>Percentage Amount</th>
    //     <th>Percentage Description</th>
    //     <th>Percentage Time</th>
    //     <th>Percentage Date</th>
    //     <th>Percentage Pack</th>
    //     <th>Percentage Full</th>
    //     <th>Percentage Percentage</th>
    // <tr>
    // ';

    // // Fetch Records From Database
    // $export_sql = "SELECT * FROM stockist_percentage WHERE p_code = 'S1123'";
    // $export_sql_qry = mysqli_query($connect, $export_sql);

    //   foreach ($export_sql_qry as $data) {

    //     $poid_new = $data['p_poid'];

    //     $sum_generate = mysqli_query($connect, "SELECT SUM(ol_php) AS sum_poid FROM upti_order_list WHERE ol_poid = '$poid_new'");
    //     $sum_fetch = mysqli_fetch_array($sum_generate);

    //     $full = $sum_fetch['sum_poid'];
    //     $percentage = $full * 0.05;

    //     $output .='
    //         <tr>
    //             <td>'.$data['p_poid'].'</td>
    //             <td>'.$data['p_code'].'</td>
    //             <td>'.$data['p_amount'].'</td>
    //             <td>'.$data['p_desc'].'</td>
    //             <td>'.$data['p_time'].'</td>
    //             <td>'.$data['p_date'].'</td>
    //             <td>'.$data['p_pack'].'</td>
    //             <td>'.$full.'</td>
    //             <td>'.$percentage.'</td>
    //         </tr>
    //         ';
    //     }
    //     $output .= '</table>';
    //     // Header for  Download
    //     // if (! headers_sent()) {
    //     header("Content-Type: application/xls");
    //     header("Content-Disposition: attachment; filename=REFUND-REPORT.xls");
    //     header("Pragma: no-cache");
    //     header("Expires: 0");
    //     // }
    //     // Render excel data file
    //     echo $output;
    //     // ob_end_flush();
    //     exit;
    
    
    
    
    
    
    
    
    
    
    
    
    
    // $output = '
    // <table class="table" bordered="1">
    // <tr>
    //     <th>Item Code</th>
    //     <th>Item Description</th>
    //     <th>Points</th>
    //     <th>Status</th>
    // <tr>
    // ';

    // // Fetch Records From Database
    // $export_sql = "SELECT * FROM upti_package";
    // $export_sql_qry = mysqli_query($connect, $export_sql);

    //   foreach ($export_sql_qry as $data) {

    //     $output .='
    //         <tr>
    //             <td>'.$data['package_code'].'</td>
    //             <td>'.$data['package_desc'].'</td>
    //             <td>'.$data['package_points'].'</td>
    //             <td>'.$data['package_status'].'</td>
    //         </tr>
    //         ';
    //     }
    //     $output .= '</table>';
    //     // Header for  Download
    //     // if (! headers_sent()) {
    //     header("Content-Type: application/xls");
    //     header("Content-Disposition: attachment; filename=ITEMS.xls");
    //     header("Pragma: no-cache");
    //     header("Expires: 0");
    //     // }
    //     // Render excel data file
    //     echo $output;
    //     // ob_end_flush();
    //     exit;