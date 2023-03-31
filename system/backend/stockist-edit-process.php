<?php
    include '../dbms/conn.php';

    $id = $_GET['id'];

    if (isset($_POST['stockist'])) {

        $reseller = $_POST['reseller'];
        $country = $_POST['country'];
        $state = $_POST['state'];

        if ($reseller == '' || $state == '' || $country == '') {
            echo "<script>alert('All fields are required');window.location.href='../stock-branch.php';</script>";
        } else {
            $insert_stockist = "UPDATE stockist SET stockist_role = '$state', stockist_code = '$reseller', stockist_country = '$country' WHERE id = '$id'";
            $insert_stockist_qry = mysqli_query($connect, $insert_stockist);

            echo "<script>alert('Data has been updated successfully');window.location.href='../stock-branch.php';</script>";
        }

    }
?>