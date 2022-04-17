<?php

declare(strict_types=1);

namespace App\Account\Http;

final class Transaction
{
    public function __construct(
        private float $amount,
        private string $comment = ''
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function isPositive(): bool
    {
        return $this->amount >= 0;
    }
}