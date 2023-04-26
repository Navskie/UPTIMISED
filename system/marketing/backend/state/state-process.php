<?php
    if (isset($_POST['bansa'])) {

        $state = $_POST['state'];
        $country = $_POST['country'];
        $territory = $_POST['territory'];

        $get_stockist = mysqli_query($connect, "SELECT * FROM stockist WHERE stockist_country = '$country' AND stockist_role = '$territory'");
        $get_stockist_fetch = mysqli_fetch_array($get_stockist);

        $stockist = $get_stockist_fetch['stockist_code'];
    
        $epayment_process = "INSERT INTO upti_state (state_name, state_country, state_territory, state_stockist) VALUES ('$state', '$country', '$territory', '$stockist')";
        $epayment_process_qry = mysqli_query($connect, $epayment_process);

        echo "<script>alert('Data has been Added successfully.');window.location.href = 'state.php';</script>";
    }
?>
<div class="modal fade" id="add">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">State</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="state" method="post">
            <div class="row">
                <div class="col-12">
                    <label for="">State</label>
                    <input type="text" class="form-control" name="state" autocomplete="off" required>
                </div>
                <div class="col-12">
                  <br>
                    <label for="">Country</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="country">
                      <option value="">Select Country</option>
                      <?php
                          $lugar = "SELECT DISTINCT cc_country FROM upti_country_currency";
                          $lugar_qry = mysqli_query($connect, $lugar);
                          while ($lugar_fetch = mysqli_fetch_array($lugar_qry)) {
                      ?>
                      <option value="<?php echo $lugar_fetch['cc_country'] ?>"><?php echo $lugar_fetch['cc_country'] ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="col-12">
                  <br>
                    <label for="">Territory</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="territory">
                      <option value="">Select Country</option>
                      <?php
                          $lugar = "SELECT * FROM upti_territory";
                          $lugar_qry = mysqli_query($connect, $lugar);
                          while ($lugar_fetch = mysqli_fetch_array($lugar_qry)) {
                      ?>
                      <option value="<?php echo $lugar_fetch['territory_name'] ?>"><?php echo $lugar_fetch['territory_name'] ?></option>
                      <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default border-info rounded-0" data-dismiss="modal">Close</button>
        <button class="btn btn-primary rounded-0" name="bansa">Submit</button>
        </form>
        </div>
        
    </div>
    </div>
</div>