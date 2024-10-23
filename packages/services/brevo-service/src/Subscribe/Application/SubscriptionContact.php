<?php

namespace App\Subscribe\Application;

use App\Common\Domain\ErrorDomain;
use App\Common\Domain\HttpClient;
use App\Common\Domain\ValueObject\Email;

final class SubscriptionContact
{

    public function __construct(readonly HttpClient $httpClient, readonly string $apiKey, readonly string $apiUrl, readonly string $listSubscribe)
    { }

    public function subscribe(Email $email): string
    {

        $subscriptionData = [
            'email' => $email->value,
            'listIds' => array_map('intval', explode(",", $this->listSubscribe)),
            'updateEnabled' => true,
        ];

        $response  = $this->httpClient->post(
            "{$this->apiUrl}/contacts", 
            [
                'Content-Type: application/json',
                "api-key: ". $this->apiKey,
            ],
            $subscriptionData
        );
        

        if ($response["status_code"] < 200 || $response["status_code"] >= 300) {
            $responseBody = json_decode($response["body"], true);
        
            if (is_array($responseBody) && isset($responseBody['message'])) {
                $errorMessage = $responseBody['message'];
            } else {
                $errorMessage = 'Error desconocido: ' . $response["body"];
            }
        
            throw new ErrorDomain("Error en la suscripción: " . $errorMessage);
        }
        
        return "Suscripción exitosa";
    }
}
