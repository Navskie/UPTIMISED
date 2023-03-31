<?php
    include '../dbms/conn.php';

    session_start();
    $uid = $_SESSION['uid'];

    $id = $_GET['id'];
    
    $get_poid = "SELECT * FROM upti_transaction WHERE id = '$id'";
    $get_poid_qry = mysqli_query($connect, $get_poid);
    $get_poid_fetch = mysqli_fetch_array($get_poid_qry);
    
    $poid = $get_poid_fetch['trans_poid'];
    
    $getnamex = "SELECT * FROM upti_users WHERE users_id = '$uid'";
    $getnamex_qry = mysqli_query($connect, $getnamex);
    $getnamex_fetch = mysqli_fetch_array($getnamex_qry);

    $namex = $getnamex_fetch['users_name'];

    if (isset($_POST['convert'])) {
        date_default_timezone_set('Asia/Manila');
        $time = date("h:m:i");
        $datenow = date('m-d-Y');

        // Less MONEY MO KALA MO
        $earning_back_sql = mysqli_query($connect, "SELECT * FROM upti_earning WHERE earning_poid = '$poid'");

        foreach ($earning_back_sql as $earning_data) {

            $reseller_code = $earning_data['earning_code'];
            $reseller_earn = $earning_data['earning_earnings'];

            $get_remain_wallet = mysqli_query($connect, "SELECT * FROM upti_reseller WHERE reseller_code = '$reseller_code'");
            $get_wallet_fetch = mysqli_fetch_array($get_remain_wallet);

            $balance = $get_wallet_fetch['reseller_earning'] - $reseller_earn;

            $update_wallet = mysqli_query($connect, "UPDATE upti_reseller SET reseller_earning = '$balance' WHERE reseller_code = '$reseller_code'");

        }
        
        $desc = $namex.' Convert '.$poid.' set Ordered Status into RTS'; 

        // HISTORY
        $act = "INSERT INTO upti_activities (activities_poid, activities_time, activities_date, activities_name, activities_caption, activities_desc) VALUES ('$poid', '$time', '$datenow', '$namex', 'Deliver to RTS', '$desc')";
        $act_qry = mysqli_query($connect, $act);

        $epayment_process = "UPDATE upti_transaction SET trans_status = 'RTS', trans_stockist = 'Not Received' WHERE id = '$id'";
        $epayment_process_qry = mysqli_query($connect, $epayment_process);

        $epayment_process1 = "UPDATE upti_order_list SET ol_status = 'RTS' WHERE ol_poid = '$poid'";
        $epayment_process_qry1 = mysqli_query($connect, $epayment_process1);

    ?>
        <script>alert('Order Status has been convert to RTS Successfully');window.location.href = '../poid-list.php?id=<?php echo $id ?>';</script>
    <?php
        }
    ?>  