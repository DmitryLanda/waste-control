<?php

declare(strict_types=1);

namespace App\Statistic\Application;

use App\Shared\Dto\Pagination;
use App\Statistic\Application\Dto\CategoryResponse;
use App\Statistic\Application\Dto\StatisticResponse;
use App\Statistic\Domain\Category;
use App\Statistic\Domain\Repository\CategoryStatisticRepositoryInterface;
use App\Statistic\Domain\Repository\StatisticSpanRepositoryInterface;
use App\Statistic\Domain\StatisticSpan;

class StatisticService
{
    public function __construct(
        private StatisticSpanRepositoryInterface $spanRepository,
        private CategoryStatisticRepositoryInterface $categoryRepository
    ) {
    }

    public function getAccountStats(string $account): array
    {
        return array_map(function (StatisticSpan $span) {
            return StatisticResponse::fromDomain($span);
        }, $this->spanRepository->getAccountStats($account));
    }

    public function getTopCategories(string $account, Pagination $pagination): array
    {
        $categories = $this->categoryRepository->getTopCategories(
            $account,
            $pagination->getPage(),
            $pagination->getLimit()
        );

        return array_map(function (Category $category) {
            return CategoryResponse::fromDomain($category);
        }, $categories);
    }
}