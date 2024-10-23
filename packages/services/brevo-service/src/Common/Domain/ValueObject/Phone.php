<?php

namespace App\Common\Domain\ValueObject;

final class Phone
{

    public function __construct(readonly string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('El teléfono no puede estar vacío.', 400);
        }
    }

}
