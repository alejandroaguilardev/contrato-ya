<?php

namespace App\Subscribe\Infrastructure\Validators;

use App\Common\Domain\ValueObject\Email;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionRequestValidator
{
    public function validate(Request $request): Email
    {
        $data = json_decode($request->getContent(), true);
        $email = new Email($data['email']);
        return $email;
    }
}
