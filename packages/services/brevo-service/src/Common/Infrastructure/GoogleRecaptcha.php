<?php

namespace App\Common\Infrastructure;

final class GoogleRecaptcha 
{
    public function __construct(readonly CurlHttpClient $curlHttpClient) {}
    public function validateRecaptcha(string $recaptchaToken): bool
    {
        $secret = getenv('GOOGLE_RECAPTCHA');
        $response = $this->curlHttpClient->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [],
            [
                'secret' => $secret,
                'response' => $recaptchaToken,
            ],
        );
    
        $result = json_decode($response['body'], true);
        return $result['success'] && $result['score'] >= 0.5;
    }
    
}
