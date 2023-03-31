<!-- animation modal Dialogs start -->
<div class="md-modal md-effect-5" id="view-1<?php echo $data['details_ref'] ?>">
  <?php
    $code_ref = $data['details_ref'];

    $get_name = mysqli_query($connect, "SELECT * FROM haven_name WHERE hh_code = '$code_ref'");
    $get_name_fetch = mysqli_fetch_array($get_name);
  ?>
    <div class="md-content">
        <h3>Booking Information</h3>
        <div>
          <div class="row">
            <div class="col-12">
            <h2 class="text-center"><?php echo $data['details_ref'] ?></h2>
            <hr>
            </div>

            <div class="col-4">
              <label for="" style="font-weight: bold;"><b>Name</b></label>
              <div class="form-group">
              <?php echo $myName ?>
              </div>
            </div>
            <div class="col-4">
              <label for="" style="font-weight: bold;"><b>Time</b></label>
              <div class="form-group">
              <?php echo $data['details_time'] ?>
              </div>
            </div>
            <div class="col-4">
              <label for="" style="font-weight: bold;"><b>Date Book</b></label>
              <div class="form-group">
              <?php echo $data['booking_date'] ?>
              </div>
            </div>
            <div class="col-4">
              <label for="" style="font-weight: bold;"><b>Customer</b></label>
              <div class="form-group">
              <?php echo $get_name_fetch['pangalan'] ?>
              </div>
            </div>
            <div class="col-4 ">
              <label for="" style="font-weight: bold;"><b>Date</b></label>
              <div class="form-group">
              <?php echo $data['booking_start'] ?> - <?php echo $data['booking_end'] ?>
              </div>
            </div>
            <div class="col-4">
              <label for="" style="font-weight: bold;"><b>Pax</b></label>
              <div class="form-group">
              <?php echo $data['details_pax'] ?>
              </div>
            </div>
          </div>
            <br>
            <button type="button" class="float-left btn btn-danger waves-effect md-close">Close</button>
            <br>
        </div>
    </div>
</div>