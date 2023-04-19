<?php

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

?>