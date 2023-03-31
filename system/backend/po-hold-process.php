<?php

    include '../dbms/conn.php';

    $date = date('m-d-Y');
    $time = date('h:m:i');

    $id = $_GET['id'];

    $delete = "UPDATE stockist_request SET req_status = 'Hold', ref_checked = '$date' WHERE req_reference = '$id'";
    $delete_qry = mysqli_query($connect, $delete);

    $remarks = 'Purchase Order Number '.$id. ' has been Replace';

    $remarks_hold = "INSERT INTO stockist_replacement (ref_id, rep_date, rep_time, rep_remarks, ref_status) VALUES ('$id', '$date', '$time', '$remarks', 'On going')";
    $remarks_hold_qry = mysqli_query($connect, $remarks_hold);

    echo "<script>window.location.href='../stockist-orders.php';</script>";

?>