<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class ContactScoreProcessedLogTest extends TestCase
{
    public function test_listener_logs_contact_score_processed()
    {
        Log::spy();

        $contact = new \App\Domain\Entities\Contact(
            name: 'Test',
            email: new \App\Domain\ValueObjects\Email('test@example.com'),
            phone: new \App\Domain\ValueObjects\Phone('12345678911'),
            id: 1
        );

        $event = new \App\Domain\Events\ContactScoreProcessed($contact);
        $listener = new \App\Infrastructure\Listeners\LogContactScoreProcessed();
        $listener->handle($event);

        Log::shouldHaveReceived('info')->withArgs(function ($message, $context) use ($contact) {
            return $message === 'Contact processed'
                && $context['id'] === $contact->id;
        });
    }

}
