<?php

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => (string) $this->email,
            'phone'        => (string) $this->phone,
            'status'       => (string) $this->status,
            'score'        => $this->score,
            'processed_at' => $this->processed_at,
        ];
    }
}
