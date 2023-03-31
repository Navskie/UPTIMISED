<?php include 'include/header.php' ?>

  <!-- slide show -->

  <!-- slide show ENDDDDDDD -->

  <?php 
    $haven = mysqli_query($connect, "SELECT * FROM haven_product WHERE product_status = 'Active'");
  ?>
    <section>
        <?php foreach ($haven as $data) { ?>
        <?php
            $id = $data['id'];
        ?>
        <figure>
            <img class="img-section" src="../system/admin/images/<?php echo $data['product_img'] ?>" alt="" />
            <div class="text-sec">
                <h2><?php echo $data['product_title'] ?></h2>
                <br>
                <p>
                  <?php echo $data['product_desc'] ?>
                </p>
                <div class="row">
                  <div class="col-6">
                    <div style="border-radius: 10px; border: #f3f3f3 1px solid; padding: 10px 0">
                      <h5 class="text-center">WEEKDAYS</h5>
                      <h3 class="text-center">
                        <?php echo $data['product_weekdays'] ?>
                      </h3>
                    </div>
                  </div>
                  <div class="col-6">
                    <div style="border-radius: 10px; border: #f3f3f3 1px solid; padding: 10px 0">
                      <h5 class="text-center">WEEKENDS</h5>
                      <h3 class="text-center">
                        <?php echo $data['product_weekends'] ?>
                      </h3>
                    </div>
                  </div>
                </div>
                <br>
                <a class="linka" href="booking.php?HHCode=<?php echo $data['product_code'] ?>">BOOK NOW<span>&rarr;</span></a>
            </div>
        </figure>
        <?php } ?>
    </section>

    <div class="container">
      
    </div>

<?php include 'include/footer.php' ?>