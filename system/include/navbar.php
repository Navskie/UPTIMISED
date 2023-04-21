<?php
  if ($_SESSION['role'] == 'UPTIMAIN') {
    require_once 'navbar-list/admin.php';
  } elseif ($_SESSION['role'] == 'MARKETING') {
    require_once 'navbar-list/marketing.php';
  } elseif ($_SESSION['role'] == 'HR') {

  } elseif ($_SESSION['role'] == 'ACCOUNTING') {

  } elseif ($_SESSION['role'] == 'IT') {

  } elseif ($_SESSION['role'] == 'SUPPORT') {

  } elseif ($_SESSION['role'] == 'STOCKIST') {

  } elseif ($_SESSION['role'] == 'LOGISTIC') {

  } elseif ($_SESSION['role'] == 'HR') {

  }
?>