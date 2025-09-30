<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require ('Exception.php');
require ('PHPMailer.php');
require ('SMTP.php');
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$email = "thiagowagner231@gmail.com";
try {
    //Server settings
      $mail->SMTPDebug = 2;                   
      $mail->isSMTP();                                            
      $mail->Host = 'smtp.gmail.com';                    
      $mail->SMTPAuth = true;                                   
      $mail->Username = 'mutualpolicialneuquen@gmail.com';                   
      //$mail->Password = 'Mutual123456'; 
      $mail->Password = 'oadyjazdtoogavmy'; //Contraseña de aplicacion                          
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'ThiagoOMG');
    $mail->addAddress($email,);     //Add a recipient


    /*Attachments aca vamos a poner la fotito del turno
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    */
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Prueba';
    $mail->Body    = 'OMG FUNCIONA!!!!!';

    $mail->send();
    echo 'Se envio!';
} catch (Exception $e) {
    echo "No funcionó :( : {$mail->ErrorInfo}";
}