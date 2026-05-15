<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessContactScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Aqui você pode aplicar regras de autorização
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:contacts,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID do contato é obrigatório.',
            'id.integer'  => 'O ID deve ser um número inteiro.',
            'id.exists'   => 'Contato não encontrado.',
        ];
    }
}
