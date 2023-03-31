<?php

    include '../dbms/conn.php';

    $date = date('m-d-Y');
    $time = date('h:m:i');

    $id = $_GET['id'];

    $delete = "UPDATE stockist_replacement SET ref_status = 'Claimed' WHERE ref_id = '$id'";
    $delete_qry = mysqli_query($connect, $delete);

    $get_items_po = mysqli_query($connect, "SELECT * FROM stockist_po INNER JOIN stockist_request ON req_reference = spo_ref WHERE spo_ref = '$id'");
    foreach ($get_items_po as $data) {
        // echo $data['spo_ref'];
        $item_code = $data['spo_item_code'];
        $item_qty = $data['spo_item_qty'];
        $req_from  = $data['req_from'];
        // echo '<br>';

        if ($req_from == 'PHILIPPINES') {
            $stockist_stock = mysqli_query($connect, "SELECT * FROM stockist_inventory WHERE si_item_country = '$req_from' AND si_item_code = '$item_code' AND si_item_state = 'ALL'");
            $stockist_stocks_fetch = mysqli_fetch_array($stockist_stock);

            $remain_stocks = $stockist_stocks_fetch['si_item_stock'];
            // echo '<br>';
            $new_stocks = $remain_stocks + $item_qty;
            // echo '<br>';

            $stockist_stock_update = mysqli_query($connect, "UPDATE stockist_inventory SET si_item_stock = '$new_stocks' WHERE si_item_country = '$req_from' AND si_item_code = '$item_code' AND si_item_state = 'ALL'");
        } else { 
            $warehouse_stocks = mysqli_query($connect, "SELECT * FROM stockist_warehouse WHERE warehouse_code = '$item_code' AND warehouse_country = '$req_from'");
            $warehouse_stocks_fetch = mysqli_fetch_array($warehouse_stocks);

            $remain_stocks = $warehouse_stocks_fetch['warehouse_stocks'];

            $new_stocks = $remain_stocks + $item_qty;

            $warehouse_stocks_update = mysqli_query($connect, "UPDATE stockist_warehouse SET warehouse_stocks = '$new_stocks' WHERE warehouse_code = '$item_code' AND warehouse_country = '$req_from'");
        }
    }

    $update_status = mysqli_query($connect, "UPDATE stockist_request SET req_status = 'In Transit' WHERE req_reference = '$id'");

    echo "<script>window.location.href='../accounting-replacement.php';</script>";

?>