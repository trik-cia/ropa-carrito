
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';


function enviarCorreo($destinatario, $asunto, $mensaje){  
$correo_cliente = new PHPMailer(true);

try {
    //configuracion del servidor SMTP
    $correo_cliente ->isSMTP();
    $correo_cliente ->  Host ='smtp.gmail.com';
    $correo_cliente ->  SMTPAuth = true;
    $correo_cliente ->  Username = ''; /* correo de aplication */
    $correo_cliente ->  Password = ''; /* su contraseña generada */
    $correo_cliente ->  SMTPSecure = 'tls';
    $correo_cliente ->  Port =587;

      // Permitir certificados autofirmados en localhost
    $correo_cliente ->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    //remitente, m('tu correo', 
    $correo_cliente ->setFrom('lunasmr001@gmail.com', 'Mi aplicacion');

    //destino principal
    $correo_cliente->addAddress($destinatario);

    //contenido del mensaje
    $correo_cliente ->isHTML(true);
    $correo_cliente ->Subject = $asunto;
    $correo_cliente ->Body = nl2br($mensaje); /* soporta el salto de linea */
    
    $correo_cliente ->send();
    return true;
} catch (Exception $e) {
    return "error al enviar el correo:" .$e->getMessage();
}

}
?>
