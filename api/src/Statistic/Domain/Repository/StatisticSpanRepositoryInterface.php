<?php

declare(strict_types=1);

namespace App\Statistic\Domain\Repository;

use DateTimeInterface;

interface StatisticSpanRepositoryInterface
{
    public function updateSpan(
        string $userId,
        string $accountId,
        DateTimeInterface $date,
        float $income,
        float $spends
    ): void;

    public function getAccountStats(string $account): array;
}