<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;



class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_contact_via_api()
    {
        // Datos de entrada simulados
        $payload = [
            'name'  => 'João Silva',
            'email' => 'joao@empresa.com.br',
            'phone' => '11987654321',
        ];

        // Ejecuta el endpoint POST /api/contacts
        $response = $this->postJson('/api/contacts', $payload);

        // Valida que la respuesta sea 201 Created
        $response->assertStatus(201);

        // Valida que el JSON tenga los campos esperados
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone',
                'status',
                'score',
                'processed_at',
            ]
        ]);

        // Valida que el contacto se haya guardado en la base de datos
        $this->assertDatabaseHas('contacts', [
            'email' => 'joao@empresa.com.br',
            'phone' => '11987654321',
        ]);
    }
}
