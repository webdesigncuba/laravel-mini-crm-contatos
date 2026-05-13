<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Services\ScoreCalculator;
use App\Domain\Events\ContactScoreProcessed;

use App\Domain\ValueObjects\Status;

class CalculateScoreUseCase
{
    public function __construct(
        private ContactRepositoryInterface $repository,
        private ScoreCalculator $calculator
    ) {}

    public function execute(Contact $contact): Contact
    {
        try {
            // Calcula o score usando o serviço de domínio
            $score = $this->calculator->calculate($contact);

            // Atualiza o estado e a data de processamento usando o Value Object Status
            $contact->score = $score;
            $contact->status = new Status('active');
            $contact->processed_at = now();

            // Persiste as alterações no repositório
            $this->repository->update($contact);

            // Dispara o evento de domínio para que listeners reajam
            event(new ContactScoreProcessed($contact));

            return $contact;
        } catch (\Throwable $e) {
            // Em caso de erro, marca o contato como "failed" usando o Value Object Status
            $contact->status = new Status('failed');
            $this->repository->update($contact);

            // Propaga a exceção para tratamento externo
            throw $e;
        }
    }
}
