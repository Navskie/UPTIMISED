<?php

    session_start();
    include '../dbms/conn.php';
    include '../function.php';

    $id = $_GET['id'];

    $get_ol = mysqli_query($connect, "SELECT * FROM upti_order_list WHERE id = '$id'");
    $ol_fetch = mysqli_fetch_array($get_ol);

    $ol_code = $ol_fetch['ol_code'];
    $ol_poid = $ol_fetch['ol_poid'];

    $transaction = mysqli_query($connect, "SELECT * FROM upti_transaction WHERE trans_poid = '$ol_poid'");
    $trans_fetch = mysqli_fetch_array($transaction);

    $csid = $trans_fetch['trans_csid'];

    $check_code = mysqli_query($connect, "SELECT * FROM upti_code WHERE code_name = '$ol_code'");
    $check_code_fetch = mysqli_fetch_array($check_code);

    $exc = $check_code_fetch['code_exclusive'];

    $delete_ex = mysqli_query($connect, "DELETE FROM upti_order_list WHERE ol_code = '$exc' AND ol_poid = '$ol_poid'");

    $delete = "DELETE FROM upti_order_list WHERE id = '$id'";
    $delete_qry = mysqli_query($connect, $delete);

    flash("warning", "Item has been removed successfully");
    header('location: ../osr-reseller.php');

?>