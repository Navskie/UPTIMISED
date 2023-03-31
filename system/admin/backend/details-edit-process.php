<?php 
  include '../database/dbconn.php';

  $id = $_GET['id'];

  if (isset($_POST['details-edit'])) {
    $title = $_POST['title'];

    $desc = $_POST['desc'];
    $weekdays8 = $_POST['weekdays8'];
    $weekends8 = $_POST['weekends8'];
    $weekdays22 = $_POST['weekdays22'];
    $weekends22 = $_POST['weekends22'];
    // $status = $_POST['status'];

    if ($title == '' || $desc == '' || $weekdays8 == '' || $weekends8 == '' || $weekdays22 == '' || $weekends22 == '') {
      echo '<script>alert("All fields are required");window.location.href = "../admin-details.php";</script>';
    } else {
      $update_style = mysqli_query($connect, "UPDATE haven_product
      SET 
      product_title = '$title', product_desc = '$desc', weekday_eight = '$weekdays8', weekend_eight = '$weekends8', weekday_two = '$weekdays22', weekend_two = '$weekends22', product_updated = '$timedate'
      WHERE
      product_code = '$id'
      ");
      echo '<script>window.location.href = "../admin-details.php";</script>';
    }

  }
?>