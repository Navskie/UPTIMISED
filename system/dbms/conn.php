<?php
    
    // $connect = mysqli_connect('localhost', 'u708090748_uptimised', '@User2022', 'u708090748_uptimisedph'); 
    // $connect = mysqli_connect('localhost', 'u817058626_uptimisedph', 'Uptimised2022', 'u817058626_uptimisedph'); 
    $connect = mysqli_connect('localhost', 'root', '', 'uptimisedph');

    date_default_timezone_set('Asia/Manila');
    $month = date('m');
    $monthName = date("F", mktime(0, 0, 0, $month, 10));
    $year = date('Y');
    $day = date('d');
    $date1 = $month.'-01-'.$year;
    $date2 = date('m-d-Y');
    
?>  