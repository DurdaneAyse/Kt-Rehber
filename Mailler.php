<?php
include_once("mailsrc/PHPMailer.php");
include_once("mailsrc/SMTP.php");
include_once("mailsrc/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailler
{
    private $addAdresTitle;
    private $mailBody;

    public function sendActivationMail($email, $activationCode, $memType)
    {
        $this->addAdresTitle = "Yeni Üye";
        $this->mailBody = "<p>Ktü Minevra portalına hoşgeldiniz.</p>
							  <p>Aktivasyon işlemi için lütfen<a href='localhost/minerva/activation.php?code=" . $activationCode . "&usrmode=" . $memType . "'> buraya </a>tıklayınız</p>";
        $mail = new PHPMailer();

        try {

            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'minevradestek@gmail.com';
            $mail->Password = 'ayqle.brka!';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->setLanguage('tr', '/language');

            $mail->Port = 587;


            $mail->setFrom('minevradestek@gmail.com', 'Hosho ve adamlari');
            $mail->addAddress($email, $this->addAdresTitle);


            //$mail->addAttachment('/var/tmp/file.tar.gz');


            $mail->isHTML(true);
            $mail->Subject = 'Minevra Aktivasyon Maili';
            $mail->Body = $this->mailBody;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
