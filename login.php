<html class="no-js" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Uptimised Corporation</title>
<meta name="description" content="description">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="assets/images/274966106_640652090373107_513539919171817442_n.ico">
<!-- Plugins CSS -->
<link rel="stylesheet" href="assets/css/plugins.css">
<!-- Bootstap CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<!-- Main Style CSS -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/responsive.css">
<link rel="stylesheet" href="assets/css/custom.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Toastr -->
<link rel="stylesheet" href="toastr/toastr.min.css">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<?php
  // session_start();
  include 'include/db.php';
  include 'function.php'; 
  
?>
<?php
    session_start();
      if ($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
        $_SESSION['status'] = 'invalid';
      }
    
      if ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIMAIN') {
        header('Location: system/uptimain.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIMAINS') {
        header('Location: system/uptimain.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIHR') {
        header('Location: system/uptimain.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIRESELLER') {
        header('Location: system/reseller.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIMANAGER') {
        header('Location: system/manager.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTILEADER') {
        header('Location: system/leader.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIOSR') {
        header('Location: system/osr.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTICREATIVES') { 
        header('Location: creatives.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTICSR') {
        header('Location: system/uptikier.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'SPECIAL') {
        header('Location: system/admin-reseller.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'UPTIACCOUNTING') {
        header('Location: system/accounting.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'IT/Sr Programmer') {
        header('Location: system/navskie.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'BRANCH') {
        header('Location: system/branch.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'ADS') {
        header('Location: system/ads.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'WEBSITE') {
        header('Location: system/cs-onprocess-order.php');
      }
      elseif ($_SESSION['status'] == 'valid' AND $_SESSION['role'] == 'Customer') {
        header('Location: profile.php');
      }
?>
<!--Body Content-->
<div id="page-content">     
    
    <div class="katawan">
      <div class="contain">
        <div class="forms">
          <div class="form login">
            <span class="title">Uptimised Corporations</span>
            <form action="login-process.php" method="post">
              <div class="input-field">
                <input type="text" name="us" placeholder="Input your username" required autocomplete="off">
                <i class="uil uil-user icon"></i>
              </div>
              <div class="input-field">
                <input type="password" name="pw" class="password" placeholder="Input your password" required autocomplete="off">
                <i class="uil uil-lock icon"></i>
                <i class="uil uil-eye-slash showHidePw"></i>
              </div>

              <div class="checkbox-text">
                <div class="checkbox-content">
                  <!-- <input type="checkbox" name="" id="logCheck"> -->
                  <!-- <label for="logCheck" class="text" style="align-items: center;">Remember Me</label> -->
                </div>

                <a href="system/index.php" class="text">Forgot Password</a>
              </div>

              <div class="input-field button">
                <input type="submit" value="Sign In" name="sign-in">
              </div>
            </form>
            <div class="login-signup">
              <span class="text">Not a member? <br><br>
                <a href="#" class="text signup-link" style="padding: 14px 20px !important; background: #4070f4; color: #fff">Signup now</a>
              </span>
            </div>
          </div>

          <!-- Register -->
          <div class="form signup">
            <span class="title">Be ones of us</span>
            <form action="login-process.php" method="post">
              <div class="input-field">
                <input type="text" placeholder="Username" name="us" required autocomplete="off">
                <i class="uil uil-user icon"></i>
              </div>              
              <div class="row">
                <div class="col-6">
                  <div class="input-field">
                    <input type="password" class="password" name="pw" placeholder="password" required autocomplete="off">
                    <i class="uil uil-lock icon"></i>
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-field">
                    <input type="password" class="password" name="pw2" placeholder="Retype password" required autocomplete="off">
                    <i class="uil uil-lock icon"></i>
                    <i class="uil uil-eye-slash showHidePw"></i>
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-field">
                    <input type="text" placeholder="First Name" name="fn" required autocomplete="off">
                    <i class="uil uil-user-plus"></i>
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-field">
                    <input type="text" placeholder="Last Name" name="ln" required autocomplete="off">
                    <i class="uil uil-user-plus"></i>
                  </div>
                </div>
              </div>
              <div class="input-field">
                <input type="email" placeholder="Email Address" name="ea" required autocomplete="off">
                <i class="uil uil-envelope-shield"></i>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="input-field">
                    <input type="text" placeholder="Mobile Number" name="mn" required autocomplete="off">
                    <i class="uil uil-phone"></i>
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-field">
                    <input type="date" placeholder="Birthday" name="bday" required autocomplete="off">
                    <i class="uil uil-gift"></i>
                  </div>
                </div>
              </div>

              <div class="input-field button">
                <input type="submit" value="Sign Up" name="signup">
              </div>
            </form>
            <div class="login-signup">
              <span class="text">
                <a href="#" class="text login-link">Signin now</a>
              </span>
            </div>
          </div>
          
        </div>
      </div>
    </div>

</div>
<script src="assets/js/custom.js"></script>
<!--End Body Content-->
    
<script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
<script src="assets/js/vendor/jquery.cookie.js"></script>
<script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
<script src="assets/js/vendor/wow.min.js"></script>
<script src="assets/js/vendor/masonry.js" type="text/javascript"></script>
<!-- Including Javascript -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/lazysizes.js"></script>
<script src="assets/js/main.js"></script>
<!-- Photoswipe Gallery -->
<script src="assets/js/vendor/photoswipe.min.js"></script>
<script src="toastr/toastr.min.js"></script>
<script src="assets/js/vendor/photoswipe-ui-default.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    <?php if (isset($_SESSION['warn'])) { ?>

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr.error("<?php echo flash('warn'); ?>");

        <?php } ?>
  <?php if (isset($_SESSION['success'])) { ?>

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr.success("<?php echo flash('success'); ?>");

    <?php } ?>
</script>
</html>