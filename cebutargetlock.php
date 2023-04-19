<?php

    include 'include/db.php';
    
    session_start();

    // Column Name
    $output = '
    <table class="table" bordered="1">
    <tr>
        <th>Poid</th>
        <th>Date</th>
    <tr>
    ';

    // Fetch Records From Database
    $export_sql = "SELECT earning_poid, earning_date FROM upti_earning WHERE earning_code = 'S226'";
    $export_sql_qry = mysqli_query($connect, $export_sql);

    foreach ($export_sql_qry as $data) {

      $output .='
          <tr>
              <td>'.$data['earning_poid'].'</td>
              <td>'.$data['earning_date'].'</td>
          </tr>
          ';
      }
      $output .= '</table>';
      // Header for  Download
      // if (! headers_sent()) {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=targetlock-cebu.xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      // }
      // Render excel data file
      echo $output;
      // ob_end_flush();
      exit;