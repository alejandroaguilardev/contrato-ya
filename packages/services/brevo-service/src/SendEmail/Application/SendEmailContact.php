<?php

namespace App\SendEmail\Application;

use App\Common\Domain\ErrorDomain;
use App\Common\Domain\HttpClient;
use App\SendEmail\Domain\Contact;

final class SendEmailContact
{
    public function __construct(
        readonly HttpClient $httpClient, 
        readonly string $apiUrl, 
        readonly string $apiKey, 
        readonly string $sender,
        readonly string $email,
    ) {}

    public function sendMail(Contact $contact): string
    {
        $emailData = $this->buildEmailData($contact);
        $response = $this->sendEmailRequest($emailData);
        $this->handleResponse($response);

        return "Correo enviado exitosamente";
    }

    private function buildEmailData(Contact $contact): array
    {
        return [
            'sender' => [
                'name' => $this->sender, 
                'email' => $this->email
            ],
            'to' => [
                [
                    'email' => $contact->email->value,
                    'name' => $contact->name->value,
                ]
            ],
            'subject' => 'Contrato Ya - Email desde la web',
            'htmlContent' => '<html><body>' .
            '<p>Mensaje: ' . nl2br(htmlspecialchars($contact->message->value)) . '</p>' .
            '<p>Teléfono: ' . nl2br(htmlspecialchars($contact->phone->value)) .'</p>' . 
            '</body></html>'
        ];
    }

    private function sendEmailRequest(array $emailData): array
    {
        return $this->httpClient->post(
            "{$this->apiUrl}/smtp/email",
            [
                'Content-Type: application/json',
                "api-key: " . $this->apiKey,
            ],
            $emailData 
        );
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
