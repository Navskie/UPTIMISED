<?php
    include '../../../dbms/conn.php';

    $id = $_GET['id'];

    if (isset($_POST['item'])) {

        $code = $_POST['code'];
        $desc = $_POST['desc'];
        $points = $_POST['points'];
        $stats = $_POST['stats'];

        $check_update = "SELECT * FROM upti_items WHERE id = '$id'";
        $check_qyr = mysqli_query($connect, $check_update);
        $check_fetch_array = mysqli_fetch_array($check_qyr);

        $item_code = $check_fetch_array['items_code'];

        if ($code == $item_code) {
            if ($code == '') {
                echo "<script>alert('Item Code and Category is Required.');window.location.href = '../../single';</script>";
            } else {
                $update_item = "UPDATE upti_items SET items_status = '$stats', items_code = '$code', items_desc = '$desc', items_points = '$points' WHERE id = '$id'";
                $update_item_qry = mysqli_query($connect, $update_item);
                echo "<script>alert('Data has been Updated successfully.');window.location.href = '../../single';</script>";
            }
        } else {
            $check_item = "SELECT * FROM upti_items WHERE items_code = '$code'";
            $check_item_qry = mysqli_query($connect, $check_item);
            $check_item_num = mysqli_num_rows($check_item_qry);

            if ($check_item_num == 0) {
                if ($code == '') {
                    echo "<script>alert('Item Code and Category is Required.');window.location.href = '../../single';</script>";
                } else {
                    $update_item = "UPDATE upti_items SET items_status = '$stats', items_code = '$code', items_desc = '$desc', items_points = '$points' WHERE id = '$id'";
                    $update_item_qry = mysqli_query($connect, $update_item);
                    echo "<script>alert('Data has been Updated successfully.');window.location.href = '../../single';</script>";
                }
            } else {
                echo "<script>alert('Duplicate Item code is not allowed.');window.location.href = '../../single';</script>";
            }
        }
    }
?>