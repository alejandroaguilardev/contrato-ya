<?php

namespace App\SendMailContact\Application;

use App\Common\Domain\ErrorDomain;
use App\Common\Domain\MailService;
use App\SendMailContact\Domain\Contact;

final class SendMailContact
{
    public function __construct(
        private readonly MailService $mailService,
        private readonly string $to,

    ) {}

    public function sendMail(Contact $contact): string
    {
        $message = $this->buildEmailData($contact);
        $response = $this->mailService->sendMail($this->to,'Contrato Ya - Email desde la web', $message);
        //$this->handleResponse($response);

        return "Correo enviado exitosamente";
    }

    private function buildEmailData(Contact $contact): string
    {
        return '<html><body>' .
            '<p>email: ' . nl2br(htmlspecialchars($contact->email->value)) . '</p>' .
            '<p>Mensaje: ' . nl2br(htmlspecialchars($contact->message->value)) . '</p>' .
            '<p>Teléfono: ' . nl2br(htmlspecialchars($contact->phone->value)) .'</p>' . 
            '</body></html>';
    }


    private function handleResponse(array $response): void
    {
        if ($response["status_code"] < 200 || $response["status_code"] >= 300) {
            $responseBody = json_decode($response["body"], true);
            $errorMessage = 'Error desconocido';

            if (is_array($responseBody) && isset($responseBody['message'])) {
                $errorMessage = $responseBody['message'];
            } else {
                $errorMessage .= ': ' . $response["body"];
            }

            throw new ErrorDomain("Error en el envío del correo: " . $errorMessage);
        }
    }
}
