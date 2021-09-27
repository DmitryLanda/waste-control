<?php

namespace App\Services;

use App\Dto\StatData;
use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use DateTime;
use DateTimeInterface;

class StatisticService
{
    public function __construct(private ExpenseRepository $repository)
    {

    }

    public function statsForPeriod(DateTimeInterface $start, DateTimeInterface $end): StatData
    {
        $expenses = $this->repository->getExpensesForPeriod($start, $end);

        return new StatData(
            StatData::DAILY,
            $start,
            $end,
            $this->getTotal($expenses),
            $this->groupAmountByCategories($expenses)
        );
    }

    private function getTotal(array $expenses): int
    {
        return array_reduce($expenses, function (int $total, Expense $expense) {
            return $total + $expense->getValue();
        }, 0);
    }

    private function groupAmountByCategories(array $expenses): array
    {
        return array_reduce($expenses, function (array $result, Expense $expense) {
            if (!array_key_exists($expense->getCategory(), $result)) {
                $result[$expense->getCategory()] = 0;
            }
            $result[$expense->getCategory()] += $expense->getValue();

            return $result;
        }, []);
    }
}