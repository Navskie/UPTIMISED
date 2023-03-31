<?php

    include 'system/smtp/PHPMailerAutoload.php';
    
    $remarks = 'Good Day ,<br><br> Your stock on hand for has reached its critical level. It’s about time to re-stock!<br><br>Thank you,<br>Uptimised';
    
    $mail = new PHPMailer(); 
//$mail->SMTPDebug=3;
  $mail->IsSMTP(); 
  $mail->SMTPAuth = true; 
  $mail->SMTPSecure = 'ssl'; 
  $mail->Host = "smtp.hostinger.com";
  $mail->Port = "465"; 
  $mail->IsHTML(true);
  $mail->CharSet = 'UTF-8';
  $mail->Username = "feb3rdweek@upticorporationph.com";
  $mail->Password = '@User2022';
  $mail->SetFrom("feb3rdweek@upticorporationph.com", "Critical Stocks");
  $mail->Subject = 'Critical Stocks Warning';
  $mail->Body = $remarks;
  $mail->AddAddress("uptimisedcorporation2022@gmail.com");
  $mail->SMTPOptions=array('ssl'=>array(
      'verify_peer'=>false,
      'verify_peer_name'=>false,
      'allow_self_signed'=>false
  ));
  if(!$mail->Send()){
      echo $mail->ErrorInfo;
  }

?>