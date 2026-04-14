<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/includes/PHPMailer/Exception.php';
require __DIR__ . '/includes/PHPMailer/PHPMailer.php';
require __DIR__ . '/includes/PHPMailer/SMTP.php';

function enviarVerificacion($emailDestino, $token) {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'angels2001@welcomeangelito.me';
        $mail->Password   = 'Liligatafebrero2001@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
        $mail->Port       = 465;

        $mail->setFrom('angels2001@welcomeangelito.me', 'Tu Sistema');
        $mail->addAddress($emailDestino);

        $mail->isHTML(true);
        $mail->Subject = 'Verifica tu cuenta';

        $link = "https://welcomeangelito.me/verify.php?token=" . $token;

        $mail->Body = "
            <h2>Bienvenido</h2>
            <p>Haz clic en el siguiente enlace para verificar tu cuenta:</p>
            <a href='$link'>Verificar cuenta</a>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
    echo "Error: " . $mail->ErrorInfo;
    return false;
}
}