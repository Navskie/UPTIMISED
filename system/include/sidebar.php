<style>
    .siderbar {
        background: #b0e0e6 !important;
    }
</style>
<?php
  // session_start();
 
  $images = $get_info_fetch['users_img'];

  if ($_SESSION['role'] == 'UPTIMAIN') {
    require_once 'sidebar-list/admin.php';
  } elseif ($_SESSION['role'] == 'MARKETING') {
    require_once 'sidebar-list/marketing.php';
  } elseif ($_SESSION['role'] == 'HR') {

  } elseif ($_SESSION['role'] == 'ACCOUNTING') {

  } elseif ($_SESSION['role'] == 'IT') {

  } elseif ($_SESSION['role'] == 'SUPPORT') {

  } elseif ($_SESSION['role'] == 'STOCKIST') {

  } elseif ($_SESSION['role'] == 'LOGISTIC') {

  } elseif ($_SESSION['role'] == 'HR') {

  }
?>
