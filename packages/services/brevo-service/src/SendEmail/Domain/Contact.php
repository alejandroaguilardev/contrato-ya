<?php

namespace App\SendEmail\Domain;

use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\Phone;
use App\SendEmail\Domain\ValueObject\ContactMessage;
use App\SendEmail\Domain\ValueObject\ContactName;

final class Contact {
    public function __construct(readonly ContactName $name,readonly Email $email,readonly Phone $phone,readonly  ContactMessage $message)
    {
    }
}