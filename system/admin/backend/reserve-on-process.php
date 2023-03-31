<?php

  include '../database/dbconn.php';

  $id = $_GET['id'];

  $update_book = mysqli_query($connect, "UPDATE haven_booking SET booking_status = 'On Process' WHERE booking_ref = '$id'");

  header('Location: ../reservation.php');
  
?>