<?php include 'include/header.php'; ?>

<!--Body Content-->
<div id="page-content">         
    <!--Home slider-->
    <div class="slideshow slideshow-wrapper pb-section">
        <div class="home-slideshow">
            <div class="slide">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload" data-src="assets/images/main/YMR_NA_KULOT.jpg" src="assets/images/main/YMR_NA_KULOT.jpg"/>
                    <div class="slideshow__text-wrap slideshow__overlay classic middle">
                        <div class="slideshow__text-content middle">
                            <div class="container">
                                <div class="wrap-caption right">

                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
            <div class="slide">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload" data-src="assets/images/main/banner.jpg" src="assets/images/main/banner.jpg"/>
                    <div class="slideshow__text-wrap slideshow__overlay classic middle">
                        <div class="slideshow__text-content middle">
                            <div class="container">
                                <div class="wrap-caption right">

                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
            <div class="slide">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload" data-src="assets/images/main/2022.jpg" src="assets/images/main/2022.jpg"/>
                    <div class="slideshow__text-wrap slideshow__overlay classic middle">
                        <div class="slideshow__text-content middle">
                            <div class="container">
                                <div class="wrap-caption center">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Home slider-->

    <!--Weekly Bestseller-->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <i style="font-size: 33px !important">Bestselling Beauty <?php echo $_SESSION['repli_code'] ?></i>
                        <!-- <p>Our most popular products based on sales</p> -->
                    </div>
                    <div class="productSlider grid-products">
                        <?php

                            $d_item = "SELECT items_code, items_desc FROM upti_items 
                                        UNION 
                                        SELECT package_code, package_desc FROM upti_package 
                                         LIMIT 15";
                            $d_item_sql = mysqli_query($connect, $d_item);
                            while ($d_item_fetch = mysqli_fetch_array($d_item_sql)) {
                                $d_item_code = $d_item_fetch['items_code'];

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

                        ?>
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
                                    <a href="details.php?code=<?php echo $d_item_code ?>" class="product-name"><?php echo $d_item_fetch['items_desc']; ?></a>
                                </div>
                                <!-- End product name -->
                            </div>
                            <?php if ($profile != '') { ?>
                                <form action="backend/add-to-cart.php?code=<?php echo $d_item_code ?>" onclick="window.location.href='cart.php'"method="post" class="item">
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
                                <?php 
                                    } elseif ($inv == $loop_qty) { 
                                ?>
                                    <button class="btn btn-custom w-100" tabindex="0" name="addtocart">ADD TO CART - <?php echo $country_code ?> <?php $price = $d_item_price_fetch['country_price']; echo number_format($price); ?></button>
                                <?php } else { ?>
                                    <button class="btn btn-custom w-100" tabindex="0" disabled>OUT OF STOCK</button>
                                <?php } ?>
                                </form>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-custom w-100" tabindex="0">ADD TO CART - <?php echo $country_code ?> <?php $price = $d_item_price_fetch['country_price']; echo number_format($price); ?></a>
                            <?php } ?>
                            <!-- End product details -->
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <!--Weekly Bestseller-->
    
     <!--Logo Slider-->
    <!-- <div class="section logo-section pb-3">
        <div class="container">
            <div class="row" style="background-color: #f8f8f8;">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <p class="pt-3" style="font-size: 33px !important">THIS MONTH'S TOP OFFERS</p>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-lg-3 px-4 pb-5">
                                <div class="p-4" style="border: 2px solid #000;">
                                    <p style="font-size: 24px; font-weight: 600; text-align: center; color: #a60f38;">JUNE 25 ONLY</p>
                                    <p class="text-center px-3" style="font-size: 20px;">
                                        Lip & Cheek Tint P49 with any P2,800 purchase
                                    </p>
                                    <button class="btn w-100" style="background-color: #e8032a;">SHOP NOW</button>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3 px-4 pb-5">
                                <div class="p-4 container" style="border: 2px solid #000;">
                                    <p style="font-size: 24px; font-weight: 600; text-align: center; color: #a60f38;">BUY 1 GET 1</p>
                                    <p class="text-center px-3" style="font-size: 20px;">
                                        Select Soosul Products ONLY 999
                                    </p>
                                    <button class="btn w-100" style="background-color: #e8032a;">SHOP NOW</button>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3 px-4 pb-5">
                                <div class="p-4" style="border: 2px solid #000;">
                                    <p style="font-size: 24px; font-weight: 600; text-align: center; color: #a60f38;">END'S TODAY</p>
                                    <p class="text-center px-3" style="font-size: 20px;">
                                        3+1 Deodorant Cream P999 ONLY
                                    </p>
                                    <button class="btn w-100" style="background-color: #e8032a;">SHOP NOW</button>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3 px-4 pb-5">
                                <div class="p-4" style="border: 2px solid #000;">
                                    <p style="font-size: 24px; font-weight: 600; text-align: center; color: #a60f38;">50% OFF</p>
                                    <p class="text-center px-3" style="font-size: 20px;">
                                        Select Beauty Products<br><br>
                                    </p>
                                    <button class="btn w-100" style="background-color: #e8032a;">SHOP NOW</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--End Logo Slider-->
    
    <!-- 2 image Start -->
    <div class="latest-blog section">
    	<div class="container">
        	<div class="row">
            	<div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="image-layer">
                        <a href="shop.php" class="btn btn-dark px-5 buyme">BUY ME</a>
                        <img src="assets/images/main/UA-web.jpg" alt="" class="img-responsive w-100 buymeimg">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <img src="assets/images/main/uptimazing set.jpg" alt="" class="img-responsive w-100">
                    <a href="shop.php" class="btn btn-dark px-5 buyme2">BUY ME</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 2 Imagae End -->

    <!-- Video -->
    <div class="latest-blog section">
    	<div class="container">
            <div class="section-header text-center">
                <i style="font-size: 33px !important">Testimonials</i>
                <!-- <p>Our most popular products based on sales</p> -->
            </div>
        	<div class="row testi">
            	<div class="col-sm-6 col-md-6 col-lg-6">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/d52OcBXKzYs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <br>
                    <div class="text-center head-body">
                        <span class="testi-head">
                            “The best sleeping mask I’ve ever tried!”<br>
                            <!-- <p style="color: #cb4c75;">best selling face cleanser</p> -->
                        </span>
                    </div>
                    <br><br>
                    <div class="testi-content text-center">
                        <p>
                            "I have very dry, sensitive skin. This sleeping mask is the best I’ve ever tried! The buttery texture of the cream is so soothing to put on and I love the scent. Leaving my skin hydrated and glowing. This is exactly what I was looking for in a cream."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video -->

    <!-- Full Image -->
    <div class="latest-blog section">
    	<div class="container">
        	<div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="membership.php">
                    <img src="assets/images/resellers.jpg" alt="" class="img-responsive w-100">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Image -->

    <!-- Image Slider -->
    <div class="latest-blog section">
    	<div class="container">
        	<div class="row">
                <div class="col-12">
                    <h1 class="text-center">#KBeautyByUptimised</h1>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="w3-content" style="max-width:1200px">
                        <div class="owl-carousel owl-theme">
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/1.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/2.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/3.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/4.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/5.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/6.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/7.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/8.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/9.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/10.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/11.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/12.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="item px-2">
                                <video width="400" controls style="width: 160px; height: 160px;">
                                    <source src="assets/video/13.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Slider -->
    
</div>
<!--End Body Content-->
    
<?php include 'include/footer.php'; ?>