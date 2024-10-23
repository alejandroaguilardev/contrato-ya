<?php

namespace App\SendEmail\Domain\ValueObject;

final class ContactName
{

    public function __construct(readonly string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('El nombre no puede estar vacío.', 400);
        }
    }
}
