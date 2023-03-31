<?php

    session_start();
    include '../dbms/conn.php';
    include '../function.php';

    $id = $_GET['id'];

    $order_list_sql = mysqli_query($connect, "SELECT * FROM upti_order_list WHERE id = '$id'");
    $order_fetch = mysqli_fetch_array($order_list_sql);

    $ol_php = $order_fetch['ol_php'];
    $ol_price = $order_fetch['ol_price'];

    if (isset($_POST['test'])) {
      $qty = $_POST['qty'];

      $php = $ol_php * $qty;
      $price = $ol_price * $qty;

      $delete_ex = mysqli_query($connect, "UPDATE upti_order_list SET ol_qty = '$qty', ol_php = '$php', ol_subtotal = '$price' WHERE id = '$id'");

      flash("success", "Quantity has been updated");
      header('location: ../order-list.php');
    }

?>