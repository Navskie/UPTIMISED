<?php 
  include 'include/db.php';

  $qdl2 = "SELECT * FROM upti_order_list INNER JOIN  upti_transaction ON ol_poid = trans_poid WHERE ol_seller = ''";
  $delivered_poid = mysqli_query($connect, $qdl2);

  foreach ($delivered_poid as $delivered) {
    $date = $delivered['trans_date'];
    $year = strtotime($date);
    $newyear = date('Y', $year);
    $poid = $delivered['trans_poid'];

    if ($newyear == '2023') {
      $sql = "SELECT * FROM upti_activities WHERE activities_caption = 'Order Delivered' AND activities_poid = '$poid'";
      $act_sql = mysqli_query($connect, $sql);

      if (mysqli_num_rows($act_sql) < 1) {
        echo $date;
        echo ' = ';
        echo $poid;
        echo '<br>';
      }
    }
    
  }
?>