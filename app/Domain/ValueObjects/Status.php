<?php

namespace App\Domain\ValueObjects;

class Status
{
    private const ALLOWED = ['pending', 'processing', 'active', 'failed'];

    public function __construct(private string $value)
    {
        if (!in_array($value, self::ALLOWED)) {
            throw new \InvalidArgumentException("Status inválido");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

}
