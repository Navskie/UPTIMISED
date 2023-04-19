<?php

  

  // Reseller Earnings
  $reseller_wallet_sql = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller'");
  $reseller_wallet_fetch = mysqli_fetch_array($reseller_wallet_sql);

  $reseller_wallet = $reseller_wallet_fetch['reseller_earning'] + $earning;

  $wallet_update = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$reseller_wallet' WHERE reseller_code = '$reseller'");

  $wallet_remarks = 'You Received 40% Comission Product Worth of '.$earning.' ['.$country.']';

  $earn_history = "INSERT INTO upti_earning (earning_code, earning_poid, earning_earnings, earning_tax, earning_remarks, earning_status, earning_name) VALUES ('$reseller', '$poid', '$earning', '$tax', '$wallet_remarks', 'Sales', '$reseller')";
  $earn_history_sql = mysqli_query($connect, $earn_history);

?>