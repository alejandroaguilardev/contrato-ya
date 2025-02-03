<?php

namespace App\Common\Infrastructure;

use App\Common\Domain\HttpClient;

final class CurlHttpClient implements HttpClient
{
    public function post(string $url, array $headers = [], array $data = []): array
    {
        $ch = curl_init();

        $jsonData = json_encode($data);

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $jsonData,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Error en la solicitud cURL: " . $errorMessage);
        }

        curl_close($ch);

        return [
            'status_code' => $httpCode,
            'body' => $response,
        ];
    }
}
