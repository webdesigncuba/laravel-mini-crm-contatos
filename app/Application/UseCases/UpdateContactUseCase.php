<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;

class UpdateContactUseCase
{
    public function __construct(
        private ContactRepositoryInterface $repository
    ) {}

    public function execute(int $id, array $data): Contact
    {
        $contact = $this->repository->findById($id);

        // Actualiza los campos permitidos
        if (isset($data['name'])) {
            $contact->name = $data['name'];
        }
        if (isset($data['email'])) {
            $contact->email = new \App\Domain\ValueObjects\Email($data['email']);
        }
        if (isset($data['phone'])) {
            $contact->phone = new \App\Domain\ValueObjects\Phone($data['phone']);
        }
        if (isset($data['status'])) {
            $contact->status = new \App\Domain\ValueObjects\Status($data['status']);
        }
        if (isset($data['score'])) {
            $contact->score = $data['score'];
        }

        return $this->repository->update($contact);
    }
}
