<?php

declare(strict_types=1);

namespace App\Statistic\Application;

use App\Statistic\Application\Dto\StatisticResponse;
use App\Statistic\Domain\Repository\StatisticRepositoryInterface;
use App\Statistic\Domain\StatisticSpan;

class StatisticService
{
    public function __construct(private StatisticRepositoryInterface $repository)
    {
    }

    public function getAccountStats(string $account): array
    {
        return array_map(function (StatisticSpan $span) {
            return StatisticResponse::fromDomain($span);
        }, $this->repository->getAccountStats($account));
    }
}