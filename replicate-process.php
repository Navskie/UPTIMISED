<?php
  session_start();

  $id = $_GET['id'];

  $_SESSION['replicate_code'] = $id;

  header('location: https://upticorporationph.com/shop.php');

?>