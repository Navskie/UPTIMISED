<?php include 'include/header.php'; ?>
<?php include 'include/preloader.php'; ?>
<?php include 'include/navbar.php'; ?>
<?php include 'include/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
                    <!-- Inquiries -->

        <div class="row">
          <?php

            $get_total_wallet = mysqli_query($connect, "SELECT * FROM stockist_wallet");

            foreach ($get_total_wallet as $wallet) {

              $w_name = $wallet['w_name'];
              $w_earning = $wallet['w_earning'];

          ?>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                <div class="inner">
                    
                    <h3>
                        <?php 
                          echo number_format($w_earning);
                        ?>
                    </h3>

                    <p>NAME : <?php echo $w_name ?></p>
                </div>
                <div class="icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                
                </div>
            </div>
          <?php 
            }
          ?>
        </div>

        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- START HERE -->
    

  </div>

<?php include 'include/footer.php'; ?>