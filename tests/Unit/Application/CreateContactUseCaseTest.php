<?php

namespace Tests\Unit\Application;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Application\UseCases\CreateContactUseCase;



class CreateContactUseCaseTest extends TestCase
{
   public function test_should_create_contact_with_pending_status_and_score_zero()
    {
        // Mock do repositório (não queremos usar banco real aqui)
        $repository = $this->createMock(ContactRepositoryInterface::class);

        // Configuramos o mock para retornar o mesmo contato que receber
        $repository->method('save')->willReturnCallback(function (Contact $contact) {
            return $contact;
        });

        // Instanciamos o Use Case com o mock
        $useCase = new CreateContactUseCase($repository);

        // Executamos o caso de uso
        $contact = $useCase->execute(
            name: "Maria Silva",
            email: "maria@empresa.com.br",
            phone: "11987654321"
        );

        // Validações esperadas
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertEquals("Maria Silva", $contact->name);
        $this->assertEquals("maria@empresa.com.br", $contact->email->value());
        $this->assertEquals("11987654321", $contact->phone->value());
        $this->assertEquals(0, $contact->score);
        $this->assertEquals("pending", $contact->status->value());
    }
}
