<?php

namespace App\Repository;

use App\Entity\Expense;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expense::class);
    }

    public function getExpensesForPeriod(DateTimeInterface $start = null, DateTimeInterface $end = null): array
    {
        $qb = $this->createQueryBuilder('e');
        if ($start) {
            $qb->andWhere('e.createdAt >= :morning')
                ->setParameter('morning', $start)
            ;
        }

        if ($end) {
            $qb->andWhere('e.createdAt <= :midnight')
                ->setParameter('midnight', $end)
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function getExpenseCategories(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.category')
            ->distinct()
            ->orderBy('e.category', 'asc')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
