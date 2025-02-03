<?php

namespace App\Common\Domain;

interface MailService
{
    public function sendMail(string $to, string $subject, string $message);
}
