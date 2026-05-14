<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\CreateContactUseCase;
use App\Application\UseCases\UpdateContactUseCase;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Infrastructure\Http\Requests\ContactRequest;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Resources\ContactResource;
use App\Infrastructure\Models\Contact as ModelsContact;

class ContactController extends Controller
{

    public function __construct(
        private CreateContactUseCase $createContactUseCase,
        private UpdateContactUseCase $updateContactUseCase,
        private ContactRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function index()
    {
        $contacts = ModelsContact::paginate(10);
        return ContactResource::collection($contacts);
    }

    public function store(ContactRequest $request)
    {

        $data = $request->validated();
        $contact = $this->createContactUseCase->execute(
            $data['name'],
            $data['email'],
            $data['phone'] ?? null
        );

        return response()->json([
            'data' => [
                'id'           => $contact->id,
                'name'         => $contact->name,
                'email'        => $contact->email->value(),
                'phone'        => $contact->phone->value(),
                'status'       => $contact->status->value(),
                'score'        => $contact->score,
                'processed_at' => $contact->processedAt?->format('Y-m-d H:i:s'),
            ]
        ], 201);
    }

    public function update(ContactRequest $request, int $id)
    {
        $contact = $this->updateContactUseCase->execute($id, $request->validated());
        return new ContactResource($contact);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(null, 204);
    }

}
