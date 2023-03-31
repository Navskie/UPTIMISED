<div class="modal fade" id="pack<?php echo $items['id']; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Package Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <hr>
                <!-- <span>Package Details</span> -->
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <i>Item Code</i>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <i>Description</i>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <i>Quantity</i>
                    </div>
                    <?php
                        $mycodes = $items['ol_code'];
                        $qty = $items['ol_qty'];

                        $packages = "SELECT * FROM upti_pack_sett WHERE p_s_main = '$mycodes'";
                        $packages_qry = mysqli_query($connect, $packages);

                        foreach ($packages_qry as $pack_datas) {
                    ?>
                    <div class="col-12"><hr></div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <h5><?php echo $pack_datas['p_s_code'] ?></h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h5><?php echo $pack_datas['p_s_desc']; ?></h5>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <h5><?php echo $pack_datas['p_s_qty'] * $qty ?></h5>
                    </div>
                    <?php } ?>
                </div>
                <hr>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>