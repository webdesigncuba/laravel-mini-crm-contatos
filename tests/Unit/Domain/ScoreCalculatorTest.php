<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Contact;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\Services\ScoreCalculator;

class ScoreCalculatorTest extends TestCase
{
    public function test_calculate_score_for_corporate_email()
    {
        // Criamos um contato com e-mail corporativo, domínio .br, nome completo e DDD de São Paulo
        $contact = new Contact(
            name: "Juan Pérez",
            email: new Email("juan@empresa.com.br"),
            phone: new Phone("11987654321"),
        );

        // Instanciamos o serviço responsável por calcular o score
        $calculator = new ScoreCalculator();

        // Executamos o cálculo de score para o contato
        $score = $calculator->calculate($contact);

        // Esperamos que o resultado seja:
        // +20 pontos (e-mail corporativo)
        // +10 pontos (domínio .br)
        // +10 pontos (nome completo)
        // +20 pontos (DDD válido de SP)
        // Total esperado = 60
        $this->assertEquals(60, $score);
    }
}
