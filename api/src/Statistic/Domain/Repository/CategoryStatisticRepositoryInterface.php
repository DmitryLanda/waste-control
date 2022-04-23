<?php

declare(strict_types=1);

namespace App\Statistic\Domain\Repository;

interface CategoryStatisticRepositoryInterface
{
    public function getTopCategories(string $account, int $page, int $limit): array;

    public function recordCategoryUsage(string $userId, string $accountId, array $categories): void;
}