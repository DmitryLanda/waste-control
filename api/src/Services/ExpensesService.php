<?php

namespace App\Services;

use App\Dto\ExpenseRequest;
use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ExpensesService
{
    public function __construct(private EntityManagerInterface $em)
    {

    }

    public function add(ExpenseRequest $request): Expense
    {
        $expense = new Expense();
        $expense->setValue($request->value)
            ->setCategory($request->category)
            ->setCreatedAt($request->getDate())
        ;

        $this->em->persist($expense);
        $this->em->flush();

        return $expense;
    }
}