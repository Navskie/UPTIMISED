<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary"> 
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../images/navbar.png" class="brand-image img-circle">
      <span class="brand-text font-weight-700">UPTIMISED PH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background: #b0e0e6 !important;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <b><?php echo $get_info_fetch['users_name'] ?></b>
        </div>
      </div>
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="uptimain.php" class="nav-link">
            <i class="nav-icon uil uil-dashboard"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="stock.php" class="nav-link">
              <i class="nav-icon uil uil-globe"></i>
              <p>
                Stocks
              </p>
            </a>
          </li>
          <li class="nav-header">Manage Items</li>
          <li class="nav-item">
            <a href="single.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Single Item</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="bundle.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Bundle Item</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="item-code.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Item Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="item-country-currency.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Country</p>
            </a>
          </li>

          <li class="nav-header">Customer Order</li>
          <li class="nav-item">
            <a href="search04062022.php" class="nav-link">
            <i class="nav-icon uil uil-search-alt"></i>
              <p>
                Search Poid
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon uil uil-panel-add"></i>
              <p>
                Generate Report
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin-sales-item.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Item</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-reseller.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reseller Sales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-osr-report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OSC Total Sales</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon uil uil-sliders-v-alt"></i>
              <p>
                Order Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="order-shipping.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Shipping Fee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="order-cash.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cash Payment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="order-epayment.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>E Payment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="order-bank.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bank Payment</p>
                </a>
              </li>
            </ul>
          </li>
        
          <li class="nav-item">
            <a href="ma-announcement.php" class="nav-link">
              <i class="nav-icon uil uil-trophy"></i>
              <p>
                Top Banner
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="accounting-inventory.php" class="nav-link">
              <i class="nav-icon uil uil-building"></i>
              <p>
                Inventory
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>