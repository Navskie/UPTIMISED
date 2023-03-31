<?php include 'include/header.php' ?>

<?php
  session_start();

  $id = $_GET['id'];

  $get_name = mysqli_query($connect, "SELECT * FROM haven_name WHERE hh_code = '$id'");
  $get_name_fetch = mysqli_fetch_array($get_name);

?>
<br><br><br>
<div class="row">
  <div class="col-6">
    <div class="card" style="padding: 60px 40px">
      <h1>Hi <b><?php echo $get_name_fetch['pangalan'] ?></b>,</h1>
      <br><br>
      <h2>Your booking is now confirmed! For reference, your booking number is <b><?php echo $id ?></b></h2>
      <br><br>
      <h5>Hidden Haven Villa Resort</h5>
    </div>
  </div>
  <div class="col-6">
    <div class="card" style="padding: 60px 40px">
      <br><br><br>
      <h1 class="text-center" style="font-size: 40px"><b><?php echo $id ?></b></h1>
      <br><br><br>
    </div>
  </div>
</div>
<?php
  unset($_SESSION['poid']);
  $_SESSION['poid'] = '';
  unset($_SESSION['guest']);
  $_SESSION['guest'] = '';
?>
<?php include 'include/footer.php' ?>