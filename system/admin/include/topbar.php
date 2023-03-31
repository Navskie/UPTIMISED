<?php 
  $_position = $_SESSION['role'];

  if ($_position == 'HAVEN CSR') {
?>
  <div class="pcoded-main-container">
  <div class="pcoded-wrapper">
      <nav class="pcoded-navbar">
      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
      <div class="pcoded-inner-navbar main-menu">

          <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Buttons</div>
          <ul class="pcoded-item pcoded-left-item">
              <li class=" ">
                  <a href="index.php">
                      <span class="pcoded-micon"><i class="ti-view-grid"></i></span>
                      <span class="pcoded-mtext" data-i18n="nav.widget.main">Dashboard</span>
                      <!-- <span class="pcoded-badge label label-danger">100+</span> -->
                      <span class="pcoded-mcaret"></span>
                  </a>
              </li>
              <li class="pcoded-hasmenu">
                  <a href="javascript:void(0)">
                      <span class="pcoded-micon"><i class="ti-home"></i></span>
                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Manage Reservation</span>
                      <span class="pcoded-mcaret"></span>
                  </a>
                  <ul class="pcoded-submenu">
                      <li class="">
                          <a href="reservation.php">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext" data-i18n="nav.dash.default">Ongoing/Process</span>
                              <span class="pcoded-mcaret"></span>
                          </a>
                      </li>
                      <li class=" ">
                          <a href="reservation-cancel.php">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext" data-i18n="nav.dash.ecommerce">Cancel</span>
                              <span class="pcoded-mcaret"></span>
                          </a>
                      </li>
                      <li class=" ">
                          <a href="reservation-success.php">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext" data-i18n="nav.dash.crm">Success</span>
                              <span class="pcoded-mcaret"></span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
      </div>
  </nav>
<?php
  } elseif ($_position == 'HAVEN ADMIN') {
?>
  <div class="pcoded-main-container">
  <div class="pcoded-wrapper">
      <nav class="pcoded-navbar">
      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
      <div class="pcoded-inner-navbar main-menu">

          <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Buttons</div>
          <ul class="pcoded-item pcoded-left-item">
              <li class=" ">
                  <a href="admin.php">
                      <span class="pcoded-micon"><i class="ti-view-grid"></i></span>
                      <span class="pcoded-mtext" data-i18n="nav.widget.main">Dashboard</span>
                      <!-- <span class="pcoded-badge label label-danger">100+</span> -->
                      <span class="pcoded-mcaret"></span>
                  </a>
              </li>
              <li class=" ">
                  <a href="booking.php">
                      <span class="pcoded-micon"><i class="ti-reload rotate-refresh"></i></span>
                      <span class="pcoded-mtext" data-i18n="nav.widget.main">Block</span>
                      <!-- <span class="pcoded-badge label label-danger">100+</span> -->
                      <span class="pcoded-mcaret"></span>
                  </a>
              </li>
              <li class="pcoded-hasmenu">
                  <a href="javascript:void(0)">
                      <span class="pcoded-micon"><i class="ti-home"></i></span>
                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Manage Haven</span>
                      <span class="pcoded-mcaret"></span>
                  </a>
                  <ul class="pcoded-submenu">
                      <li class=" ">
                          <a href="admin-details.php">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext" data-i18n="nav.dash.ecommerce">Details</span>
                              <span class="pcoded-mcaret"></span>
                          </a>
                      </li>
                      <li class=" ">
                          <a href="admin-trash.php">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext" data-i18n="nav.dash.ecommerce">Trash</span>
                              <span class="pcoded-mcaret"></span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
      </div>
  </nav>
<?php
  }
?>

  <div class="pcoded-content">
      <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">