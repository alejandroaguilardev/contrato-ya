<?php

namespace App\SendEmail\Domain\ValueObject;

final class ContactMessage
{
    public function __construct(readonly string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('El mensaje no puede estar vacía.', 400);
        }
    }
}
