<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


function enviarEmail($correo = "", $codigo = "")
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $estado = ["enviado" => false];

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'nestorpq2001@gmail.com';                     //SMTP username
        $mail->Password   = 'jdqyoqzqbkzganha';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('sistemas@gmail.com', 'Correo de recuperacion');
        // $mail->addAddress('1208003@senati.pe', 'Joe User');     //Add a recipient
        $mail->addAddress($correo);               //Name is optional
        // $mail->addAddress('1208003@senati.pe');               //Name is optional
        // $mail->addAddress($correo);               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'codigo de recuperacion';
        $mail->Body    = '
        <h2>CODIGO DE CONFIRMACION</h2>
        <h3>
            Tu codigo es ' . $codigo  . ' no lo compartas con nadie
        </h3>
        ';
        $mail->AltBody = 'Tu correo no soporta HTML, por favor comunicarse...';

        $mail->send();
        $estado["enviado"] = true;
    } catch (Exception $e) {
        $estado["enviado"] = false;
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    return $estado;
}


// $respuesta =  enviarEmail("1208003@senati.pe", "666666");

// var_dump($respuesta);
