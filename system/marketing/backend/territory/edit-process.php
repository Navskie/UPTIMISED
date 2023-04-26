<?php
    include '../../../dbms/conn.php';

    $id = $_GET['id'];

    if (isset($_POST['editbansa'])) {

        $territory = $_POST['territory'];

        $epayment_process = "UPDATE upti_territory SET territory_name = '$territory' WHERE id = '$id'";
        $epayment_process_qry = mysqli_query($connect, $epayment_process);

        echo "<script>alert('Data has been Updated successfully.');window.location.href = '../../territory';</script>";
    }
?>