<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Infrastructure\Models\Contact as ContactModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_can_create_a_contact()
    {
        $payload = [
            'name' => 'David Test',
            'email' => 'david@example.com',
            'phone' => '61999999999',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/contacts', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
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
    }


    public function test_it_can_list_contacts()
    {
        ContactModel::factory()->count(3)->create();

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }


    /*public function test_it_can_show_a_contact()
    {
        $contact = ContactModel::factory()->create();

        $response = $this->getJson("/api/contacts/{$contact->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
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
    }*/

    public function test_it_can_update_a_contact()
    {
        $contact = ContactModel::factory()->create();

        $payload = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '6199999999',
            'status' => 'pending',
        ];

        $response = $this->putJson("/api/contacts/{$contact->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Updated Name',
                     'email' => 'updated@example.com',
                     'phone' => '6199999999',
                     'status' => 'pending',
                 ]);
    }

    public function test_it_can_delete_a_contact()
    {
        $contact = ContactModel::factory()->create();

        $response = $this->deleteJson("/api/contacts/{$contact->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('contacts', ['id' => $contact->id]);
    }
}

