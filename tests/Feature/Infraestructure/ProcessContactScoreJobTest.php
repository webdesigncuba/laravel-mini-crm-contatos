<?php

namespace Tests\Feature\Infraestructure;

use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Models\Contact as ContactModel;
use App\Infrastructure\Jobs\ProcessContactScoreJob;

use Tests\TestCase;

class ProcessContactScoreJobTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_dispatches_process_contact_score_job()
    {

        Bus::fake();

        // Creamos un contacto de prueba
        $contact = ContactModel::factory()->create();

        // Disparamos el endpoint
        $response = $this->postJson("/api/contacts/{$contact->id}/process-score");

        // Validamos que la respuesta sea la esperada
        $response->assertStatus(202); // o 200 según tu controlador

        // Validamos que el Job fue encolado con el contacto correcto
        Bus::assertDispatched(ProcessContactScoreJob::class, function ($job) use ($contact) {
            return $job->contactId === $contact->id;
        });
    }
}
