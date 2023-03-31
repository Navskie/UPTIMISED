<?php

  include '../include/db.php';

  session_start();

  $id = $_GET['id'];
  $HHcode = $_GET['HHcode'];

  $update_date = "DELETE FROM haven_date WHERE book_poid = '$id'";
  $sql = mysqli_query($connect, $update_date);

  $update_date2 = "DELETE FROM haven_details WHERE details_ref = '$id'";
  $sql2 = mysqli_query($connect, $update_date2);

  $update_date3 = "DELETE FROM haven_name WHERE hh_code = '$id'";
  $sql3 = mysqli_query($connect, $update_date3);

  unset($_SESSION['date1banene']);
  unset($_SESSION['date2banene']);
  unset($_SESSION['poid']);
  unset($_SESSION['guest']);
  unset($_SESSION['diff']);
  $_SESSION['date1banene'] = '';
  $_SESSION['date2banene'] = '';
  $_SESSION['poid'] = '';
  $_SESSION['guest'] = '';

  header('Location: booking.php?HHCode='.$HHcode.'');
  
?>