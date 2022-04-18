<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Repository;

use App\Transaction\Domain\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * @return array<Transaction>
     */
    public function findByAccountId(string $accountId): array;
}