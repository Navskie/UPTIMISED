<?php
    include '../../../dbms/conn.php';

    $id = $_GET['id'];

    if (isset($_POST['editbansa'])) {

      $state = $_POST['state'];
      $country = $_POST['country'];
      $territory = $_POST['territory'];

      $get_stockist = mysqli_query($connect, "SELECT * FROM stockist WHERE stockist_country = '$country' AND stockist_role = '$territory'");
      $get_stockist_fetch = mysqli_fetch_array($get_stockist);

      $stockist = $get_stockist_fetch['stockist_code'];

      $epayment_process = "UPDATE upti_state SET state_name = '$state', state_country = '$country', state_territory = '$territory', state_stockist = '$stockist' WHERE id = '$id'";
      $epayment_process_qry = mysqli_query($connect, $epayment_process);

      echo "<script>alert('Data has been Updated successfully.');window.location.href = '../../state.php';</script>";
    }
?>