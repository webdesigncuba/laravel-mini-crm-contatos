<?php

namespace App\Domain\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Domain\Entities\Contact;

class ContactScoreProcessed implements ShouldBroadcast
{
    use SerializesModels;

    public Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function broadcastOn()
    {
       return [new Channel("contacts.{$this->contact->id}")];
    }

    public function broadcastWith()
    {
        // Payload enviado al frontend
        return [
            'id' => $this->contact->id,
            'name' => $this->contact->name,
            'email' => (string) $this->contact->email,
            'phone' => (string) $this->contact->phone,
            'status' => (string) $this->contact->status,
            'score' => $this->contact->score,
            'processedAt' => $this->contact->processedAt?->format('Y-m-d H:i:s'),
        ];
    }
}

