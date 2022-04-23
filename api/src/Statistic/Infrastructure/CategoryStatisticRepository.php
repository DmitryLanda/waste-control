<?php

declare(strict_types=1);

namespace App\Statistic\Infrastructure;

use App\Statistic\Domain\Category;
use App\Statistic\Domain\Repository\CategoryStatisticRepositoryInterface;
use App\Statistic\Infrastructure\Orm\CategoryStatistic;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class CategoryStatisticRepository implements CategoryStatisticRepositoryInterface
{
    private ObjectRepository $ormRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->ormRepository = $this->entityManager->getRepository(CategoryStatistic::class);
    }

    public function getTopCategories(string $account, int $page, int $limit): array
    {
        $entities = $this->ormRepository->findBy(
            ['accountId' => $account],
            ['counter' => 'desc'],
            $limit,
            ($page - 1) * $limit
        );

        return array_map(function (CategoryStatistic $entity) {
            return new Category($entity->getName());
        }, $entities);
    }

    public function recordCategoryUsage(string $userId, string $accountId, array $categories): void
    {
        $valuesToInsert = [];
        $parameters = ['user' => $userId, 'account' => $accountId];
        foreach ($categories as $i => $category) {
            $valuesToInsert[] = "(:user, :account,  :cat$i, 1)";
            $parameters["cat$i"] = strtolower($category);
        }
        $valuesToInsert = implode(', ', $valuesToInsert);

        $sql = "insert into category_stats (user_id, account_id, name, counter) 
            values $valuesToInsert
            on conflict on constraint unique_category_stat DO UPDATE set 
                counter = category_stats.counter + 1";

        $this->entityManager->getConnection()->executeQuery($sql, $parameters);
    }
}