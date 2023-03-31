<?php
    include '../dbms/conn.php';
    
    $id = $_GET['id'];

    if (isset($_POST['check'])) {            

      $update_request = "UPDATE upti_osr_withdraw SET withdraw_status = 'Completed' WHERE id = '$id'";
      $update_request_qry = mysqli_query($connect, $update_request);

      echo "<script>alert('Withdraw has been approved successfully');window.location.href='../osc-request.php';</script>";

    }

?>