<?php

namespace App\Common\Infrastructure;

use App\Common\Domain\MailService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerMailService implements MailService
{
    private PHPMailer $mailer;

    public function __construct(
        private readonly string $from,
    ) {
        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['MAILER_HOST'] ?? 'mail.contratoya.pe';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['MAILER_USERNAME'] ;
        $this->mailer->Password = $_ENV['MAILER_PASSWORD'] ;
        $this->mailer->SMTPSecure = $_ENV['MAILER_SMTPSECURE'];
        $this->mailer->Port = (int)($_ENV['MAILER_PORT']);
    }

    public function sendMail(string $to, string $subject, string $message)
    {
        try {
            $this->mailer->setFrom($this->from, 'Contrato Ya');
            $this->mailer->addAddress($to);  
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $message; 
            $this->mailer->AltBody = strip_tags($message); 

            if ($this->mailer->send()) {
                return 'Correo enviado correctamente';
            } else {
                return 'Error al enviar el correo: ' . $this->mailer->ErrorInfo;
            }
        } catch (Exception $e) {
            return 'Error al enviar el correo: ' . $e->getMessage();
        }
    }
}
