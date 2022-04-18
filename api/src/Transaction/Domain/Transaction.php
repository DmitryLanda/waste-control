<?php

declare(strict_types=1);

namespace App\Transaction\Domain;

use DateTimeInterface;

final class Transaction
{
    public function __construct(
        private string            $userId,
        private string            $accountId,
        private DateTimeInterface $createdAt,
        private float             $amount,
        private string            $comment,
        private ?array            $tags = null,
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }
}