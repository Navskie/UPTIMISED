<?php

            
    $checkout_sql = "UPDATE upti_transaction SET 
                      trans_date = '$date_today',
                      trans_time = '$time',
                      trans_status = 'Pending',
                      trans_subtotal = '$total_amount',
                      trans_ship = '$shipping',
                      trans_img = '$new_name',
                      trans_remarks = 'REGULAR'
                      WHERE trans_poid = '$poid'"; 
                    $checkout_qry = mysqli_query($connect, $checkout_sql);

    // ADD 1 TO POID Number
    $New_count = $Ucount + 1;
    $update_user_count = "UPDATE upti_users SET users_count = '$New_count' WHERE users_code = '$Ucode'";
    $update_user_count_qry = mysqli_query($connect, $update_user_count);

    flash("order", "Thank you! Your order was successfully submitted!");

    unset($_SESSION['subtotal']);
    unset($_SESSION['surcharge']);
    unset($_SESSION['shipping']);
    unset($_SESSION['total_amount']);

    header('location: my-order.php');

?>