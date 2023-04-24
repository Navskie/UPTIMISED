<?php
    include '../../../dbms/conn.php';

    $id = $_GET['id'];

    if (isset($_POST['package'])) {

        $pack_code = $_POST['pack_code'];
        $pack_desc = $_POST['pack_desc'];
        $pack_points = $_POST['pack_points'];
        $stats = $_POST['stats'];

        $check_pack = "SELECT * FROM upti_package WHERE id = '$id'";
        $check_pack_qry = mysqli_query($connect, $check_pack);
        $pack_fetch = mysqli_fetch_array($check_pack_qry);

        $old_code = $pack_fetch['package_code'];

        if ($pack_code == $old_code) {
            if ($pack_code == '') {
                echo "<script>alert('Package Code is missing.');window.location.href = '../../bundle.php';</script>";
            } else {
                $packages = "UPDATE upti_package SET package_status = '$stats', package_code = '$pack_code', package_desc = '$pack_desc', package_points = '$pack_points' WHERE id = '$id'";
                $package_qry = mysqli_query($connect, $packages);

                echo "<script>alert('Data has been Updated successfully.');window.location.href = '../../bundle.php';</script>";
            }
        } else {
            $get_package_sql = "SELECT * FROM upti_package WHERE package_code = '$pack_code'";
            $get_package_qry = mysqli_query($connect, $get_package_sql);
            $get_num_code = mysqli_num_rows($get_package_qry);

            if ($get_num_code == 0) {
                if ($pack_code == '') {
                  echo "<script>alert('Package Code is missing.');window.location.href = '../../bundle.php';</script>";
                } else {
                  $packages = "UPDATE upti_package SET package_status = '$stats', package_code = '$pack_code', package_desc = '$pack_desc', package_points = '$pack_points' WHERE id = '$id'";
                  $package_qry = mysqli_query($connect, $packages);

                  echo "<script>alert('Data has been Updated successfully.');window.location.href = '../../bundle.php';</script>";
                }
            } else {
                echo "<script>alert('Duplicate Package code is not allowed.');window.location.href = '../../bundle.php';</script>";
            }
        }

    }
?>