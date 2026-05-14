<?php

namespace App\Domain\ValueObjects;

class Phone
{
    public function __construct(private string $value)
    {
        $digits = preg_replace('/\D/', '', $value);

        if (!preg_match('/^\d{10,11}$/', $digits)) {
            throw new \InvalidArgumentException("Telefone inválido");
        }

        $this->value = $digits;
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

    public function __toString()
    {
        return $this->value;
    }
}
