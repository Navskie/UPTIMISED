<?php 
  $_SESSION['status'] = 'valid';
  $_SESSION['uid'] = $check_account_fetch['users_id'];
  $_SESSION['code'] = $check_account_fetch['users_code'];
  $_SESSION['role'] = $check_account_fetch['users_role'];
?>