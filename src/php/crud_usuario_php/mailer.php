<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../../../vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host       = 'sandbox.smtp.mailtrap.io'; 
$mail->SMTPAuth   = true;
$mail->Username   = '1c1eaec378d17e'; 
$mail->Password   = 'a8aae4a119e33b'; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 2525;
$mail->isHTML(true);

return $mail;