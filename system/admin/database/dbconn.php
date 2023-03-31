<?php
  $host = 'localhost'; #online hostname
  $user = 'root'; #online username
  $pass = ''; #online password
  $dbms = 'uptimisedph'; #online dbname test

  // try
  // {
  //   $connection = new PDO("mysql:host=$host;dbname=$dbms", $user, $pass);
  //   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //   // echo 'Database Connected Successfully';
  // }
  // catch (PDOException $x)
  // {
  //   echo 'Database Error Connection: ' . $x->getMessage();
  // }

  // $connect = mysqli_connect('localhost', 'u708090748_uptimised', '@User2022', 'u708090748_uptimisedph'); 
  $connect = mysqli_connect('localhost', 'root', '', 'uptimisedph');

  date_default_timezone_set('Asia/Manila');
  $now = date('m-d-Y');
  $timenow = date('h:m:s');
  $timedate = $now.' - '.$timenow;

  session_start();
?>