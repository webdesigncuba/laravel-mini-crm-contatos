<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\CreateContactUseCase;
use Illuminate\Http\Request as ContactRequest;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct(private CreateContactUseCase $createContactUseCase) {}

    public function store(ContactRequest $request)
    {
        // Ejecuta el caso de uso con datos validados
        $contact = $this->createContactUseCase->execute($request->validated());

        // Devuelve el recurso en formato JSON
        return response()->json($contact, 201);
    }
}
