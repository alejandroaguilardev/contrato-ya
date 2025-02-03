<?php

namespace App\Common\Domain;

interface HttpClient
{
    public function post(string $url, array $headers = [], array $data = []): array;
}
