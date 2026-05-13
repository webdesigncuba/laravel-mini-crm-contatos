<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Infrastructure\Models\Contact as ModelsContact;

class EloquentContactRepository implements ContactRepositoryInterface
{
    public function create(Contact $contact): Contact
    {
        $model = ModelsContact::create([
            'name'        => $contact->name,
            'email'       => $contact->email->value(),   // ✅ string
            'phone'       => $contact->phone->value(),   // ✅ string
            'status'      => $contact->status->value(),
            'score'       => $contact->score,
            'processed_at'=> $contact->processedAt?->format('Y-m-d H:i:s'),
        ]);

        return $this->toEntity($model);
    }

    public function update(Contact $contact): Contact
    {
        $model = ModelsContact::findOrFail($contact->id);

        $model->update([
            'name'        => $contact->name,
            'email'       => $contact->email->value(),   // ✅ string
            'phone'       => $contact->phone->value(),   // ✅ string
            'status'      => $contact->status->value(),
            'score'       => $contact->score,
            'processed_at'=> $contact->processedAt?->format('Y-m-d H:i:s'),
        ]);

        return $this->toEntity($model);
    }

    public function findById(int $id): ?Contact
    {
        $model = ModelsContact::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function save(Contact $contact): Contact
    {
        return $contact->id ? $this->update($contact) : $this->create($contact);
    }

    public function paginate(int $perPage = 15): array
    {
        $paginator = ModelsContact::paginate($perPage);

        return [
            'data' => array_map(fn($model) => $this->toEntity($model), $paginator->items()),
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
        ];
    }

    public function delete(Contact $contact): void
    {
        ModelsContact::destroy($contact->id);
    }

    private function toEntity(ModelsContact $model): Contact
    {
        return new Contact(
            id: $model->id,
            name: $model->name,
            email: new \App\Domain\ValueObjects\Email($model->email),
            phone: new \App\Domain\ValueObjects\Phone($model->phone),
            status: new \App\Domain\ValueObjects\Status($model->status),
            score: $model->score,
            processedAt: $model->processed_at,
        );
    }
}
