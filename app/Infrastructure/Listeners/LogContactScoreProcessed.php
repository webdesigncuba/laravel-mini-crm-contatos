<?php

namespace App\Infrastructure\Listeners;

use App\Domain\Events\ContactScoreProcessed;
use Illuminate\Support\Facades\Log;

class LogContactScoreProcessed
{
    public function handle(ContactScoreProcessed $event): void
    {
        $contact = $event->contact;

        Log::info('Contact processed', [
            'id'     => $contact->id,
            'email'  => (string) $contact->email,
            'score'  => $contact->score,
            'status' => (string) $contact->status,
        ]);
    }
}
