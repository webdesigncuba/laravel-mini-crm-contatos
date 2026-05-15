<?php

namespace App\Infrastructure\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domain\Events\ContactScoreProcessed;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Services\ScoreCalculator;

class ProcessContactScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $contactId;

    public function __construct(int $contactId)
    {
        $this->contactId = $contactId;
    }

    public function handle(
        ContactRepositoryInterface $contactRepository,
        ScoreCalculator $calculateScoreService
    ): void {
        $contact = $contactRepository->findById($this->contactId);
        $contact->markAsProcessing();
        $contactRepository->update($contact);

        try {
            sleep(2);
            $score = $calculateScoreService->calculate($contact);
            $contact->markAsActive($score);
            $contactRepository->update($contact);
            event(new ContactScoreProcessed($contact));
        } catch (\Throwable $e) {
            $contact->markAsFailed();
            $contactRepository->update($contact);
        }
    }
}
