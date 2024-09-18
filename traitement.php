<?php

$nom = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$message = "Nom : " . $nom . "\n" . "Email : " . $email . "\n" . "Message : " . $message;

//Importer PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true);

try {
    //Parametre du serveur
 
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.example.com';  // Votre service de messagerie                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'example@gmail.com';                     
    $mail->Password   = 'Secret';                         //mot de passe SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                   

    
    $mail->setFrom('from@example.com', 'Objet');
    $mail->addAddress('joe@example.net');     //Exemple reception

    
    $mail->isHTML(true);                                  
    $mail->Subject = 'Here is the subject';
    $mail->Body    = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}