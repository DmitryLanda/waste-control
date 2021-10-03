<?php

namespace App\Services;

use App\Dto\ExpenseRequest;
use App\Entity\Expense;
use Doctrine\ORM\EntityManagerInterface;

class ExpensesService
{
    public function __construct(private EntityManagerInterface $em, private ExpenseParser $expenseParser)
    {

    }

    public function add(ExpenseRequest $request): Expense
    {
        $expense = $this->expenseParser->parse($request->expression);

        $this->em->persist($expense);
        $this->em->flush();

        return $expense;
    }
}