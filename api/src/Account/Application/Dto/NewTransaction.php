<?php

declare(strict_types=1);

namespace App\Account\Application\Dto;

final class NewTransaction
{
    public function __construct(
        private float $amount,
        private ?string $comment,
        private ?array $tags
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getTags(): array
    {
        return $this->tags ?? [];
    }

    public function isPositive(): bool
    {
        return $this->amount >= 0;
    }
}