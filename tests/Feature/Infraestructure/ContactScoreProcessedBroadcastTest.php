<?php

namespace Tests\Feature\Infrastructure;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Infrastructure\Models\Contact as ContactModel;
use App\Infrastructure\Jobs\ProcessContactScoreJob;
use App\Domain\Events\ContactScoreProcessed;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Services\ScoreCalculator;

class ContactScoreProcessedBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_broadcasts_contact_score_processed_event()
    {
        Event::fake();

        $contact = ContactModel::factory()->create();

        $job = new ProcessContactScoreJob($contact->id);
        $job->handle(
            app(ContactRepositoryInterface::class),
            app(ScoreCalculator::class)
        );

        Event::assertDispatched(ContactScoreProcessed::class, function ($event) use ($contact) {
            return $event->broadcastOn()[0]->name === "contacts.{$contact->id}"
                && $event->broadcastWith()['id'] === $contact->id;
        });
    }
}

