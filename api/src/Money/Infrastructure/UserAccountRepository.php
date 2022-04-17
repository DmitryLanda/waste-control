<?php

declare(strict_types=1);

namespace App\Money\Infrastructure;

use App\Money\Domain\Repository\UserAccountRepositoryInterface;
use App\Money\Infrastructure\Orm\UserAccount;
use Doctrine\ORM\EntityManagerInterface;

class UserAccountRepository implements UserAccountRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    public function save(string $userId, string $accountId): void
    {
        $entity = new UserAccount();
        $entity->setUserId($userId)
            ->setAccountId($accountId)
            ->setAmount(0)
        ;

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function incrementBalance(string $userId, string $accountId, float $amount): void
    {
        $this->entityManager
            ->createQuery(
                "UPDATE App\Money\Infrastructure\Orm\UserAccount ua
                SET ua.amount = ua.amount + $amount 
                WHERE ua.userId = :userId 
                AND ua.accountId = :accountId"
            )
            ->setParameter('userId', $userId)
            ->setParameter('accountId', $accountId)
            ->execute()
        ;
    }

    public function decrementBalance(string $userId, string $accountId, float $amount): void
    {
        $this->entityManager
            ->createQuery(
                "UPDATE App\Money\Infrastructure\Orm\UserAccount ua
                SET ua.amount = ua.amount - $amount 
                WHERE ua.userId = :userId 
                AND ua.accountId = :accountId"
            )
            ->setParameter('userId', $userId)
            ->setParameter('accountId', $accountId)
            ->execute()
        ;
    }
}