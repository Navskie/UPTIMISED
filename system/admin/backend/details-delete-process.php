<?php

  include '../database/dbconn.php';

  $id = $_GET['id'];

  $update_book = mysqli_query($connect, "UPDATE haven_product SET product_status = 'Trash', product_updated = '$timedate' WHERE product_code = '$id'");

  header('Location: ../admin-details.php');
  
?>