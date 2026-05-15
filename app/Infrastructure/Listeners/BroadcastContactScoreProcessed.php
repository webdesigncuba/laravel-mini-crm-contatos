<?php

namespace App\Infrastructure\Listeners;

use App\Domain\Events\ContactScoreProcessed;
use Illuminate\Support\Facades\Broadcast;

class BroadcastContactScoreProcessed
{
    public function handle(ContactScoreProcessed $event): void
    {
        $contact = $event->contact;

        Broadcast::channel("contacts.{$contact->id}", [
            'id'     => $contact->id,
            'email'  => (string) $contact->email,
            'score'  => $contact->score,
            'status' => (string) $contact->status,
        ]);
    }
}
