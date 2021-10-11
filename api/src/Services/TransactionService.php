<?php

namespace App\Services;

use App\Dto\MoneyRequest;
use App\Entity\MoneyTransaction;
use Doctrine\ORM\EntityManagerInterface;

class TransactionService
{
    public function __construct(private EntityManagerInterface $em, private MoneyParser $expenseParser)
    {

    }

    public function add(MoneyRequest $request): MoneyTransaction
    {
        $expense = $this->expenseParser->parseTransaction($request->expression);

        $this->em->persist($expense);
        $this->em->flush();

        return $expense;
    }
}