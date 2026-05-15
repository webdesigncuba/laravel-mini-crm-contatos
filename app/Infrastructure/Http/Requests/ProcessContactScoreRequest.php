<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessContactScoreRequest extends FormRequest
{
    public function authorize(): bool
    {

        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['integer', 'exists:contacts,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.integer'  => 'O ID deve ser um número inteiro.',
            'id.exists'   => 'Contato não encontrado.',
        ];
    }
}
