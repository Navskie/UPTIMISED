
<?php include 'include/header.php'; ?>

<!--Body Content-->
<div id="page-content">     
    <div><img src="assets/images/main/skincare_banner.jpg" alt="" width="100%"></div>
    <br><br>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-7">
                <!-- <a href="best.php" class="btn btn-dark bg-info">Best Sellers</a>
                <a href="promo.php" class="btn btn-dark bg-success">Promo</a>
                <a href="regular.php" class="btn btn-dark bg-primary">Regular</a> -->
                <!-- <a href="membership.php" class="btn btn-dark bg-danger">Membership</a> -->
            </div>
            <div class="col-sm-12 col-md-12 col-lg-5">
                <div class="row">
                    <div class="col-8">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" placeholder="Search Product" name="itemcode" class="form-control rounded-0 w-100" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-dark form-control w-100" name="shop">Search</button>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        <br>
        <?php 
            if (isset($_POST['shop'])) { #shop search start
                $item_code = $_POST['itemcode'];
        ?>
        <div class="row">
        <?php

          $rpp = 20;

          if(isset($_GET['page'])) {
              $page = $_GET['page'];
          } else {
              $page = 1;
          }

          $start_from = ($page-1)*$rpp;

          $d_item = "
          SELECT code_name, items_desc, items_status FROM upti_items
          INNER JOIN upti_code ON items_code = code_name
          WHERE
          items_status = 'Active' AND code_category = 'PROMO' AND items_desc LIKE '%$item_code%'
          UNION
          SELECT code_name, package_desc, package_status FROM upti_package
          INNER JOIN upti_code ON package_code = code_name
          WHERE
          package_status = 'Active' AND code_category = 'PROMO' AND package_desc LIKE '%$item_code%'
          LIMIT $start_from, $rpp";
          $d_item_sql = mysqli_query($connect, $d_item);

          if (mysqli_num_rows($d_item_sql) > 0) {

        ?>
            <div class="col-12">
                <br>
            <p class="text-center">Showing Result for <b><?php echo $item_code ?></b></p>
            </div>
            <?php
              while ($d_item_fetch = mysqli_fetch_array($d_item_sql)) {
                
                $d_item_code = $d_item_fetch['code_name'];

                $d_item_price = "SELECT * FROM upti_country WHERE country_name = '$customer_country' AND country_code = '$d_item_code'";
                $d_item_price_sql = mysqli_query($connect, $d_item_price);
                $d_item_price_fetch = mysqli_fetch_array($d_item_price_sql);

                if (mysqli_num_rows($d_item_price_sql) > 0) {
                  $country_price = $d_item_price_fetch['country_price'];
                } else {
                  $country_price = 0;
                }

                $prod_stmt = mysqli_query($connect, "SELECT * FROM upti_product WHERE p_code = '$d_item_code'");
                $get_img = mysqli_fetch_array($prod_stmt);

                if (mysqli_num_rows($prod_stmt) > 0) {
                    $images = $get_img['p_m_img'];
                } else {
                    $images = '';
                }

                if ($country_price > 0) {

            ?>
            <div class="col-sm-12 col-md-3 col-lg-3">
                <div class="col-12">
                    <!-- start product image -->
                    <span class="whislist"><a href="#" class="dis"><i class="fa-thin fa-heart"></i></a></span>
                    <span class="discount"><i class="fa fa-medal medds"></i></span>
                    
                    <div class="cart-img">
                        <?php
                            if ($images == '') {
                        ?>
                            <img src="assets\images\main\default.jpg">
                        <?php
                            } else {
                        ?>
                            <img src="assets\images\product\<?php echo $images ?>">
                        <?php
                            }
                        ?>
                    </div>
                    <!-- end product image -->

                    <!--start product details -->
                    <div class="product-details text-center item">
                        <!-- product name -->
                        <div class="product-name">
                            <a href="details.php?code=<?php echo $d_item_code ?>" class="product-name" style="font-size: 14px;"><?php echo $d_item_fetch['items_desc']; ?></a>
                        </div>
                        <!-- End product name -->
                    </div>
                    <?php if ($profile != '') { ?>
                    <form action="backend/add-to-cart.php?code=<?php echo $d_item_code ?>" onclick="window.location.href='cart.php'" method="post" class="item">
                        <?php
                            $main_code_qry = mysqli_query($connect, "SELECT * FROM upti_code WHERE code_name = '$d_item_code'");
                            $maincode = mysqli_fetch_array($main_code_qry);

                            $main_code = $maincode['code_main'];
                            
                            $pack_stock = mysqli_query($connect, "SELECT * FROM upti_pack_sett WHERE p_s_main = '$d_item_code'");
                            $pack_item = mysqli_fetch_array($pack_stock);

                            if (mysqli_num_rows($pack_stock) > 0) {
                                $code = $pack_item['p_s_code'];
                                // echo '=';
                                $qty = $pack_item['p_s_qty'];
                                // echo '=';
                                $loop_qty += $qty;
                  
                                $inventory_qry = "SELECT si_item_stock FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_role = 'TERRITORY 1' AND si_item_code = '$code'";
                                $inventory_sql = mysqli_query($connect, $inventory_qry);
                                $inventory_fetch = mysqli_fetch_array($inventory_sql);
                        
                                $si_item_stocks = $inventory_fetch['si_item_stock'];
                                // echo '<br>';
                                if ($si_item_stocks >= $qty) {
                                  $inv += $qty;
                                  // echo '<br>';
                                } else {
                                  $inv = 0;
                                  // echo '<br>';
                                }
                            } else {
                                $stocks_stmt = mysqli_query($connect, "SELECT * FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_code = '$main_code'");
                                $stockist_inv = mysqli_fetch_array($stocks_stmt);

                                if (mysqli_num_rows($stocks_stmt) > 0) {
                                    $stocks = $stockist_inv['si_item_stock'];
                                } else {
                                    $stocks = 0;
                                }

                                $inv = 1;
                                $loop_qty = 1;
                            }

                            if ($country_price < 1) {
                        ?>
                            <button class="btn btn-custom w-100" tabindex="0" disabled>NO PRICE</button>
                            <?php } elseif ($inv == $loop_qty) { ?>
                                <button class="btn btn-custom w-100" tabindex="0" name="addtocart" disabled>ADD TO CART - <?php echo $country_code ?> <?php $price = $d_item_price_fetch['country_price']; echo number_format($price); ?></button>
                        <?php } else { ?>
                            <button class="btn btn-custom w-100" tabindex="0" disabled>OUT OF STOCK</button>
                        <?php } ?>
                    </form>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-custom w-100" tabindex="0">ADD TO CART - <?php echo $country_code ?> <?php $price = $d_item_price_fetch['country_price']; echo number_format($price); ?></a>
                        <!-- <button class="btn btn-custom w-100" tabindex="0" disabled>NOT AVAILABLE</button> -->
                    <?php } ?>
                    <!-- End product details -->
                    <br>
                </div>
            </div>
            <?php } }?>
            <?php } else { ?>
                <div class="row align-items-center text-center">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <img src="assets/images/main/empty.jpg" alt="" class="img-responsive w-100">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h1 class="text-center">Showing results for <br><b><?php echo $item_code ?></b></h1>
                    </div>
                </div>
            <?php }  ?>
        <?php
            } else { #shop search middle
        ?>
        <div class="row">
        <?php

        $rpp = 20;

        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $start_from = ($page-1)*$rpp;

        $d_item = "SELECT code_name, items_desc, items_status FROM upti_code 
        INNER JOIN upti_items ON upti_code.code_name = upti_items.items_code 
        WHERE code_category = 'PROMO' AND items_status = 'Active' 
        UNION 
        SELECT code_name, package_desc, package_status FROM upti_code 
        INNER JOIN upti_package ON upti_code.code_name = upti_package.package_code 
        WHERE code_category = 'PROMO' AND package_status = 'Active'
        LIMIT $start_from, $rpp";
        $d_item_sql = mysqli_query($connect, $d_item);
        while ($d_item_fetch = mysqli_fetch_array($d_item_sql)) {
            $d_item_code = $d_item_fetch['code_name'];

            $d_item_price = "SELECT * FROM upti_country WHERE country_name = '$customer_country' AND country_code = '$d_item_code'";
            $d_item_price_sql = mysqli_query($connect, $d_item_price);
            $d_item_price_fetch = mysqli_fetch_array($d_item_price_sql);

            if (mysqli_num_rows($d_item_price_sql) > 0) {
              $country_price = $d_item_price_fetch['country_price'];
            } else {
              $country_price = 0;
            }

            $prod_stmt = mysqli_query($connect, "SELECT * FROM upti_product WHERE p_code = '$d_item_code'");
            $get_img = mysqli_fetch_array($prod_stmt);

            if (mysqli_num_rows($prod_stmt) > 0) {
                $images = $get_img['p_m_img'];
            } else {
                $images = '';
            }

            if ($country_price > 0) {
        ?>
        <div class="col-sm-12 col-md-3 col-lg-3">
            <div class="col-12">
                <!-- start product image -->
                <span class="whislist"><a href="#" class="dis"><i class="fa-thin fa-heart"></i></a></span>
                <span class="discount"><i class="fa fa-medal medds"></i></span>
                
                <div class="cart-img">
                    <?php
                        if ($images == '') {
                    ?>
                        <img src="assets\images\main\default.jpg">
                    <?php
                        } else {
                    ?>
                        <img src="assets\images\product\<?php echo $images ?>">
                    <?php
                        }
                    ?>
                </div>
                <!-- end product image -->

                <!--start product details -->
                <div class="product-details text-center item">
                    <!-- product name -->
                    <div class="product-name">
                        <a href="details.php?code=<?php echo $d_item_code ?>" class="product-name" style="font-size: 14px;"><?php echo $d_item_fetch['items_desc']; ?></a>
                    </div>
                    <!-- End product name -->
                </div>
                <?php if ($profile != '') { ?>
                <form action="backend/add-to-cart.php?code=<?php echo $d_item_code ?>" onclick="window.location.href='cart.php'" method="post" class="item">
                    <?php
                        $main_code_qry = mysqli_query($connect, "SELECT * FROM upti_code WHERE code_name = '$d_item_code'");
                        $maincode = mysqli_fetch_array($main_code_qry);

                        $main_code = $maincode['code_main'];
                        
                        $pack_stock = mysqli_query($connect, "SELECT * FROM upti_pack_sett WHERE p_s_main = '$d_item_code'");
                        $pack_item = mysqli_fetch_array($pack_stock);

                        if (mysqli_num_rows($pack_stock) > 0) {
                            $code = $pack_item['p_s_code'];
                            // echo '=';
                            $qty = $pack_item['p_s_qty'];
                            // echo '=';
                            $loop_qty += $qty;
              
                            $inventory_qry = "SELECT si_item_stock FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_role = 'TERRITORY 1' AND si_item_code = '$code'";
                            $inventory_sql = mysqli_query($connect, $inventory_qry);
                            $inventory_fetch = mysqli_fetch_array($inventory_sql);
                    
                            $si_item_stocks = $inventory_fetch['si_item_stock'];
                            // echo '<br>';
                            if ($si_item_stocks >= $qty) {
                              $inv += $qty;
                              // echo '<br>';
                            } else {
                              $inv = 0;
                              // echo '<br>';
                            }
                        } else {
                            $stocks_stmt = mysqli_query($connect, "SELECT * FROM stockist_inventory WHERE si_item_country = '$customer_country' AND si_item_code = '$main_code'");
                            $stockist_inv = mysqli_fetch_array($stocks_stmt);

                            if (mysqli_num_rows($stocks_stmt) > 0) {
                                $stocks = $stockist_inv['si_item_stock'];
                            } else {
                                $stocks = 0;
                            }

                            $inv = 1;
                            $loop_qty = 1;
                        }

                        if ($country_price < 1) {
                    ?>
                        <button class="btn btn-custom w-100" tabindex="0" disabled>NO PRICE</button>
                        <?php } elseif ($inv == $loop_qty) { ?>
                            <button class="btn btn-custom w-100" tabindex="0" name="addtocart">ADD TO CART - <?php echo $country_code ?> <?php $price = $d_item_price_fetch['country_price']; echo number_format($price); ?></button>
                            <!-- <button class="btn btn-custom w-100" tabindex="0" disabled>NOT AVAILABLE</button> -->
                    <?php } else { ?>
                        <button class="btn btn-custom w-100" tabindex="0" disabled>OUT OF STOCK</button>
                    <?php } ?>
                </form>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-custom w-100" tabindex="0">ADD TO CART - <?php echo $country_code ?> <?php $price = $d_item_price_fetch['country_price']; echo number_format($price); ?></a>
                    <!-- <button class="btn btn-custom w-100" tabindex="0" disabled>NOT AVAILABLE</button> -->
                <?php } ?>
                <!-- End product details -->
                <br>
            </div>
        </div>
        <?php 
              }
            } 
        ?>
        
        <div class="col-12">
            <br><br>
            <?php
                $page_info = "SELECT code_name, items_desc, items_status FROM upti_code 
                INNER JOIN upti_items ON upti_code.code_name = upti_items.items_code 
                WHERE code_category = 'PROMO' AND items_status = 'Active' 
                UNION 
                SELECT code_name, package_desc, package_status FROM upti_code 
                INNER JOIN upti_package ON upti_code.code_name = upti_package.package_code 
                WHERE code_category = 'PROMO' AND package_status = 'Active'";
                $page_query = mysqli_query($connect, $page_info);
                $page_num = mysqli_num_rows($page_query);

                $tot_pages = ceil($page_num / $rpp);
            ?>
            <nav class="page navigation" aria-label="...">
                <ul class="pagination">
                    <?php
                        for ($loop = 1; $loop <= $tot_pages; $loop++) {
                    ?>
                    <li class="page-item"><a class="page-link" href="shop.php?page=<?php echo $loop; ?>"><?php echo $loop; ?></a></li>
                    <?php 
                        }
                    ?>
                </ul>
            </nav>
            <p class="text-center">Page <?php echo $page ?></p>
        </div>
        <?php
            } #shop search end
        ?>
    </div>
</div>
<!--End Body Content-->
    
<?php include 'include/footer.php'; ?>