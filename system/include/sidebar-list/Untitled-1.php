<?php
    $myid = $_SESSION['uid'];
    $role = $_SESSION['role'];

    $get_country_sql = "SELECT * FROM upti_users WHERE users_id = '$myid'";
    $get_country_qry = mysqli_query($connect, $get_country_sql);
    $get_country_fetch = mysqli_fetch_array($get_country_qry);

    $employee = $get_country_fetch['users_employee'];

    if ($role == 'BRANCH') {
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown"> 
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <?php
            $notif_sum_sql = "SELECT COUNT(upti_transaction.id) AS notif FROM upti_remarks INNER JOIN upti_transaction ON upti_remarks.remark_poid = upti_transaction.trans_poid WHERE upti_transaction.trans_country = '$employee' AND upti_remarks.remark_csr = 'Unread'";
            $notif_sum_qry = mysqli_query($connect, $notif_sum_sql);
            $notif_sum_num = mysqli_num_rows($notif_sum_qry);
            $notif_sum_fetch = mysqli_fetch_array($notif_sum_qry);

            $note = $notif_sum_fetch['notif'];

            if ($note == 0) {
          ?>
            <span class="badge badge-danger navbar-badge"></span>
          <?php } else { ?>
            <span class="badge badge-danger navbar-badge"><?php echo $note ?></span>
          <?php } ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <div class="dropdown-divider"></div>
          <?php
            
            $get_notif = "SELECT upti_transaction.trans_poid, upti_transaction.id FROM upti_remarks INNER JOIN upti_transaction ON upti_remarks.remark_poid = upti_transaction.trans_poid WHERE upti_transaction.trans_country = '$employee' AND upti_remarks.remark_csr = 'Unread'";
            $get_notif_sql = mysqli_query($connect, $get_notif);
            while ($row = mysqli_fetch_array($get_notif_sql)) {
              
          ?>

          <a href="./read-poid-list.php?id=<?php echo $row['id']; ?>" class="dropdown-item">
            <i class="fas fa-comment mr-2 text-primary"></i> <b><?php echo $row['trans_poid']; ?></b>
            <span class="float-right text-muted text-sm">New Remarks</span>
          </a>
          <?php } ?>
        </div>
      </li>
      <?php
        if ($role == 'UPTIMAIN' || $role == 'UPTIOSR' || $role == 'SPECIAL' || $role == 'IT/Sr Programmer' || $role == 'BRANCH' || $role == 'UPTIACCOUNTING' || $role == 'ADS') {
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="main-information.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Information
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } elseif ($role == 'UPTICREATIVES' || $role == 'UPTICSR' || $role == 'ADS') { ?>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } elseif ($role == 'UPTIRESELLER') { ?>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <?php if ($get_info_fetch['users_img'] != '') { ?>
          <img class="img-responsive" src="./images/profile/<?php echo $get_info_fetch['users_img'] ?>" width="30" height="30" style="border-radius: 50%; border: 2px solid #aeaeae; padding: 1px"/>
          <?php } else { ?>
            <img class="img-responsive" src="./images/profile/default.png" width="30" height="30" style="border-radius: 50%; border: 2px solid #aeaeae; padding: 1px"/>
          <?php } ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="information.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Information
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } ?>
    </ul>
  </nav>
  <!-- /.navbar -->

  <?php } elseif ($role == 'UPTIRESELLER') { ?>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <?php
            $notifcode = $_SESSION['code'];
            $notif_sum_sql = "SELECT COUNT(upti_transaction.id) AS notif FROM upti_remarks INNER JOIN upti_transaction ON upti_remarks.remark_poid = upti_transaction.trans_poid WHERE upti_transaction.trans_seller = '$notifcode' AND upti_remarks.remark_reseller = 'Unread'";
            $notif_sum_qry = mysqli_query($connect, $notif_sum_sql);
            $notif_sum_num = mysqli_num_rows($notif_sum_qry);
            $notif_sum_fetch = mysqli_fetch_array($notif_sum_qry);

            $note = $notif_sum_fetch['notif'];

            if ($note == 0) {
          ?>
            <span class="badge badge-danger navbar-badge"></span>
          <?php } else { ?>
            <span class="badge badge-danger navbar-badge"><?php echo $note ?></span>
          <?php } ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <div class="dropdown-divider"></div>
          <?php
            
             $get_notif = "SELECT DISTINCT upti_transaction.trans_poid, upti_transaction.id FROM upti_remarks INNER JOIN upti_transaction ON upti_remarks.remark_poid = upti_transaction.trans_poid WHERE upti_transaction.trans_seller = '$notifcode' AND upti_remarks.remark_reseller = 'Unread'";
            $get_notif_sql = mysqli_query($connect, $get_notif);
            while ($row = mysqli_fetch_array($get_notif_sql)) {
          ?>
          <a href="./read-poid-list.php?id=<?php echo $row['id']; ?>" class="dropdown-item">
            <i class="fas fa-comment mr-2 text-primary"></i> <b><?php echo $row['trans_poid']; ?></b>
            <span class="float-right text-muted text-sm">New Remarks</span>
          </a>
          <?php } ?>
        </div>
      </li>
      <?php
        if ($role == 'UPTIMAIN' || $role == 'UPTIOSR' || $role == 'SPECIAL' || $role == 'IT/Sr Programmer' || $role == 'BRANCH' || $role == 'UPTIACCOUNTING') {
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="main-information.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Information
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } elseif ($role == 'UPTICREATIVES' || $role == 'UPTICSR') { ?>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } elseif ($role == 'UPTIRESELLER') { ?>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <?php if ($get_info_fetch['users_img'] != '') { ?>
          <img class="img-responsive" src="./images/profile/<?php echo $get_info_fetch['users_img'] ?>" width="30" height="30" style="border-radius: 50%; border: 2px solid #aeaeae; padding: 1px"/>
          <?php } else { ?>
            <img class="img-responsive" src="./images/profile/default.png" width="30" height="30" style="border-radius: 50%; border: 2px solid #aeaeae; padding: 1px"/>
          <?php } ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="information.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Information
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } ?>
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php } else { ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <?php
        if ($role == 'UPTIHR' || $role == 'MARKETING' || $role == 'UPTIMAIN' || $role == 'UPTIOSR' || $role == 'SPECIAL' || $role == 'IT/Sr Programmer' || $role == 'BRANCH' || $role == 'UPTIACCOUNTING') {
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="main-information.php" class="dropdown-item">
            
            <i class="fas fa-user mr-2"></i> Information
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../../logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } elseif ($role == 'UPTICREATIVES' || $role == 'UPTICSR' || $role == 'LOGISTIC' || $role == 'DHL' || $role == 'ADS') { ?>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="../../logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } elseif ($role == 'UPTIRESELLER') { ?>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <?php if ($get_info_fetch['users_img'] != '') { ?>
          <img class="img-responsive" src="./images/profile/<?php echo $get_info_fetch['users_img'] ?>" width="30" height="30" style="border-radius: 50%; border: 2px solid #aeaeae; padding: 1px"/>
          <?php } else { ?>
            <img class="img-responsive" src="./images/profile/default.png" width="30" height="30" style="border-radius: 50%; border: 2px solid #aeaeae; padding: 1px"/>
          <?php } ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account Settings</span>
          <div class="dropdown-divider"></div>
          <a href="information.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Information
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../hiddenhaven/index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hidden Haven
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../index.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Uptimised Site
            <!-- <span class="float-right  text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="../../logout.php" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-sm">Logout</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <?php } ?>
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php } ?>