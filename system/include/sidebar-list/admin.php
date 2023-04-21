<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary"> 
    <!-- Brand Logo -->
    <a href="#" class="brand-link"> 
      <img src="images/navbar.png" class="brand-image img-circle">
      <span class="brand-text font-weight-700">UPTIMISED PH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background: #b0e0e6 !important;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./images/icon/274966106_640652090373107_513539919171817442_n.ico" class="" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $get_info_fetch['users_name'] ?></a>
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
            <a href="osr-sales.php" class="nav-link">
              <i class="nav-icon uil uil-panel-add"></i>
              <p>
                OSR EOD
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="s_ph.php" class="nav-link">
              <i class="nav-icon uil uil-globe"></i>
              <p>
                Stocks
              </p>
            </a>
          </li>
          <li class="nav-header">Manage Accounts</li>
          <li class="nav-item"> 
            <a href="stock-branch.php" class="nav-link">
              <i class="nav-icon uil uil-building"></i>
              <p>
                Stockist Branch 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admin-branch.php" class="nav-link">
              <i class="nav-icon uil uil-user-check"></i>
              <p>
                CSR Branch
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="main-employee.php" class="nav-link">
              <i class="nav-icon uil uil-users-alt"></i>
              <p>
                Employee
              </p>
            </a>
          </li>
          <li class="nav-item"> 
            <a href="Osrlist.php" class="nav-link">
              <i class="nav-icon uil uil-user-check"></i>
              <p>
                OSR Account 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reseller-list.php" class="nav-link">
              <i class="nav-icon uil uil-house-user"></i>
              <p>
                Reseller
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reseller-main-list.php" class="nav-link">
              <i class="nav-icon uil uil-user-arrows"></i>
              <p>
                Main Reseller
              </p>
            </a>
          </li>

          <li class="nav-header">Products</li>
          <li class="nav-item">
            <a href="warehouse.php" class="nav-link">
              <i class="nav-icon uil uil-university"></i>
              <p>
                Warehouse
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="critical-ph.php" class="nav-link">
              <i class="nav-icon uil uil-exclamation-triangle"></i>
              <p>
                Stocks Critical Level
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="purchase-order.php" class="nav-link">
              <i class="nav-icon uil uil-file-landscape"></i>
              <p>
                Supplier Purchase Order
              </p> 
            </a>
          </li>
          <li class="nav-item">
            <a href="ph-po.php" class="nav-link">
              <i class="nav-icon uil uil-file-graph"></i>
              <p>
                PH Purchase Order
              </p>
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
              <i class="nav-icon uil uil-shopping-cart-alt"></i>
              <p>
                Manage Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin-all-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-pending-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-in-transit-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>In Transit Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-on-process-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>On Process</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-cancel-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cancel Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-delivered-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivered Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin-rts-order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RTS Orders</p>
                </a>
              </li>
            </ul>
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
              <i class="nav-icon uil uil-wallet"></i>
              <p>
                EWallet Request
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin-wallet-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>E-Wallet Request List</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin-wallet-list2.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Withdrawal History</p>
                </a>
              </li>
            </ul>
          </li>          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>