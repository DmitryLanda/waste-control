<?php

declare(strict_types=1);

namespace App\Transaction\Application\Dto;

use App\Transaction\Domain\Transaction;
use DateTimeInterface;

final class TransactionResponse
{
    private function __construct(
        private float             $amount,
        private DateTimeInterface $timestamp,
        private string            $comment,
        private array             $tags = [],
    ) {
    }

    public static function fromDomain(Transaction $transaction): self
    {
        return new self(
            $transaction->getAmount(),
            $transaction->getCreatedAt(),
            $transaction->getComment(),
            $transaction->getTags()
        );
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getTimestamp(): DateTimeInterface
    {
        return $this->timestamp;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}