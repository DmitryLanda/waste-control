<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\UserRepositoryInterface;
use App\User\Infrastructure\Orm as Orm;
use App\User\Domain as Domain;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Orm\UserRepository $ormRepository
    ) {}

    public function findOneById(string $id): ?Domain\User
    {
        /** @var Orm\User $entity */
        $entity = $this->ormRepository->findOneBy(['id' => $id]);

        return $entity
            ? new Domain\User(
                $entity->getId(),
                $entity->getFullName(),
                $entity->getEmail()
            )
            : null
        ;
    }

    public function save(Domain\User $user): void
    {
        $entity = new Orm\User();
        $entity->setId($user->getId());
        $entity->setFullName($user->getFullName());
        $entity->setEmail($user->getEmail());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}