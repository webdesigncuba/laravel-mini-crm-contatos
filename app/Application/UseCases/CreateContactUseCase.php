<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Contact;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Status;
use App\Domain\Repositories\ContactRepositoryInterface;

class CreateContactUseCase
{
    public function __construct(private ContactRepositoryInterface $repository) {}

    public function execute(string $name, string $email, string $phone): Contact
    {
        $contact = new Contact(
            name: $name,
            email: new Email($email),
            phone: new Phone($phone),
            status: new Status('pending')
        );

        return $this->repository->save($contact);
    }
}
