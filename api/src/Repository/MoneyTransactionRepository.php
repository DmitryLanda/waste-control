<?php

namespace App\Repository;

use App\Entity\MoneyTransaction;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MoneyTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyTransaction[]    findAll()
 * @method MoneyTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoneyTransaction::class);
    }

    public function getExpensesForPeriod(DateTimeInterface $start = null, DateTimeInterface $end = null): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.type = :expense')
            ->setParameter('expense', MoneyTransaction::TYPE_EXPENSE)
        ;

        if ($start) {
            $qb->andWhere('t.createdAt >= :morning')
                ->setParameter('morning', $start)
            ;
        }

        if ($end) {
            $qb->andWhere('t.createdAt <= :midnight')
                ->setParameter('midnight', $end)
            ;
        }

        $qb->orderBy('t.createdAt', 'asc')
            ->addOrderBy('t.category', 'asc')
            ->addOrderBy('t.id', 'asc')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
