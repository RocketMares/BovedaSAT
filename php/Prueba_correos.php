<?php

use PHPMailer\PHPMailer\PHPMailer;

require "PHPmeil/PHPMailer.php";
require "PHPmeil/Exception.php";
require "PHPmeil/SMTP.php";
$mail = new PHPMailer();

try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = "smtp.live.com";

    $mail->SMTPAuth = true;
    $mail->Username = "MASA955J1@dssat.sat.gob.mx";
    $mail->Password = "Julio452";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("MASA955J1@dssat.sat.gob.mx", "MASA955J1");
    $mail->addAddress("MASA955J1@dssat.sat.gob.mx");
    $mail->isHTML(true);
    $mail->Subject="Correo de prueba php";
    $mail->Body = "Se finaliza prueba";

    $mail->send();
    echo "El mensaje se ha enviado correctamente";

} catch (\Exception $e) {
    echo "Fallo el envio de correo ", $mail->ErrorInfo;
}




?>