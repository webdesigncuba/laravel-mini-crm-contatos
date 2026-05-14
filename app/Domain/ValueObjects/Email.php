<?php

namespace App\Domain\ValueObjects;

class Email
{
    public function __construct(private string $value)
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("e-mail inválido");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isCorporate(): bool
    {
        return !preg_match('/@(gmail|hotmail|yahoo)\./', $this->value);
    }

    public function isBrazilianDomain(): bool
    {
        return str_ends_with($this->value, '.br');
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
