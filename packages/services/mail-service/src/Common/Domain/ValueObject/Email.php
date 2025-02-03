<?php

namespace App\Common\Domain\ValueObject;

class Email
{

    public function __construct(readonly string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('El formato del email es inválido', 400);
        }

    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Email $otherEmail): bool
    {
        return $this->value === $otherEmail->value;
    }
}
