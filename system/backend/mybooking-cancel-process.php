<?php

  include '../dbms/conn.php';

  $id = $_GET['id'];

  $update_book = mysqli_query($connect, "UPDATE haven_booking SET booking_status = 'Canceled' WHERE booking_ref = '$id'");

  $update_book = mysqli_query($connect, "UPDATE haven_date SET book_remarks = '' WHERE book_poid = '$id'");

  header('Location: ../mybooking.php');
  
?>