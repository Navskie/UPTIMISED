<?php

    session_start();
    include '../dbms/conn.php';
    include '../function.php';

    $id = $_GET['id'];

    $order_list_sql = mysqli_query($connect, "SELECT * FROM upti_order_list WHERE id = '$id'");
    $order_fetch = mysqli_fetch_array($order_list_sql);

    $ol_code = $order_fetch['ol_code'];
    $ol_country = $order_fetch['ol_country'];

    if (isset($_POST['test'])) {
      $qty = $_POST['qty'];

      $get_price = mysqli_query($connect, "SELECT * FROM upti_country WHERE country_code = '$ol_code' AND country_name = '$ol_country'");
      $get_price_fetch = mysqli_fetch_array($get_price);

      $php = $get_price_fetch['country_php'] * $qty;
      $price = $get_price_fetch['country_price'] * $qty;

      $delete_ex = mysqli_query($connect, "UPDATE upti_order_list SET ol_qty = '$qty', ol_php = '$php', ol_subtotal = '$price' WHERE id = '$id'");

      flash("success", "Quantity has been updated");
      header('location: ../order-list.php');
    }

?>