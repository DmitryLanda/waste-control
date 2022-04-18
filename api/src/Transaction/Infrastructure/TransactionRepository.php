<?php

declare(strict_types=1);

namespace App\Transaction\Infrastructure;

use App\Transaction\Domain\Repository\TransactionRepositoryInterface;
use App\Transaction\Infrastructure\Orm\Transaction;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class TransactionRepository implements TransactionRepositoryInterface
{
    private ObjectRepository $ormRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->ormRepository = $this->entityManager->getRepository(Transaction::class);
    }

    public function findByAccountId(string $accountId): array
    {
        return $this->ormRepository->findBy(
            ['accountId' => $accountId],
            ['createdAt' => 'desc']
        );
    }

    public function addTransaction(
        string            $userId,
        string            $accountId,
        float             $amount,
        DateTimeInterface $createdAt,
        ?string           $comment,
        ?array            $tags
    ): void {
        $entity = new Transaction();
        $entity->setUserId($userId)
            ->setAccountId($accountId)
            ->setAmount($amount)
            ->setCreatedAt($createdAt)
            ->setComment($comment)
            ->setTags($tags)
        ;

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}