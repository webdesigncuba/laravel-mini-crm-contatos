<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\CreateContactUseCase;
use App\Infrastructure\Http\Requests\ContactRequest;
use App\Infrastructure\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct(private CreateContactUseCase $createContactUseCase) {}

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
}
