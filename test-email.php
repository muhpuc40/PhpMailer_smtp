<?php
include('smtp/PHPMailerAutoload.php');

// Load configuration
$config = include('config.php');

$email = $_POST['email'];
$sub = $_POST['sub'];
$body = $_POST['msg'];

echo smtp_mailer($email, $sub, $body);

function smtp_mailer($to, $subject, $msg){
    global $config; // Access the config array

    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    //$mail->SMTPDebug = 2; 

    $mail->Username = $config['SMTP_USERNAME'];
    $mail->Password = $config['SMTP_PASSWORD']; 
    $mail->SetFrom($config['SMTP_USERNAME']);
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    
    if(!$mail->Send()){
        echo $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}
?>
