<?php

namespace App\Domain\ValueObjects;

class Phone
{
    public function __construct(private string $value)
    {
        if (!preg_match('/^\d{10,11}$/', $value)) {
            throw new \InvalidArgumentException("Teléfone inválido");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function ddd(): string
    {
        return substr($this->value, 0, 2);
    }

    public function isFromSaoPaulo(): bool
    {
        return in_array($this->ddd(), range(11, 19));
    }
}
