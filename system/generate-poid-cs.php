<?php
    session_start();
    include 'dbms/conn.php';
    include 'function.php';
    include 'fpdf/fpdf.php';

    $pdf = new FPDF();

    $PO = $_GET['poidgenerate'];

    // echo 'hello';
    #NOTE: 
    #Cell->("WIDTH", "HEIGHT", "CONTENT", "BORDER", "UP/DOWN", C);
    #1 means new line
    #0 means on line

    $poid_info = mysqli_query($connect, "SELECT * FROM web_transaction WHERE trans_ref = '$PO'");
    $poid_info_fetch = mysqli_fetch_array($poid_info);

    $customer_name = $poid_info_fetch['trans_name'];
    $customer_mobile = $poid_info_fetch['trans_mobile'];
    $customer_mop = $poid_info_fetch['trans_mop'];
    $customer_email = $poid_info_fetch['trans_email'];
    $customer_address = $poid_info_fetch['trans_address'];
    $customer_office = $poid_info_fetch['trans_office'];
    $customer_country = $poid_info_fetch['trans_country'];
    $state = $poid_info_fetch['trans_state'];

    $state_sql = mysqli_query($connect, "SELECT * FROM upti_state WHERE state_name = '$state' AND state_country = '$customer_country'");
    if (mysqli_num_rows($state_sql) > 0) {
      $state_fetch = mysqli_fetch_array($state_sql);
      $state_data = $state_fetch['state_territory'];
    } else {
      $state_data = 'TERRITORY 1';
    }

    $total = $poid_info_fetch['trans_subtotal'];
    $shipping = $poid_info_fetch['trans_shipping'];
    $less_shipping = $poid_info_fetch['trans_less_shipping'];

    $ol_info = mysqli_query($connect, "SELECT * FROM web_cart WHERE cart_ref = '$PO'");

    $pdf->AddPage();

    $pdf->Cell(190,5,"",0,1);
    $pdf->Cell(190,5,"",0,1);
    $pdf->Cell(190,5,"",0,1);

    $pdf->Image('images/logo.png',66,10, -950);

    $pdf->Cell(190,5,"",0,1);
    $pdf->Cell(190,5,"",0,1);
    $pdf->Cell(190,5,"",0,1);

    $pdf->SetFont("Arial", "", 14);
    // $pdf->Cell(95,5,"",0,1);
    $pdf->Cell(190,5,"Thank you for your Orders!",0,1, 'C');
    $pdf->Cell(190,5,"We hope you enjoyed shopping with us.",0,1, 'C');

    $pdf->Cell(190,5,"",0,1);
    $pdf->Cell(190,5,"",0,1);

    $pdf->SetFont("Arial", "B", 13);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(5,10,"",0,0,'L',True);
    $pdf->Cell(185,10,"ORDER INFORMATION",0,1,'L',True);
    $pdf->Cell(190,5,"",0,1);
    $pdf->SetFont("Arial", "", 14);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(20,7,"Order No.: ",0,0);
    $pdf->Cell(75,7,$PO,0,0, 'C');
    $pdf->Cell(45,7,"Payment Method: ",0,0);
    $pdf->Cell(50,7,$customer_mop,0,1);

    $pdf->Cell(45,7,"Delivery Option: ",0,0);
    $pdf->Cell(50,7,$customer_office,0,0);
    $pdf->Cell(95,7,"",0,1);

    $pdf->Cell(190,5,"",0,1);
    $pdf->Cell(190,5,"",0,1);

    $pdf->SetFont("Arial", "B", 13);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(5,10,"",0,0,'L',True);
    $pdf->Cell(185,10,"DELIVERY DETAILS",0,1,'L',True);
    $pdf->Cell(190,5,"",0,1);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "", 14);
    $pdf->Cell(20,7,"Name: ",0,0);
    $pdf->Cell(75,7,$customer_name,0,0, 'C');
    $pdf->Cell(45,7,"Mobile: ",0,0);
    $pdf->Cell(50,7,$customer_mobile,0,1);

    $pdf->Cell(45,7,"Address: ",0,0);
    $pdf->Cell(145,7,$customer_address,0,1);

    $pdf->Cell(190,7,"",0,1);
    $pdf->Cell(190,7,"",0,1);

    $pdf->SetFont("Arial", "B", 13);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(5,10,"",0,0,'L',True);
    $pdf->Cell(185,10,"ORDER SUMMARY",0,1,'L',True);
    $pdf->Cell(190,7,"",0,1);

    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(7,7,"#",0,0,'C');
    $pdf->Cell(120,7,"DESCRIPTION",0,0,'C');
    $pdf->Cell(15,7,"QTY",0,0,'C');
    $pdf->Cell(23,7,"PRICE",0,0,'C');
    $pdf->Cell(25,7,"SUBTOTAL",0,1,'C');

    $pdf->SetFont("Arial", "", 12);
 
    $number = 1;
    while ($rows = mysqli_fetch_array($ol_info)) {

        $ol_desc = $rows['cart_desc'];
        $ol_code = $rows['cart_code']; 
        $ol_qty = $rows['cart_qty'];
        $ol_price = $rows['cart_price'];
        $subtotal = $ol_qty * $ol_price;

        $pdf->Cell(7,7,$number,0,0,'C');
        $pdf->Cell(120,7,$ol_desc,0,0,'C');
        $pdf->Cell(15,7,$ol_qty,0,0,'C');
        $pdf->Cell(23,7,number_format($ol_price, '2'),0,0,'R');
        $pdf->Cell(25,7,number_format($subtotal, '2'),0,1,'R');
  
          $loop_poid = mysqli_query($connect, "SELECT * FROM upti_pack_sett WHERE p_s_main = '$ol_code'");
  
          if (mysqli_num_rows($loop_poid) > 0) {
            foreach ($loop_poid as $bundle) {
              $bundle_1 = $bundle['p_s_code'];
              $bundle_desc = $bundle['p_s_desc'];
              $bundle_1_1 = $bundle['p_s_qty'] * $ol_qty;
  
              $p_name_1 = '***'.$bundle_desc;
              $pdf->Cell(7,7,"",0,0,'C');
              $pdf->Cell(120,7,$p_name_1,0,0,'C');
              $pdf->Cell(15,7,$bundle_1_1,0,1,'C');
              
            }
          }
        // loop
        $number++;
    }

    $pdf->Cell(190,7,"",0,1);

    $pdf->Cell(125,7,"",0,0,'C');
    $pdf->Cell(40,7,"Shipping Fee: ",0,0,'L');
    $pdf->Cell(25,7,number_format($shipping, '2'),0,1,'R');

    $pdf->Cell(125,7,"",0,0,'C');
    $pdf->Cell(40,7,"Less Shipping Fee: ",0,0,'L');
    $pdf->Cell(25,7,number_format($less_shipping, '2'),0,1,'R');

    $pdf->Cell(125,7,"",0,0,'C');
    $pdf->Cell(40,7,"Total Amount: ",0,0,'L');
    $pdf->Cell(25,7,number_format($total, '2'),0,1,'R');

    if ($customer_country == 'KOREA' && $state_data = 'TERRITORY 1') {
        $bank = '김태광, 김마쉘';
    } elseif ($customer_country == 'TAIWAN' && $state_data == 'TERRITORY 1') {
        $bank = 'Abner Lopez';
    } elseif ($customer_country == 'JAPAN' && $state_data == 'TERRITORY 1') {
        $bank = 'Asahina Nastsuko';
    } elseif ($customer_country == 'CANADA' && $state_data == 'TERRITORY 1') {
        $bank = 'D&J Go Glow Inc.';
    } elseif ($customer_country == 'HONGKONG' && $state_data == 'TERRITORY 1') {
        $bank = 'Ads Konnect / Alipay HK';
    } elseif ($customer_country == 'UNITED ARAB EMIRATES' && $state_data == 'TERRITORY 1') {
        $bank = 'Mark Lopez';
    } elseif ($customer_country == 'USA' && $state_data == 'TERRITORY 1') {
      $bank = 'JD FAB GLOW INC.';
    } elseif ($customer_country == 'USA' && $state_data == 'TERRITORY 3') {
      $bank = 'ALOHA UPTIMISED';
    } else {
        $bank = '';
    }

  if ($customer_country != 'PHILIPPINES') {
      $pdf->Cell(190,20,"",0,1);
      $pdf->SetFont("Arial", "", 14);
      $pdf->Cell(190,7,$bank." is an Uptimised Partner based in ".$customer_country.".",0,1,'C');
      $pdf->Cell(190,7,"We offer premium K-Beauty Skincare Products.",0,1,'C');
  }

    $pdf->Output();
?>