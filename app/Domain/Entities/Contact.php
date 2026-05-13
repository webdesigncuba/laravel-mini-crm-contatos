<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\Status;
use DateTimeInterface;

class Contact
{
    public function __construct(
        public string $name,
        public Email $email,
        public Phone $phone,
        public int $score = 0,
        public Status $status = new Status('pending'),
        public ?DateTimeInterface $processedAt = null,
    ) {}

    public function markAsProcessing(): void
    {
        $this->status = new Status('processing');
    }

    public function markAsActive(int $score): void
    {
        $this->status = new Status('active');
        $this->score = $score;
        $this->processedAt = new \DateTimeImmutable();
    }

    public function markAsFailed(): void
    {
        $this->status = new Status('failed');
        $this->processedAt = new \DateTimeImmutable();
    }
}
