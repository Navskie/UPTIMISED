<?php include 'include/header.php' ?>
<?php include 'include/navbar.php' ?>
<?php include 'include/topbar.php' ?>

<div class="page-wrapper">
<!-- Page-header start -->
<div class="row">
  <div class="col-4">
    <div class="card">
      <div class="card-block-big card-visitor-block">
        <div class="row">
          <div class="col-8 card-visitor-button">
            <button class="btn btn-primary btn-icon"><i class="icofont icofont-ui-rotation"></i></button>
            <div class="card-contain">
              <h6>0</h6>
              <p class="text-muted f-18 m-0">Reservation</p>
            </div>
          </div>
          <div class="col-4 text-center">
            <span class="visitor-chart"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card">
      <div class="card-block-big card-visitor-block">
        <div class="row">
          <div class="col-8 card-visitor-button">
            <button class="btn btn-primary btn-icon"><i class="icofont icofont-ui-check"></i></button>
            <div class="card-contain">
              <h6>0</h6>
              <p class="text-muted f-18 m-0">Success</p>
            </div>
          </div>
          <div class="col-4 text-center">
            <span class="visitor-chart"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card">
      <div class="card-block-big card-visitor-block">
        <div class="row">
          <div class="col-8 card-visitor-button">
            <button class="btn btn-primary btn-icon"><i class="icofont icofont-ui-close"></i></button>
            <div class="card-contain">
              <h6>0</h6>
              <p class="text-muted f-18 m-0">Canceled</p>
            </div>
          </div>
          <div class="col-4 text-center">
            <span class="visitor-chart"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- row end -->
<?php include 'include/footer.php' ?>