<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Repository;

use App\Transaction\Domain\Transaction;
use DateTimeInterface;

interface TransactionRepositoryInterface
{
    /**
     * @return array<Transaction>
     */
    public function findByAccountId(string $accountId): array;

    public function addTransaction(
        string $userId,
        string $accountId,
        float $amount,
        DateTimeInterface $createdAt,
        ?string $comment,
        ?array $tags
    ): void;
}