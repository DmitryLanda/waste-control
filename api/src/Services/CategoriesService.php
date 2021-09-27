<?php

namespace App\Services;

use App\Dto\ExpenseRequest;
use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CategoriesService
{
    public function __construct(private ExpenseRepository $repository)
    {

    }

    public function getCategories(): array
    {
        return array_map(
            function (array $item) {
                return $item['category'];
            },
            $this->repository->getExpenseCategories()
        );
    }
}