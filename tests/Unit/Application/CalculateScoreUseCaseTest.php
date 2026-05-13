<?php

namespace Tests\Unit\Application;

use Tests\TestCase;
use App\Application\UseCases\CalculateScoreUseCase;
use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Services\ScoreCalculator;
use App\Domain\Events\ContactScoreProcessed;
use Illuminate\Support\Facades\Event;

class CalculateScoreUseCaseTest extends TestCase
{
    public function test_deve_calcular_score_e_disparar_evento()
    {
        // Fake de eventos para verificar se o evento foi disparado
        Event::fake();

        // Criamos um contato inicial (entidade de domínio)
        $contact = new Contact(
            name: "João Silva",
            email: new \App\Domain\ValueObjects\Email("joao@empresa.com.br"),
            phone: new \App\Domain\ValueObjects\Phone("11987654321"),
        );

        // Mock do repositório para não depender de banco de dados
        $repository = $this->createMock(ContactRepositoryInterface::class);
        $repository->method('update')->willReturnCallback(function (Contact $c) {
            return $c; // retorna o mesmo contato atualizado
        });

        // Usamos o ScoreCalculator real para validar a regra de negócio
        $calculator = new ScoreCalculator();

        // Instanciamos o caso de uso com o repositório mockado e o serviço real
        $useCase = new CalculateScoreUseCase($repository, $calculator);

        // Executamos o caso de uso
        $updatedContact = $useCase->execute($contact);

        // Validações esperadas:
        // - Score calculado corretamente
        $this->assertEquals(60, $updatedContact->score);
        // - Status atualizado para "active"
        $this->assertEquals('active', $updatedContact->status->value());
        $this->assertNotNull($updatedContact->processed_at);

        // Verificamos que o evento foi disparado
        Event::assertDispatched(ContactScoreProcessed::class);
    }
}

