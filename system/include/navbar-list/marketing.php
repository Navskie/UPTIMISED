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
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $get_info_fetch['users_name'] ?>&nbsp;&nbsp;
          <img class="img-responsive" src="../images/icon/274966106_640652090373107_513539919171817442_n.ico" width="30" style="border-radius: 25px; border: 1px solid #aeaeae;"/>
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
    </ul>
</nav>