<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\UserRepositoryInterface;
use App\User\Infrastructure\Orm as Orm;
use App\User\Domain as Domain;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository implements UserRepositoryInterface
{
    private ObjectRepository $ormRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->ormRepository = $this->entityManager->getRepository(Orm\User::class);
    }

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