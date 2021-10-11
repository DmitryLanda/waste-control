<?php

namespace App\Services;

use App\Dto\MoneyRequest;
use App\Entity\Expense;
use Doctrine\ORM\EntityManagerInterface;

class ExpensesService
{
    public function __construct(private EntityManagerInterface $em, private MoneyParser $expenseParser)
    {

    }

    public function add(MoneyRequest $request): Expense
    {
        $expense = $this->expenseParser->parseExpense($request->expression);

        $this->em->persist($expense);
        $this->em->flush();

        return $expense;
    }
}