<?php
    include '../dbms/conn.php';

    $id = $_GET['id'];

    $code = $_GET['code'];

    $delete_info = "DELETE FROM upti_pack_sett WHERE id = '$id'";
    $delete_qry = mysqli_query($connect, $delete_info);

    echo "<script>alert('Data has been Deleted successfully.');window.location.href = '../item-package-setting.php?id=".$code."';</script>";
?>