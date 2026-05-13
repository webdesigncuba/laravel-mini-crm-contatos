<?php

namespace App\Domain\Services;

use App\Domain\Entities\Contact;

class ScoreCalculator
{
    public function calculate(Contact $contact): int
    {
        $score = 0;

        // Verifica se o e-mail é corporativo (não gmail/hotmail/yahoo) → +20 pontos
        if ($contact->email->isCorporate()) {
            $score += 20;
        }

        // Verifica se o e-mail termina em .br → +10 pontos
        if ($contact->email->isBrazilianDomain()) {
            $score += 10;
        }

        // Verifica se o nome é completo (mais de uma palavra) → +10 pontos
        if (str_word_count($contact->name) > 1) {
            $score += 10;
        }

        // Verifica se o telefone tem DDD válido de SP (11–19) → +20 pontos
        // Caso contrário, outros estados → +10 pontos
        $score += $contact->phone->isFromSaoPaulo() ? 20 : 10;

        // Sempre retorna o score calculado
        return $score;
    }
}
