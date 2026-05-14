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
            'email'        => method_exists($this->email, '__toString') ? (string) $this->email : $this->email,
            'phone'        => method_exists($this->phone, '__toString') ? (string) $this->phone : $this->phone,
            'status'       => method_exists($this->status, '__toString') ? (string) $this->status : $this->status,
            'score'        => $this->score,
            'processed_at' => $this->processedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
